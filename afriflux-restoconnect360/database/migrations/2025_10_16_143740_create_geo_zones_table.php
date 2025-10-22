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
        Schema::create('geo_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Dakar, Thiès, etc.
            $table->string('slug');
            $table->string('type'); // city, region, neighborhood, custom
            $table->text('description')->nullable();
            $table->decimal('center_latitude', 10, 8);
            $table->decimal('center_longitude', 11, 8);
            $table->decimal('radius_km', 8, 2)->nullable();
            $table->json('polygon_coordinates')->nullable(); // For complex boundaries
            $table->json('bounds')->nullable(); // NE, SW coordinates
            $table->string('country')->default('Senegal');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->integer('restaurant_count')->default(0);
            $table->integer('active_drivers')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('timezone')->default('Africa/Dakar');
            $table->string('color')->default('#667eea'); // For map visualization
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index(['type', 'is_active']);
            $table->index('is_featured');
            $table->index(['center_latitude', 'center_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_zones');
    }
};
