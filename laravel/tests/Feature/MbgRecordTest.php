<?php

namespace Tests\Feature;

use App\Models\DailyMenu;
use App\Models\MbgRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MbgRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_mbg_dashboard(): void
    {
        $response = $this->get(route('mbg.index'));

        $response->assertOk()
            ->assertSee('Pendataan Pengambilan MBG')
            ->assertSee('Menu Hari Ini')
            ->assertSee('capture="environment"', false)
            ->assertSee('Ambil foto langsung dari kamera')
            ->assertDontSee('Pilih foto dari album')
            ->assertSee(route('mbg.daily-menu'), false)
            ->assertSee('Makanan Bergizi Gratis');
    }

    public function test_dashboard_navigation_opens_dedicated_feature_pages(): void
    {
        $response = $this->get(route('mbg.index'));

        $response->assertOk()
            ->assertSee('href="'.route('mbg.form').'"', false)
            ->assertSee('href="'.route('mbg.history').'"', false)
            ->assertSee('href="'.route('mbg.form').'" class="primary-btn"', false);
    }

    public function test_each_dashboard_feature_renders_its_own_active_page(): void
    {
        $this->get(route('mbg.index'))
            ->assertOk()
            ->assertSee('data-page="summary"', false)
            ->assertSee('class="mobile-tab is-active" data-target="summary-panel"', false)
            ->assertSee('<span>Ringkasan</span>', false)
            ->assertSee('aria-pressed="true"', false);

        $this->get(route('mbg.form'))
            ->assertOk()
            ->assertSee('data-page="form"', false)
            ->assertSee('Catat Pengambilan')
            ->assertSee('class="mobile-tab is-active" data-target="form-panel"', false);

        $this->get(route('mbg.history'))
            ->assertOk()
            ->assertSee('data-page="history"', false)
            ->assertSee('Riwayat Pengambilan')
            ->assertSee('class="mobile-tab is-active" data-target="history-panel"', false);
    }

    public function test_dashboard_hides_today_metrics(): void
    {
        $response = $this->get(route('mbg.index'));

        $response->assertOk()
            ->assertSee('Total Porsi')
            ->assertDontSee('<small>Hari ini</small>', false)
            ->assertDontSee('<span class="badge">Aktif</span>', false)
            ->assertDontSee('<span class="label">Hari Ini</span>', false);
    }

    public function test_dashboard_shows_hourly_chart_for_today_only(): void
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        MbgRecord::create([
            'nama' => 'Penerima Pagi',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => $today.' 08:15:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima Pagi Lain',
            'kelas' => 'VII-B',
            'jumlah' => 1,
            'waktu_pengambilan' => $today.' 08:45:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima Kemarin',
            'kelas' => 'VII-C',
            'jumlah' => 1,
            'waktu_pengambilan' => Carbon::parse($today)->subDay()->toDateString().' 08:30:00',
        ]);

        $this->get(route('mbg.index'))
            ->assertOk()
            ->assertSee('Pendataan Hari Ini')
            ->assertSee('data-hour="08"', false)
            ->assertSee('data-count="2"', false)
            ->assertSee('>2 data</span>', false)
            ->assertSee('data-hour="09"', false);
    }

    public function test_dashboard_chart_can_show_saved_records_for_a_selected_day(): void
    {
        MbgRecord::create([
            'nama' => 'Penerima Senin',
            'kelas' => 'VII-A',
            'jumlah' => 3,
            'waktu_pengambilan' => '2026-09-25 08:15:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima Selasa',
            'kelas' => 'VII-B',
            'jumlah' => 1,
            'waktu_pengambilan' => '2026-09-26 10:45:00',
        ]);

        $this->get(route('mbg.index', ['date' => '2026-09-25']))
            ->assertOk()
            ->assertSee('Grafik Pendataan Harian')
            ->assertSee('value="2026-09-25"', false)
            ->assertSee('data-hour="08"', false)
            ->assertSee('data-count="1"', false)
            ->assertSee('>1 data</span>', false)
            ->assertSee('data-hour="10"', false)
            ->assertSee('data-count="0"', false)
            ->assertSee('class="history-filter chart-date-filter"', false)
            ->assertSee(route('mbg.index', ['date' => '2026-09-24']), false)
            ->assertSee(route('mbg.index', ['date' => '2026-09-26']), false)
            ->assertSee(route('mbg.pdf', ['date' => '2026-09-25']), false)
            ->assertDontSee('Penerima Selasa');
    }

    public function test_dashboard_totals_show_recipients_and_portions_for_the_selected_day(): void
    {
        MbgRecord::create([
            'nama' => 'Penerima Hari Sebelumnya',
            'kelas' => 'VII-A',
            'jumlah' => 3,
            'waktu_pengambilan' => '2026-09-25 08:15:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima Hari Sebelumnya Lain',
            'kelas' => 'VII-B',
            'jumlah' => 5,
            'waktu_pengambilan' => '2026-09-25 09:15:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima Hari Berbeda',
            'kelas' => 'VII-C',
            'jumlah' => 11,
            'waktu_pengambilan' => '2026-09-26 10:15:00',
        ]);

        $this->get(route('mbg.index', ['date' => '2026-09-25']))
            ->assertOk()
            ->assertSee('<div class="value">2</div>', false)
            ->assertSee('<div class="value">8</div>', false)
            ->assertSee('25 September 2026');
    }

    public function test_daily_menu_upload_has_its_own_page_and_dashboard_keeps_showing_the_photo(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('daily-menus/menu.png', 'menu photo');
        $dailyMenu = DailyMenu::create([
            'menu_date' => now()->toDateString(),
            'foto' => 'daily-menus/menu.png',
        ]);
        $photoUrl = Storage::disk('public')->url($dailyMenu->foto);

        $this->get(route('mbg.daily-menu'))
            ->assertOk()
            ->assertSee('Unggah Foto Menu Hari Ini')
            ->assertSee('name="foto_menu"', false)
            ->assertSee('name="foto_menu_kamera"', false)
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee('Hapus Foto Menu')
            ->assertSee('capture="environment"', false)
            ->assertSee('Pilih dari album foto')
            ->assertSee('Ambil foto langsung')
            ->assertSee($photoUrl, false);

        $this->get(route('mbg.index'))
            ->assertOk()
            ->assertSee($photoUrl, false)
            ->assertDontSee('name="foto_menu"', false);
    }

    public function test_user_can_upload_and_replace_today_menu_photo(): void
    {
        Storage::fake('public');
        $today = now()->toDateString();
        $photoContents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=');

        $this->post(route('mbg.daily-menu.store'), [
            'foto_menu' => UploadedFile::fake()->createWithContent('menu.png', $photoContents),
        ])->assertRedirect(route('mbg.daily-menu'));

        $firstMenu = DailyMenu::firstOrFail();
        $firstPhoto = $firstMenu->foto;
        $this->assertSame($today, Carbon::parse($firstMenu->menu_date)->toDateString());
        $this->assertTrue(Storage::disk('public')->exists($firstPhoto));

        $this->post(route('mbg.daily-menu.store'), [
            'foto_menu' => UploadedFile::fake()->createWithContent('menu-baru.png', $photoContents),
        ])->assertRedirect(route('mbg.daily-menu'));

        $updatedMenu = DailyMenu::firstOrFail();
        $this->assertDatabaseCount('daily_menus', 1);
        $this->assertNotSame($firstPhoto, $updatedMenu->foto);
        $this->assertFalse(Storage::disk('public')->exists($firstPhoto));

        $this->get(route('mbg.daily-menu'))
            ->assertOk()
            ->assertSee('Foto menu hari ini berhasil diperbarui.')
            ->assertSee(Storage::disk('public')->url($updatedMenu->foto), false);

        $this->get(route('mbg.index'))
            ->assertOk()
            ->assertSee(Storage::disk('public')->url($updatedMenu->foto), false)
            ->assertSee('Foto menu MBG hari ini');
    }

    public function test_user_can_delete_today_menu_photo(): void
    {
        Storage::fake('public');
        $photo = 'daily-menus/menu.png';
        Storage::disk('public')->put($photo, 'menu photo');
        $dailyMenu = DailyMenu::create([
            'menu_date' => now()->toDateString(),
            'foto' => $photo,
        ]);

        $this->delete(route('mbg.daily-menu.destroy'))
            ->assertRedirect(route('mbg.daily-menu'));

        $this->assertDatabaseMissing('daily_menus', ['id' => $dailyMenu->id]);
        $this->assertFalse(Storage::disk('public')->exists($photo));

        $this->get(route('mbg.daily-menu'))
            ->assertOk()
            ->assertSee('Foto menu hari ini berhasil dihapus.')
            ->assertSee('Foto menu hari ini belum diunggah.')
            ->assertDontSee('Hapus Foto Menu');
    }

    public function test_user_can_upload_today_menu_photo_taken_with_the_camera(): void
    {
        Storage::fake('public');
        $photoContents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=');

        $this->post(route('mbg.daily-menu.store'), [
            'foto_menu_kamera' => UploadedFile::fake()->createWithContent('menu-kamera.png', $photoContents),
        ])->assertRedirect(route('mbg.daily-menu'));

        $dailyMenu = DailyMenu::firstOrFail();
        $this->assertTrue(Storage::disk('public')->exists($dailyMenu->foto));
    }

    public function test_daily_menu_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $this->from(route('mbg.daily-menu'))->post(route('mbg.daily-menu.store'), [
            'foto_menu' => UploadedFile::fake()->create('menu.txt', 10, 'text/plain'),
        ])->assertRedirect(route('mbg.daily-menu'))
            ->assertSessionHasErrors('foto_menu');

        $this->assertDatabaseCount('daily_menus', 0);
        $this->assertSame([], Storage::disk('public')->allFiles('daily-menus'));
    }

    public function test_home_page_filters_pickup_history_by_selected_day(): void
    {
        MbgRecord::create([
            'nama' => 'Penerima 25',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => '2026-09-25 08:30:00',
        ]);
        MbgRecord::create([
            'nama' => 'Penerima 26',
            'kelas' => 'VII-B',
            'jumlah' => 1,
            'waktu_pengambilan' => '2026-09-26 08:30:00',
        ]);

        $response = $this->get(route('mbg.history', ['date' => '2026-09-25']));

        $response->assertOk()
            ->assertSee('Penerima 25')
            ->assertDontSee('Penerima 26')
            ->assertSee('Cari berdasarkan nama atau kelas')
            ->assertSee('data-search="Penerima 25 VII-A"', false)
            ->assertSee('value="2026-09-25"', false)
            ->assertSee(route('mbg.pdf', ['date' => '2026-09-25']), false);
    }

    public function test_home_page_has_light_and_dark_mode_toggle(): void
    {
        $response = $this->get(route('mbg.index'));

        $response->assertOk()
            ->assertSee('theme-toggle')
            ->assertSee('Mode gelap')
            ->assertSee('Mode terang');
    }

    public function test_user_can_store_mbg_record_without_restricted_fields(): void
    {
        $response = $this->post(route('mbg.store'), [
            'nama' => 'Ayu Putri',
            'kelas' => 'VII-A',
            'jumlah' => 25,
            'waktu_pengambilan' => '2026-09-25 08:30:00',
            'catatan' => 'Sudah makan siang',
        ]);

        $response->assertRedirect(route('mbg.form'));
        $this->assertDatabaseHas('mbg_records', [
            'nama' => 'Ayu Putri',
            'kelas' => 'VII-A',
            'jumlah' => 25,
        ]);
    }

    public function test_user_can_store_mbg_record_with_a_photo(): void
    {
        Storage::fake('public');

        $response = $this->post(route('mbg.store'), [
            'nama' => 'Ayu Putri',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => '2026-09-25 08:30:00',
            'foto' => UploadedFile::fake()->createWithContent(
                'pengambilan.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=')
            ),
        ]);

        $response->assertRedirect(route('mbg.form'));

        $record = MbgRecord::firstOrFail();
        $this->assertNotNull($record->foto);
        $this->assertTrue(Storage::disk('public')->exists($record->foto));

        $this->get(route('mbg.history', ['date' => '2026-09-25']))
            ->assertSee(Storage::disk('public')->url($record->foto), false)
            ->assertSee('Foto pengambilan oleh Ayu Putri');
    }

    public function test_photo_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $response = $this->from(route('mbg.index'))->post(route('mbg.store'), [
            'nama' => 'Ayu Putri',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => '2026-09-25 08:30:00',
            'foto' => UploadedFile::fake()->create('bukti.txt', 10, 'text/plain'),
        ]);

        $response->assertRedirect(route('mbg.index'))
            ->assertSessionHasErrors('foto');

        $this->assertDatabaseCount('mbg_records', 0);
        $this->assertSame([], Storage::disk('public')->allFiles('mbg-photos'));
    }

    public function test_user_can_store_mbg_record_with_json_response(): void
    {
        $response = $this->postJson(route('mbg.store'), [
            'nama' => 'Dina Putri',
            'kelas' => 'VII-C',
            'jumlah' => 2,
            'waktu_pengambilan' => '2026-09-25 09:30:00',
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Data pengambilan MBG berhasil dicatat.')
            ->assertJsonPath('date', '2026-09-25');

        $this->assertDatabaseHas('mbg_records', [
            'nama' => 'Dina Putri',
            'kelas' => 'VII-C',
        ]);
    }

    public function test_invalid_json_record_returns_validation_errors_without_saving(): void
    {
        $response = $this->postJson(route('mbg.store'), [
            'nama' => '',
            'kelas' => '',
            'jumlah' => 0,
            'waktu_pengambilan' => 'invalid-date',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['nama', 'kelas', 'jumlah', 'waktu_pengambilan']);

        $this->assertDatabaseCount('mbg_records', 0);
    }

    public function test_daily_report_pdf_route_generates_pdf(): void
    {
        $this->post(route('mbg.store'), [
            'nama' => 'Budi',
            'kelas' => 'VIII-B',
            'jumlah' => 12,
            'waktu_pengambilan' => '2026-09-25 09:15:00',
            'catatan' => 'Laporan harian',
        ]);

        $response = $this->get(route('mbg.pdf', ['date' => '2026-09-25']));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_user_can_delete_mbg_record(): void
    {
        $record = MbgRecord::create([
            'nama' => 'Citra',
            'kelas' => 'IX-C',
            'jumlah' => 18,
            'waktu_pengambilan' => '2026-09-25 10:00:00',
            'catatan' => 'Dihapus nanti',
        ]);

        $response = $this->delete(route('mbg.destroy', $record));

        $response->assertRedirect(route('mbg.history', ['date' => '2026-09-25']));
        $this->assertDatabaseMissing('mbg_records', ['id' => $record->id]);
    }
}
