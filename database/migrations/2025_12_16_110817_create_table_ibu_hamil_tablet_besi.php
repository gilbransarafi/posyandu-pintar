<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ibu_hamil_tablet_besi', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->tinyInteger('bulan');
            $table->integer('fe1')->default(0);
            $table->integer('fe3')->default(0);
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibu_hamil_tablet_besi');
    }
};
