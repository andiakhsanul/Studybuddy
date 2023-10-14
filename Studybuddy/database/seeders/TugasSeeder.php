<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder
{
    public function run()
    {
        DB::table('tugas')->insert([
            [
                'jadwalharian_id' => 5, // Replace with your actual ID
                'users_id' => 1, // Replace with your actual ID
                'DESK_TUGAS' => 'Sample Task 1',
                'TENGGAT_WAKTU' => now(),
                'STATUS' => 0, // Not completed
                'CATATAN' => 'Sample Note 1',
                'Skala_Prioritas' => 1, // Replace with your priority value
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jadwalharian_id' => 7, // Replace with your actual ID
                'users_id' => 1, // Replace with your actual ID
                'DESK_TUGAS' => 'Sample Task 2',
                'TENGGAT_WAKTU' => now(),
                'STATUS' => 1, // Completed
                'CATATAN' => 'Sample Note 2',
                'Skala_Prioritas' => 2, // Replace with your priority value
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more dummy data as needed
        ]);
    }
}


