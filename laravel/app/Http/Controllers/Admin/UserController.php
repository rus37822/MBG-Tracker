<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()
                ->orderByDesc('is_admin')
                ->orderBy('name')
                ->paginate(15),
        ]);
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
