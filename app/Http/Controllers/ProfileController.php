<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $breadcrumb = (object) [
            'title' => 'Setting Profile',
            'list'  => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'Setting Profile'
        ];

        $activeMenu = 'profile';

        return view('setting.profile', compact('activeMenu', 'breadcrumb', 'page'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        $user = UserModel::where('user_id', Auth::user()->user_id)->first();

        if ($user && $request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            // Upload gambar baru ke folder 'profiles'
            $path = $request->file('image')->store('profiles', 'public');
            $user->profile = $path;
            $user->save();
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return redirect()->route('profile.show')->with('error', 'User tidak ditemukan.');
        }

        if ($user->profile && Storage::disk('public')->exists($user->profile)) {
            Storage::disk('public')->delete($user->profile);
            $user->profile = null;
            $user->save();
        }

        return redirect()->route('profile.show')->with('success', 'Foto profil berhasil dihapus.');
    }
}
