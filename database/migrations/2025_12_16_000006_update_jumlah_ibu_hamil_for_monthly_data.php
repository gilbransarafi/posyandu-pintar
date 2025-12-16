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
        $hasYearUnique = collect(DB::select("SHOW INDEX FROM jumlah_ibu_hamil WHERE Key_name = 'unique_ibu_hamil_year'"))->isNotEmpty();
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_ibu_hamil WHERE Key_name = 'jumlah_ibu_hamil_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_ibu_hamil', function (Blueprint $table) {
            if (! Schema::hasColumn('jumlah_ibu_hamil', 'bulan')) {
                $table->string('bulan', 20)->nullable()->after('year');
            }

            if (! Schema::hasColumn('jumlah_ibu_hamil', 'jumlah')) {
                $table->integer('jumlah')->nullable()->after('bulan');
            }
        });

        Schema::table('jumlah_ibu_hamil', function (Blueprint $table) use ($hasYearUnique, $hasYearMonthUnique) {
            if ($hasYearUnique) {
                $table->dropUnique('unique_ibu_hamil_year');
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
        $hasYearMonthUnique = collect(DB::select("SHOW INDEX FROM jumlah_ibu_hamil WHERE Key_name = 'jumlah_ibu_hamil_year_bulan_unique'"))->isNotEmpty();

        Schema::table('jumlah_ibu_hamil', function (Blueprint $table) use ($hasYearMonthUnique) {
            if ($hasYearMonthUnique) {
                $table->dropUnique('jumlah_ibu_hamil_year_bulan_unique');
            }

            if (! collect(DB::select("SHOW INDEX FROM jumlah_ibu_hamil WHERE Key_name = 'unique_ibu_hamil_year'"))->isNotEmpty()) {
                $table->unique(['year'], 'unique_ibu_hamil_year');
            }

            if (Schema::hasColumn('jumlah_ibu_hamil', 'bulan')) {
                $table->dropColumn('bulan');
            }

            if (Schema::hasColumn('jumlah_ibu_hamil', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
        });
    }
};
