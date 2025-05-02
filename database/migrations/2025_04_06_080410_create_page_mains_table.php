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
        Schema::create('page_mains', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('slogan');
            $table->string('main_path');
            $table->string('copy_main');
            $table->string('copy_2400');
            $table->string('copy_1600');
            $table->string('copy_1200');
            $table->string('copy_800');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_mains');
    }
};
