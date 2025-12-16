<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasYearUnique = collect(DB::select("SHOW INDEX FROM jumlah_wus_pus WHERE Key_name = 'unique_wus_pus_year'"))->isNotEmpty();

        Schema::table('jumlah_wus_pus', function (Blueprint $table) use ($hasYearUnique) {
            if ($hasYearUnique) {
                $table->dropUnique('unique_wus_pus_year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jumlah_wus_pus', function (Blueprint $table) {
            if (!collect(DB::select("SHOW INDEX FROM jumlah_wus_pus WHERE Key_name = 'unique_wus_pus_year'"))->isNotEmpty()) {
                $table->unique(['year'], 'unique_wus_pus_year');
            }
        });
    }
};
