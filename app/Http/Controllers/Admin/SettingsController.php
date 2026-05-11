<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('admin.settings.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'nullable|string|max:20',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'avatar'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'username']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Ganti password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.settings.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}