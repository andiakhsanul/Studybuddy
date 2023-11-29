<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminTugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $namaUser = DB::table('users')->where('NAMA', $user->NAMA)->value('NAMA');
        $tugasCount = DB::table('tugas')->count();

        $tugasData = DB::table('tugas')
            ->join('jadwalharian', 'tugas.jadwalharian_id', '=', 'jadwalharian.id')
            ->join('users', 'tugas.users_id', '=', 'users.id')
            ->select(
                'tugas.id as no',
                'jadwalharian.HARI as nama_jadwal',
                'users.NAMA as nama_user',
                'tugas.DESK_TUGAS as nama_tugas',
                'tugas.TENGGAT_WAKTU as tenggat_waktu',
                'tugas.Skala_Prioritas as skala_prioritas'
            )->get();

        $topUsers = DB::table('users')
            ->join('tugas', 'users.id', '=', 'tugas.users_id')
            ->select('users.NAMA as nama_user', DB::raw('COUNT(tugas.id) as total_tugas'))
            ->groupBy('users.id', 'users.NAMA')
            ->orderByDesc('total_tugas')
            ->limit(3)
            ->get();

        $topPhrases = DB::table('tugas')
            ->select('DESK_TUGAS', DB::raw('COUNT(*) as total'))
            ->groupBy('DESK_TUGAS')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        return view('pages.Admin.tugasadmin', [
            'title' => 'Kategori',
            'namaUser' => $namaUser,
            'tugasData' => $tugasData,
            'tugasCount' => $tugasCount,
            'topUsers' => $topUsers,
            'topPhrases'=> $topPhrases,
        ]);
    }
}
