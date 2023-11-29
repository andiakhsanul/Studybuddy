<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $namaUser = DB::table('users')->where('NAMA', $user->NAMA)->value('NAMA');
        $kategoriCount = DB::table('kategori')->count();
        $kategori = DB::table('kategori')->get();

        $kategoriUsage = DB::table('jadwalharian')
            ->join('kategori', 'jadwalharian.kategori_id', '=', 'kategori.id')
            ->select('jadwalharian.kategori_id', 'kategori.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('jadwalharian.kategori_id', 'kategori.nama_kategori')
            ->get();

        return view('pages.Admin.kategoriadmin', [
            'title' => 'Kategori',
            'namaUser' => $namaUser,
            'kategori' => $kategori,
            'kategoriCount' => $kategoriCount,
            'kategoriUsage' => $kategoriUsage,
        ]);
    }

    public function storeKategori(Request $request)
    {
        $validatedData = $request->validate([
            'namaKategori' => 'required|max:30',
        ]);

        try {
            DB::table('kategori')->insert([
                'Nama_Kategori' => $validatedData['namaKategori'],
            ]);

            return response()->json(['success' => 'Category added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function editKategori($id)
    {
        try {
            $data = request()->only(['edit_namaKategori']);

            $updateData = [
                'Nama_Kategori' => $data['edit_namaKategori'],
            ];

            $updatedRows = DB::table('kategori')
                ->where('id', $id)
                ->update($updateData);

            if ($updatedRows > 0) {
                $updatedKategori = DB::table('kategori')->find($id);

                return response()->json([
                    'Nama_Kategori' => $updatedKategori->Nama_Kategori,
                ]);
            } else {
                return response()->json(['error' => 'No rows updated. Category not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteKategori($id)
    {
        try {
            DB::table('kategori')->where('id', $id)->delete();

            return response()->json(['success' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
