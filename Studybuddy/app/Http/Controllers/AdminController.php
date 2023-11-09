<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;

class AdminController extends Controller
{
    public function index() {
        $user = Auth::user();
        $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');

        return view('pages.Admin.mainadmin', [
            'title' => 'Home',
            'namaUser' => $namaUser,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Anda telah berhasil logout.');
    }


}
