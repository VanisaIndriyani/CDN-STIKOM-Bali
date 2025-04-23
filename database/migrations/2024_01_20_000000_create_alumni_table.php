<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->integer('tahun_yudisium');  // Changed from year to integer
            $table->integer('tahun_lulus');     // Changed from year to integer
            $table->string('periode_wisuda');
            $table->string('pekerjaan')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('bidang')->nullable();
            $table->boolean('relevansi')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni');
    }
};