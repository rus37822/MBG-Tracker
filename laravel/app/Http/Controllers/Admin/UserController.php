<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);
        $search = trim($validated['search'] ?? '');
        $usersQuery = User::query();

        if ($search !== '') {
            $usersQuery->where(function (Builder $query) use ($search): void {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        return view('admin.users.index', [
            'users' => $usersQuery
                ->orderBy('is_approved')
                ->orderByDesc('is_admin')
                ->orderBy('name')
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
            'totalUsersCount' => User::query()->count(),
            'pendingUsersCount' => User::query()
                ->where('is_admin', false)
                ->where('is_approved', false)
                ->count(),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors([
                'account' => 'Akun admin tidak memerlukan verifikasi.',
            ]);
        }

        if ($user->is_approved) {
            return back()->withErrors([
                'account' => 'Akun ini sudah diverifikasi.',
            ]);
        }

        $user->forceFill(['is_approved' => true])->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun '.$user->name.' berhasil diverifikasi.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors([
                'account' => 'Anda tidak dapat menghapus akun yang sedang digunakan.',
            ]);
        }

        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->withErrors([
                'account' => 'Admin terakhir tidak dapat dihapus.',
            ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun pengguna berhasil dihapus.');
    }
}
