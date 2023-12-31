<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Users;
use App\Models\Catatan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');
            $idUser = Users::where('id', $user->id)->value('id');

            // Initialize $filteredData as an empty array
            $filteredData = [];

            $kategoris = Kategori::all();
            $prioritasOptions = Tugas::distinct()->pluck('Skala_Prioritas');
            $statusOptions = Tugas::distinct()->pluck('STATUS');

            // Inisialisasi $jadwalharian dan $tugas
            $jadwalharian = collect();
            $tugas = collect();

            $currentRoute = 'search';

            return view('pages.users.search', [
                'title' => 'Search',
                'namaUser' => $namaUser,
                'usersId' => $idUser,
                'jadwalharian' => $jadwalharian,
                'tugas' => $tugas,
                'kategoris' => $kategoris,
                'prioritasOptions' => $prioritasOptions,
                'statusOptions' => $statusOptions,
                'filteredData' => $filteredData,
                'currentRoute' => $currentRoute,
            ]);
        } else {
            return redirect()->route('index');
        }
    }

    public function filterCatatan(Request $request)
    {
        $kategoriFilter = $request->input('kategoriFilter');
        $filteredData = [];

        if (!empty($kategoriFilter)) {
            // Filter notes based on category
            $filteredData = Catatan::where('kategori_id', $kategoriFilter)->get();

            // Fetch associated tasks for each note
            foreach ($filteredData as $catatan) {
                $catatan->tugas = Tugas::where('jadwalharian_id', $catatan->id)->get();
            }
        }

        $user = Auth::user();
        $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');
        $idUser = Users::where('id', $user->id)->value('id');
        $kategoris = Kategori::all();
        $prioritasOptions = Tugas::distinct()->pluck('Skala_Prioritas');
        $statusOptions = Tugas::distinct()->pluck('STATUS');
        $currentRoute = 'filterCatatan';

        return view('pages.users.search', [
            'title' => 'search',
            'namaUser' => $namaUser,
            'usersId' => $idUser,
            'jadwalharian' => collect(),
            'tugas' => collect(),
            'kategoris' => $kategoris,
            'prioritasOptions' => $prioritasOptions,
            'statusOptions' => $statusOptions,
            'filteredData' => $filteredData,
            'currentRoute' => $currentRoute,
        ]);
    }
}
