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
        Schema::create('posyandu_rekaps', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // ex: item-1
            $table->string('label');
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('value')->default(0);
            $table->timestamps();

            $table->unique(['code', 'year'], 'posyandu_rekaps_code_year_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_rekaps');
    }
};
