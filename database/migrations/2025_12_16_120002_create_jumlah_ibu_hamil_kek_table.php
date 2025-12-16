<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jumlah_ibu_hamil_kek', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->tinyInteger('bulan');
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->unique(['tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_ibu_hamil_kek');
    }
};
