<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.Index.registrasi', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function submitRegister(Request $request)
    {
        $validatedData = $request->validate([
            'NAMA' => 'required|max:30',
            'NIS' => 'required|unique:users',
            'ALAMAT' => 'required|max:100|min:5',
            'EMAIL' => 'required|unique:users|max:30|min:5',
            'PASSWORD' => 'required|max:20|min:5',
        ]);

        $validatedData['PASSWORD'] = Hash::make($validatedData['PASSWORD']);

        Users::create($validatedData);

        return redirect()->route('index')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
