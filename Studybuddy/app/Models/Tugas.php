<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwalharian_id',
        'users_id',
        'DESK_TUGAS',
        'TENGGAT_WAKTU',
        'STATUS',
        'CATATAN',
        'Skala_Prioritas',
    ];

    public function jadwalHarian()
    {
        return $this->belongsTo(Catatan::class, 'jadwalharian_id', 'id');
    }


    public function users()
    {
        return $this->belongsTo(Users::class);
    }
}
