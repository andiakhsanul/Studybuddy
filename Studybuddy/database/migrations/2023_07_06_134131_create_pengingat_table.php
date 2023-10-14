<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengingatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengingat', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('users_id')->references('id')->on('users');
            $table->dateTime('TANGGAL_PENGINGAT');
            $table->string('KETERANGAN', 50);
            $table->string('JUDUL_PENGINGAT', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->boolean('skala_prioritas')->default(0); // Default value 0 untuk Tugas Sampingan
        });
        Schema::dropIfExists('pengingat');
    }
}
