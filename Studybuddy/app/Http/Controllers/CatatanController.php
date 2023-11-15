<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Users;
use App\Models\Catatan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari formulir
        $validatedData = $request->validate([
            'hari' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'kategori' => 'required|exists:kategori,id', // Pastikan kategori ada dalam tabel kategori
        ]);

        $catatan = Auth::user()->catatans()->create([
            'hari' => $validatedData['hari'],
            'kegiatan' => $validatedData['kegiatan'],
            'kategori_id' => $validatedData['kategori'], // Isi foreign key kategori_id
        ]);

        $catatan->save();

        // Redirect ke halaman yang sesuai setelah menyimpan catatan
        return redirect()->route('home')->with('success', 'Catatan harian berhasil disimpan.');
    }

    // No 2
    public function destroy($id)
    {
        $catatan = Catatan::findOrFail($id);
        $catatan->tugas()->delete(); // Menghapus tugas yang terkait dengan catatan
        $catatan->delete(); // Menghapus catatan

        return response()->json([
            'message' => 'Catatan berhasil dihapus beserta tugas yang terkait.'
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim dari formulir
        $validatedData = $request->validate([
            'hari' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'kategori' => 'required',
        ]);

        $catatan = Catatan::findOrFail($id); // Mengambil data catatan berdasarkan ID

        // Memperbarui data catatan dengan data yang baru
        $catatan->hari = $validatedData['hari'];
        $catatan->kegiatan = $validatedData['kegiatan'];
        $catatan->kategori_id = $validatedData['kategori']; // Ubah 'kategori' menjadi 'kategori_id'
        $catatan->save();

        // Redirect ke halaman yang sesuai setelah mengupdate catatan
        return redirect()->route('home')->with('success', 'Catatan harian berhasil diperbarui.');
    }


    public function filterCatatan(Request $request)
    {
        $user = Auth::user();
        $namaUser = Users::where('NAMA', $user->NAMA)->value('NAMA');
        $idUser = Users::where('id', $user->id)->value('id');

        $kategoriFilter = $request->input('kategoriFilter');
        $prioritasFilter = $request->input('prioritasFilter');

        $jadwalharian = Catatan::where('users_id', $idUser)
            ->when($kategoriFilter, function ($query) use ($kategoriFilter) {
                return $query->where('kategori_id', $kategoriFilter);
            })
            ->when($prioritasFilter, function ($query) use ($prioritasFilter) {
                return $query->where('prioritas', $prioritasFilter);
            })
            ->get();

        $tugas = $user->tugas;

        $kategoris = Kategori::all();

        return view('pages.users.home', [
            'title' => 'Home',
            'namaUser' => $namaUser,
            'usersId' => $idUser,
            'jadwalharian' => $jadwalharian,
            'tugas' => $tugas,
            'kategoris' => $kategoris,
        ]);
    }

    public function updateKategori(Request $request, $id)
    {
        $catatan = Catatan::find($id);
        $kategoriId = $request->input('kategori_id');

        if (!$catatan) {
            return response()->json(['message' => 'Catatan tidak ditemukan'], 404);
        }

        $catatan->kategori_id = $kategoriId;
        $catatan->save();

        return response()->json(['message' => 'Kategori catatan berhasil diperbarui'], 200);
    }
}
