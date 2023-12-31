<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        $user = Auth::user();
        $namaUser = DB::table('users')
                    ->where('NAMA', $user->NAMA)->value('NAMA');
        $tugasCount = DB::table('tugas')
                    ->count();
        $userCount = DB::table('users')
                    ->where('Role', 0)->count();
        $kategoriCount = DB::table('kategori')->count();
        $newestUsers = DB::table('users')
                    ->latest()->limit(5)->get();

        return view('pages.Admin.analyticsadmin', [
            'title' => 'Analytics',
            'namaUser' => $namaUser,
            'tugasCount' => $tugasCount,
            'userCount' => $userCount,
            'kategoriCount' => $kategoriCount,
            'allUsers' => $newestUsers
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
