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
        Schema::create('features_sidebars', function (Blueprint $table) {
            $table->id();
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('hover_color')->nullable();
            $table->string('active_color')->nullable();
            $table->string('border_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features_sidebars');
    }
};
