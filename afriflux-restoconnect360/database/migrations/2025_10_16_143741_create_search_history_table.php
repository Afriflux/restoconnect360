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
        Schema::create('search_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // For anonymous users
            $table->string('search_query')->nullable();
            $table->decimal('search_latitude', 10, 8)->nullable();
            $table->decimal('search_longitude', 11, 8)->nullable();
            $table->decimal('search_radius_km', 8, 2)->nullable();
            $table->json('filters')->nullable(); // cuisine_type, category, etc.
            $table->integer('results_count')->default(0);
            $table->json('results_ids')->nullable(); // IDs of returned restaurants
            $table->foreignId('clicked_restaurant_id')->nullable()->constrained('restaurants')->onDelete('set null');
            $table->integer('click_position')->nullable(); // Position in search results
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('searched_at');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('session_id');
            $table->index('clicked_restaurant_id');
            $table->index('searched_at');
            $table->index(['search_latitude', 'search_longitude']);
            // Note: fullText index not supported in SQLite
            $table->index('search_query');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_history');
    }
};
