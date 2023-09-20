<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Catatan;


class Mahasiswa extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'NAMA',
        'NIS',
        'ALAMAT',
        'EMAIL',
        'PASSWORD',
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'mahasiswa_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'mahasiswa_id');
    }
}
