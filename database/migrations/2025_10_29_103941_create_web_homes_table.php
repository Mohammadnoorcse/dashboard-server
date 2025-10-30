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
        Schema::create('web_homes', function (Blueprint $table) {
            $table->id();
            $table->string('bgColor')->nullable();
            $table->string('textColor')->nullable();
            $table->string('hoverColor')->nullable();
            $table->string('activeColor')->nullable();
            $table->string('borderColor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_homes');
    }
};
