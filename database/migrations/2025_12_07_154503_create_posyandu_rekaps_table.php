<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posyandu_rekaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');           // tahun rekap
            $table->string('code', 50);               // contoh: item-1, item-16, dst.
            $table->integer('value')->default(0);     // nilai utama
            $table->integer('male')->nullable();      // opsional (kalau mau pisah Laki)
            $table->integer('female')->nullable();    // opsional (kalau mau pisah Perempuan)
            $table->timestamps();

            $table->unique(['year', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posyandu_rekaps');
    }
};

