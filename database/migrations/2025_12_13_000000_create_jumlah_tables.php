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
        // Create jumlah_wus_pus table
        Schema::create('jumlah_wus_pus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
            
            $table->unique(['year']);
        });

        // Create jumlah_ibu_hamil table
        Schema::create('jumlah_ibu_hamil', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
            
            $table->unique(['year']);
        });

        // Create jumlah_kb_mket table
        Schema::create('jumlah_kb_mket', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
            
            $table->unique(['year']);
        });

        // Create jumlah_kb_non_mket table
        Schema::create('jumlah_kb_non_mket', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
            
            $table->unique(['year']);
        });

        // Create jumlah_pus_kb table
        Schema::create('jumlah_pus_kb', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->integer('male')->nullable();
            $table->integer('female')->nullable();
            $table->timestamps();
            
            $table->unique(['year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_wus_pus');
        Schema::dropIfExists('jumlah_ibu_hamil');
        Schema::dropIfExists('jumlah_kb_mket');
        Schema::dropIfExists('jumlah_kb_non_mket');
        Schema::dropIfExists('jumlah_pus_kb');
    }
};
