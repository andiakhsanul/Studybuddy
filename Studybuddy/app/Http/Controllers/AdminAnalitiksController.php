<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminAnalitiksController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $namaUser = DB::table('users')->where('NAMA', $user->NAMA)->value('NAMA');
        $tugasCount = DB::table('tugas')->count();
        $catatanCount = DB::table('jadwalharian')->count();
        $userCount = DB::table('users')->where('Role', 0)->count();
        $kategoriCount = DB::table('kategori')->count();
        $newestUsers = DB::table('users')->latest()->limit(5)->get();

        $kategoriUsage = DB::table('jadwalharian')
            ->join('kategori', 'jadwalharian.kategori_id', '=', 'kategori.id')
            ->select('jadwalharian.kategori_id', 'kategori.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('jadwalharian.kategori_id', 'kategori.nama_kategori')
            ->get();


        return view('pages.Admin.analyticsadmin', [
            'title' => 'Analytics',
            'namaUser' => $namaUser,
            'tugasCount' => $tugasCount,
            'catatanCount' => $catatanCount,
            'userCount' => $userCount,
            'kategoriCount' => $kategoriCount,
            'allUsers' => $newestUsers,
            'kategoriUsage' => $kategoriUsage,
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
