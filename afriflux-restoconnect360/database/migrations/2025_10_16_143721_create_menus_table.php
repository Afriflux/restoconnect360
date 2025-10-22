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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Breakfast, Lunch, Dinner, etc.
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('type')->default('all_day'); // all_day, breakfast, lunch, dinner, seasonal
            $table->json('availability_times')->nullable(); // {'start': '08:00', 'end': '11:00'}
            $table->json('availability_days')->nullable(); // [1,2,3,4,5,6,7] Monday-Sunday
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'is_active']);
            $table->index('type');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
