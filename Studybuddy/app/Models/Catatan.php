<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'jadwalharian';

    protected $fillable = [
        'users_id',
        'kategori_id',
        'hari',
        'kegiatan',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'jadwalharian_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
