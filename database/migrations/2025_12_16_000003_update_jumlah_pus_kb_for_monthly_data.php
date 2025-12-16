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
        $hasYearUnique = collect(DB::select("SHOW INDEX FROM jumlah_pus_kb WHERE Key_name = 'unique_pus_kb_year'"))->isNotEmpty();
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_pus_kb WHERE Key_name = 'jumlah_pus_kb_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_pus_kb', function (Blueprint $table) {
            if (! Schema::hasColumn('jumlah_pus_kb', 'bulan')) {
                $table->string('bulan', 20)->nullable()->after('year');
            }

            if (! Schema::hasColumn('jumlah_pus_kb', 'jumlah')) {
                $table->integer('jumlah')->nullable()->after('bulan');
            }
        });

        Schema::table('jumlah_pus_kb', function (Blueprint $table) use ($hasYearUnique, $hasYearMonthUnique) {
            if ($hasYearUnique) {
                $table->dropUnique('unique_pus_kb_year');
            }

            if (! $hasYearMonthUnique) {
                $table->unique(['year', 'bulan']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_pus_kb WHERE Key_name = 'jumlah_pus_kb_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_pus_kb', function (Blueprint $table) use ($hasYearMonthUnique) {
            if ($hasYearMonthUnique) {
                $table->dropUnique('jumlah_pus_kb_year_bulan_unique');
            }

            if (! collect(DB::select("SHOW INDEX FROM jumlah_pus_kb WHERE Key_name = 'unique_pus_kb_year'"))->isNotEmpty()) {
                $table->unique(['year'], 'unique_pus_kb_year');
            }

            if (Schema::hasColumn('jumlah_pus_kb', 'bulan')) {
                $table->dropColumn('bulan');
            }

            if (Schema::hasColumn('jumlah_pus_kb', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
        });
    }
};
