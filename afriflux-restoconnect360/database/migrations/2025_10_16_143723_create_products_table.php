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
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('compare_price', 10, 2)->nullable(); // Original price for discounts
            $table->integer('stock_quantity')->default(0);
            $table->boolean('track_inventory')->default(false);
            $table->integer('low_stock_threshold')->default(10);
            $table->string('unit')->default('unit'); // unit, kg, g, l, ml, etc.
            $table->json('images')->nullable(); // Array of image URLs
            $table->string('featured_image')->nullable();
            $table->json('options')->nullable(); // Size, Color, etc.
            $table->json('variants')->nullable(); // Product variants
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_gluten_free')->default(false);
            $table->boolean('is_spicy')->default(false);
            $table->json('allergens')->nullable(); // ['nuts', 'dairy', etc.]
            $table->integer('preparation_time')->default(15); // in minutes
            $table->integer('calories')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_sold')->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'is_available']);
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('sku');
            $table->index('barcode');
            // Note: fullText index not supported in SQLite
            $table->index('name');
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
