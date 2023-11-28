<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $namaUser = DB::table('users')
            ->where('NAMA', $user->NAMA)->value('NAMA');
        $userCount = DB::table('users')
            ->where('Role', 0)->count();
        $users = DB::table('users')->get();
        return view('pages.Admin.usersadmin', [
            'title' => 'User',
            'namaUser' => $namaUser,
            'userCount' => $userCount,
            'users' => $users
        ]);
    }

    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'namaUser' => 'required|max:30',
            'nis' => 'required|unique:users',
            'alamat' => 'required|max:100|min:5',
            'email' => 'required|unique:users|max:30|min:5|email',
            'password' => 'required|max:20|min:5',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            DB::table('users')->insert([
                'NAMA' => $validatedData['namaUser'],
                'NIS' => $validatedData['nis'],
                'ALAMAT' => $validatedData['alamat'],
                'EMAIL' => $validatedData['email'],
                'PASSWORD' => $validatedData['password'],
            ]);

            return response()->json(['success' => 'User added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }


    public function editUser($id)
    {
        try {
            $data = request()->only(['edit_namaUser', 'edit_nis', 'edit_alamat', 'edit_email', 'edit_role']);

            // Validate data as needed

            $updateData = [
                'NAMA' => $data['edit_namaUser'],
                'NIS' => $data['edit_nis'],
                'ALAMAT' => $data['edit_alamat'],
                'EMAIL' => $data['edit_email'],
                'Role' => $data['edit_role'],
                // Add other columns as needed
            ];

            $updatedRows = DB::table('users')
                ->where('id', $id)
                ->update($updateData);

            if ($updatedRows > 0) {
                $updatedUser = DB::table('users')->find($id);

                return response()->json([
                    'NAMA' => $updatedUser->NAMA,
                    'NIS' => $updatedUser->NIS,
                    'ALAMAT' => $updatedUser->ALAMAT,
                    'EMAIL' => $updatedUser->EMAIL,
                    'Role' => $updatedUser->Role,
                ]);
            } else {
                return response()->json(['error' => 'No rows updated. User not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function deleteUser($id)
    {
        try {
            DB::table('users')->where('id', $id)->delete();

            return response()->json(['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
