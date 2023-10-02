<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');
            $idUser = Users::where('id', $user->id)->value('id');

            $jadwalharian = $user->catatans;
            $tugas = $user->tugas; // Retrieve the jadwalharian records associated with the user

            return view('pages.users.home', [
                'title' => 'Home',
                'namaUser' => $namaUser,
                'usersId' => $idUser,
                'jadwalharian' => $jadwalharian,
                'tugas' => $tugas,  // Pass the jadwalharian variable to the view
            ]);
        } else {
            // Pengguna tidak terotentikasi, lakukan penanganan yang sesuai
            return redirect()->route('index'); // Contoh: Alihkan pengguna ke halaman login
        }
    }
}
