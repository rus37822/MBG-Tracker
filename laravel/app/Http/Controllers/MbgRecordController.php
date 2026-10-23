<?php

namespace App\Http\Controllers;

use App\Models\DailyMenu;
use App\Models\MbgRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MbgRecordController extends Controller
{
    public function index(Request $request, string $page = 'summary'): View
    {
        abort_unless(in_array($page, ['summary', 'form', 'history'], true), 404);

        $validated = $request->validate([
            'date' => ['nullable', 'date'],
        ]);

        $selectedDate = Carbon::parse($validated['date'] ?? now()->toDateString())->toDateString();
        $records = MbgRecord::whereDate('waktu_pengambilan', $selectedDate)
            ->latest('waktu_pengambilan')
            ->latest()
            ->get();

        $totalPenerima = $records->count();
        $totalPorsi = $records->sum('jumlah');
        $previousDate = Carbon::parse($selectedDate)->subDay()->toDateString();
        $nextDate = Carbon::parse($selectedDate)->addDay()->toDateString();
        $today = now()->toDateString();
        $chartDate = $selectedDate;
        $hourlyCounts = array_fill(0, 24, 0);

        foreach ($records as $chartRecord) {
            $hour = (int) Carbon::parse($chartRecord->waktu_pengambilan)->format('G');
            $hourlyCounts[$hour]++;
        }

        $dailyRecordCount = array_sum($hourlyCounts);
        $maxHourlyCount = max($hourlyCounts);
        $dailyMenu = DailyMenu::whereDate('menu_date', $today)->first();

        return view('mbg.index', compact(
            'page',
            'records',
            'totalPenerima',
            'totalPorsi',
            'selectedDate',
            'previousDate',
            'nextDate',
            'today',
            'chartDate',
            'hourlyCounts',
            'dailyRecordCount',
            'maxHourlyCount',
            'dailyMenu',
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'kelas' => ['required', 'string', 'max:50'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'waktu_pengambilan' => ['required', 'date'],
            'catatan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['foto'] = $request->file('foto')?->store('mbg-photos', 'public');
        $record = MbgRecord::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Data pengambilan MBG berhasil dicatat.',
                'date' => Carbon::parse($record->waktu_pengambilan)->toDateString(),
            ], 201);
        }

        return redirect()->route('mbg.form')->with('success', 'Data pengambilan MBG berhasil dicatat.');
    }

    public function dailyMenuUpload()
    {
        $today = now()->toDateString();
        $dailyMenu = DailyMenu::whereDate('menu_date', $today)->first();

        return view('mbg.daily-menu', compact('dailyMenu', 'today'));
    }

    public function storeDailyMenu(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'foto_menu' => ['required_without:foto_menu_kamera', 'image', 'max:5120'],
            'foto_menu_kamera' => ['required_without:foto_menu', 'image', 'max:5120'],
        ]);

        $dailyMenu = DailyMenu::firstOrNew(['menu_date' => now()->toDateString()]);
        $previousPhoto = $dailyMenu->foto;
        $photo = $request->file('foto_menu') ?? $request->file('foto_menu_kamera');
        $dailyMenu->foto = $photo->store('daily-menus', 'public');
        $dailyMenu->save();

        if ($previousPhoto) {
            Storage::disk('public')->delete($previousPhoto);
        }

        return redirect()->route('mbg.daily-menu')->with('success', 'Foto menu hari ini berhasil diperbarui.');
    }

    public function destroyDailyMenu(): RedirectResponse
    {
        $dailyMenu = DailyMenu::whereDate('menu_date', now()->toDateString())->firstOrFail();
        $photo = $dailyMenu->foto;
        $dailyMenu->delete();
        Storage::disk('public')->delete($photo);

        return redirect()->route('mbg.daily-menu')->with('success', 'Foto menu hari ini berhasil dihapus.');
    }

    public function exportPdf(string $date)
    {
        $selectedDate = Carbon::parse($date)->startOfDay();

        $records = MbgRecord::whereDate('waktu_pengambilan', $selectedDate)
            ->orderBy('waktu_pengambilan')
            ->get();

        $totalPenerima = $records->count();
        $totalPorsi = $records->sum('jumlah');

        $pdf = Pdf::loadView('mbg.pdf', [
            'records' => $records,
            'selectedDate' => $selectedDate,
            'totalPenerima' => $totalPenerima,
            'totalPorsi' => $totalPorsi,
        ]);

        $fileName = 'laporan-mbg-'.$selectedDate->format('Y-m-d').'.pdf';

        return $pdf->download($fileName);
    }

    public function destroy(MbgRecord $mbgRecord)
    {
        $recordDate = Carbon::parse($mbgRecord->waktu_pengambilan)->toDateString();
        $mbgRecord->delete();

        if ($mbgRecord->foto) {
            Storage::disk('public')->delete($mbgRecord->foto);
        }

        return redirect()->route('mbg.history', ['date' => $recordDate])->with('success', 'Data pengambilan berhasil dihapus.');
    }
}
