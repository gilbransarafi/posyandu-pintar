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
        Schema::create('table_ibu_hamil_risiko_tinggi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->tinyInteger('bulan'); // 1–12
            $table->integer('jumlah')->default(0);
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_ibu_hamil_risiko_tinggi');
    }
};
