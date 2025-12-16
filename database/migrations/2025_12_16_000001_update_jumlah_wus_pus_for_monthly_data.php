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
        $hasYearUnique = collect(DB::select("SHOW INDEX FROM jumlah_wus_pus WHERE Key_name = 'jumlah_wus_pus_year_unique'"))->isNotEmpty();
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_wus_pus WHERE Key_name = 'jumlah_wus_pus_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_wus_pus', function (Blueprint $table) {
            // Tambah kolom bulan & jumlah untuk input bulanan
            if (! Schema::hasColumn('jumlah_wus_pus', 'bulan')) {
                $table->string('bulan', 20)->nullable()->after('year');
            }

            if (! Schema::hasColumn('jumlah_wus_pus', 'jumlah')) {
                $table->integer('jumlah')->nullable()->after('bulan');
            }
        });

        Schema::table('jumlah_wus_pus', function (Blueprint $table) use ($hasYearUnique, $hasYearMonthUnique) {
            // Ganti unique per tahun menjadi kombinasi tahun + bulan
            if ($hasYearUnique) {
                $table->dropUnique('jumlah_wus_pus_year_unique');
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
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_wus_pus WHERE Key_name = 'jumlah_wus_pus_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_wus_pus', function (Blueprint $table) use ($hasYearMonthUnique) {
            if ($hasYearMonthUnique) {
                $table->dropUnique('jumlah_wus_pus_year_bulan_unique');
            }

            // Pulihkan unique tahun jika kolom masih ada
            if (Schema::hasColumn('jumlah_wus_pus', 'year')) {
                $table->unique(['year']);
            }

            if (Schema::hasColumn('jumlah_wus_pus', 'bulan')) {
                $table->dropColumn('bulan');
            }

            if (Schema::hasColumn('jumlah_wus_pus', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
        });
    }
};
