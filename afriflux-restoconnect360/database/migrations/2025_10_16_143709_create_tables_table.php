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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name'); // Table 1, Table 2, etc.
            $table->string('number')->nullable(); // T1, T2, etc.
            $table->integer('capacity')->default(4);
            $table->string('shape')->default('square'); // square, round, rectangular
            $table->string('qr_code')->nullable(); // QR code for menu
            $table->string('status')->default('available'); // available, occupied, reserved, cleaning
            $table->integer('position_x')->nullable(); // Position on floor plan
            $table->integer('position_y')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'status']);
            $table->index('zone_id');
            $table->unique(['restaurant_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
