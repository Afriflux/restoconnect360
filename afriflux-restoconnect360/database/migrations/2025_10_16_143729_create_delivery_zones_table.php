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
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('center_latitude', 10, 8);
            $table->decimal('center_longitude', 11, 8);
            $table->decimal('radius_km', 8, 2)->default(5);
            $table->json('polygon_coordinates')->nullable(); // For complex zones
            $table->decimal('base_delivery_fee', 10, 2)->default(0);
            $table->decimal('price_per_km', 10, 2)->default(0);
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->integer('estimated_delivery_time')->default(30); // in minutes
            $table->boolean('is_active')->default(true);
            $table->string('color')->default('#667eea'); // For map visualization
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'is_active']);
            $table->index(['center_latitude', 'center_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};
