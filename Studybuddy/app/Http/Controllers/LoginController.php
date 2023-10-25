<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Users;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.Index.login', [
            'title' => 'Login'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Anda telah berhasil logout.');
    }


    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'EMAIL' => 'required|email:dns',
            'PASSWORD' => 'required|min:5',
        ]);

        $user = Users::where('EMAIL', $credentials['EMAIL'])->first();

        if ($user && Hash::check($credentials['PASSWORD'], $user->PASSWORD)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->Role === 0) { // user biasa
                // Pengguna dengan role 0 (misalnya pengguna biasa) diarahkan ke 'home'
                return redirect()->route('home')->with('success', 'Login berhasil.');

            } elseif ($user->Role === 1) { // admin website
                // Pengguna dengan role 1 (misalnya admin) diarahkan ke 'admin.home'
                return redirect()->route('adminPage')->with('success', 'Berhasil Login');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }
}

