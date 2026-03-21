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
        Schema::table('donhangs', function (Blueprint $table) {
            $table->string('ma_donhang')->unique()->nullable()->after('id');
        });

        Schema::table('thanhtoan', function (Blueprint $table) {
            $table->string('magiaodich')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donhangs', function (Blueprint $table) {
            $table->dropColumn('ma_donhang');
        });

        Schema::table('thanhtoan', function (Blueprint $table) {
            $table->string('magiaodich')->nullable(false)->change();
        });
    }
};
