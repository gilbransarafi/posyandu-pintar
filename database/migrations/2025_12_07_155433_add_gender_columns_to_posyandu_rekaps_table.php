<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('posyandu_rekaps', function (Blueprint $table) {
        $table->integer('male')->nullable()->default(0);
        $table->integer('female')->nullable()->default(0);
    });
}

public function down()
{
    Schema::table('posyandu_rekaps', function (Blueprint $table) {
        $table->dropColumn(['male', 'female']);
    });
}

};
