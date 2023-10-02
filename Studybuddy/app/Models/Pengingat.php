<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class Pengingat extends Model
{
    use HasFactory;

    protected $table = 'pengingat';
    protected $fillable = [
        'users_id',
        'TANGGAL_PENGINGAT',
        'KETERANGAN',
        'JUDUL_PENGINGAT',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jadwalHarian()
    {
        return $this->belongsTo(JadwalHarian::class, 'jadwalharian_id');
    }
}
