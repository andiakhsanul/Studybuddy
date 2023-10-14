<?php

namespace App\Http\Controllers;

use App\Models\Pengingat;
use App\Models\Users;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $pengingat = Pengingat::with('jadwalHarian')->get();
        $mahasiswa = Users::first(); // ngammbil data mahasiswa yang sesuai

        return view('pages.users.notifikasi', [
            'title' => 'Notifikasi',
            'pengingat' => $pengingat,
            'namaUser' => $mahasiswa->NAMA // Tambahkan data namaUser ke dalam array yang akan dikirim ke view
        ]);
    }

    public function notofication()
    {

    }
}
