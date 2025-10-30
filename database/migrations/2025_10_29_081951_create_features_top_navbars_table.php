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
        Schema::create('features_top_navbars', function (Blueprint $table) {
             $table->id();
             $table->string('title')->nullable();
             $table->string('text_color')->nullable()->default('#000000');
             $table->string('bg_color')->nullable()->default('#f3f4f6');
             $table->string('icon_bg_color')->nullable()->default('#2563eb');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features_top_navbars');
    }
};
