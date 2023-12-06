<?php

namespace App\Http\Controllers\Web;

// use App\Models\User;
use App\Models\Tugas;
use App\Models\Users;
use App\Models\Catatan;
use App\Models\Kategori;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');
            $idUser = Users::where('id', $user->id)->value('id');

            $jadwalharian = $user->catatans;
            $tugas = $user->tugas;

            $kategoris = Kategori::all();

            $prioritasOptions = Tugas::distinct()->pluck('Skala_Prioritas');
            $statusOptions = Tugas::distinct()->pluck('STATUS');

            // Inisialisasi $jadwalharian dan $tugas
            $jadwalharian = collect();
            $tugas = collect();

            // Check apakah ada pencarian
            if ($request->has('kategoriFilter') || $request->has('prioritasFilter') || $request->has('statusFilter')) {
                $filteredData = $this->filterCatatan($request);
            } else {
                // Jika tidak ada pencarian, ambil data seperti biasa
                $jadwalharian = $user->catatans;
                $tugas = $user->tugas;
            }

            return view('pages.users.home', [
                'title' => 'Home',
                'namaUser' => $namaUser,
                'usersId' => $idUser,
                'jadwalharian' => $jadwalharian,
                'tugas' => $tugas,
                'kategoris' => $kategoris,
                'prioritasOptions' => $prioritasOptions,
                'statusOptions' => $statusOptions,
                'filteredData' => $filteredData ?? collect(),
            ]);
        } else {
            return redirect()->route('index');
        }
    }
}
