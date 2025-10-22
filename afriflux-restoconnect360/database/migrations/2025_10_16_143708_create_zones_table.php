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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Terrasse, Salle principale, VIP, etc.
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('color')->default('#667eea'); // Color for visualization
            $table->integer('capacity')->default(0); // Total capacity
            $table->integer('table_count')->default(0); // Number of tables
            $table->boolean('is_smoking_allowed')->default(false);
            $table->boolean('is_outdoor')->default(false);
            $table->boolean('is_vip')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'is_active']);
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
