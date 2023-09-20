<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Catatan;


class Users extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'NAMA',
        'NIS',
        'ALAMAT',
        'EMAIL',
        'PASSWORD',
        'Role',
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'users_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'users_id');
    }
}
