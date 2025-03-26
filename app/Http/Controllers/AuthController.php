<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth/login');
    }

    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        $levels = LevelModel::where('level_nama', '!=', 'Administrator')->get();
        return view('auth.register', compact('levels'));
    }

    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:m_user,username|min:4|max:20',
            'nama' => 'required|string|max:100',
            'password' => 'required|string|min:3|confirmed',
            'password_confirmation' => 'required',
            'level_id' => 'required|exists:m_level,level_id|not_in:' .
                LevelModel::where('level_nama', 'Administrator')->value('level_id')
        ], [
            'password.confirmed' => 'Password dan Konfirmasi Password harus sama.',
            'level_id.not_in' => 'Pemilihan level admin tidak diperbolehkan.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Registrasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'level_id' => $request->level_id
            ]);

            Auth::login($user); // Langsung login setelah registrasi berhasil

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Registrasi Berhasil, Anda telah login',
                'redirect' => url('/') // Redirect ke dashboard setelah login
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Registrasi gagal: ' . $e->getMessage(), ['request' => $request->all()]);

            return response()->json([
                'status' => false,
                'message' => 'Registrasi Gagal, silakan coba lagi!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
