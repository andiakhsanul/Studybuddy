<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'Nama_Kategori',
    ];

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'kategori_id', 'id');
    }
}
