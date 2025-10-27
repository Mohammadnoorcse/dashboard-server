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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_desc')->nullable();
            $table->json('description')->nullable();
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->nullable();
            $table->integer('stock')->default(0);
            $table->tinyInteger('status')->default(1); // 0 = Draft, 1 = Published
            $table->string('currency')->default('USD');
            $table->json('tax_status_id')->nullable();
            $table->json('shipping_id')->nullable();
            $table->json('color_id')->nullable();
            $table->json('size_id')->nullable();
            $table->json('categories_id')->nullable();
            $table->json('brands_id')->nullable();
            $table->json('section_id')->nullable();
            $table->string('discount_id')->nullable();
            $table->string('coupon_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
