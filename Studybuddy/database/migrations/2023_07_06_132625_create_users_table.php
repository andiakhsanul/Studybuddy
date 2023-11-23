<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('NAMA', 30);
            $table->string('NIS', 15)->nullable();
            $table->string('ALAMAT', 100)->nullable();
            $table->string('EMAIL', 30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('PASSWORD', 255)->nullable();
            $table->boolean('Role')->default(0);
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
        Schema::dropIfExists('users');
    }
}
