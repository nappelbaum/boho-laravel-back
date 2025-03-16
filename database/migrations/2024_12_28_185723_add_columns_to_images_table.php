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
        Schema::table('images', function (Blueprint $table) {
            $table->string('copy_main')->default(NULL)->after('main_path');
            $table->string('copy_2400')->default(NULL)->after('copy_main');
            $table->string('copy_1600')->default(NULL)->after('copy_2400');
            $table->string('copy_1200')->default(NULL)->after('copy_1600');
            $table->string('copy_800')->default(NULL)->after('copy_1200');
            $table->string('copy_400')->default(NULL)->after('copy_800');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('copy_main');
            $table->dropColumn('copy_2400');
            $table->dropColumn('copy_1600');
            $table->dropColumn('copy_1200');
            $table->dropColumn('copy_800');
            $table->dropColumn('copy_400');
        });
    }
};
