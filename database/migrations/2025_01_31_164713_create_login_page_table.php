<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('login_page', function (Blueprint $table) {
            $table->id();  // Menambahkan kolom 'id' sebagai primary key auto increment
            $table->string('title');  // Kolom untuk menyimpan judul halaman login
            $table->string('image');  // Kolom untuk menyimpan nama file image atau path
            $table->timestamps();  // Menambahkan kolom 'created_at' dan 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_page');
    }
};
