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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Senegal');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('cuisine_type')->nullable(); // african, french, italian, etc.
            $table->string('category')->default('restaurant'); // restaurant, cafe, bar, fast_food
            $table->json('opening_hours')->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->decimal('delivery_radius_km', 5, 2)->default(10);
            $table->boolean('accepts_delivery')->default(true);
            $table->boolean('accepts_takeaway')->default(true);
            $table->boolean('accepts_dine_in')->default(true);
            $table->boolean('has_pos')->default(false);
            $table->boolean('has_kiosk')->default(false);
            $table->boolean('has_qr_menu')->default(false);
            $table->boolean('has_whatsapp')->default(false);
            $table->string('whatsapp_number')->nullable();
            $table->string('theme')->default('default');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['company_id', 'is_active']);
            $table->index(['slug', 'is_active']);
            $table->index('category');
            $table->index('is_featured');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
