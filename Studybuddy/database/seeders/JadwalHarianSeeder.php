<?php

// database/seeders/JadwalHarianSeeder.php

use Illuminate\Database\Seeder;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\DB;

class JadwalHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Alternatively, you can insert records using DB::table
        DB::table('jadwalharian')->insert([
            'users_id' => 1, // Replace with the actual user ID
            'kategori_id' => 1, // Replace with the actual category ID
            'HARI' => now(), // Replace with the date
            'KEGIATAN' => 'Tugas Universitas',
        ]);

        DB::table('jadwalharian')->insert([
            'users_id' => 1, // Replace with the actual user ID
            'kategori_id' => 2, // Replace with the actual category ID
            'HARI' => now(), // Replace with the date
            'KEGIATAN' => 'Event Jepang',
        ]);
    }
}


