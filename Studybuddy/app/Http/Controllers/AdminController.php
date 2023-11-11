<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $user = Auth::user();
        $namaUser = DB::table('users')->where('NAMA', $user->NAMA)->value('NAMA');
        $tugasCount = DB::table('tugas')->count();
        $userCount = DB::table('users')->count();
        $kategoriCount = DB::table('kategori')->count();
        $newestUsers = DB::table('users')->latest()->limit(3)->get(); // Get the 5 newest users

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

    //make to get data tugas from database and show it to admin with query builde



}


