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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('license_number')->nullable();
            $table->string('license_photo')->nullable();
            $table->string('vehicle_type')->nullable(); // motorcycle, car, bicycle, scooter
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_plate_number')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->string('vehicle_photo')->nullable();
            $table->string('status')->default('offline'); // online, offline, busy, on_break
            $table->decimal('current_latitude', 10, 8)->nullable();
            $table->decimal('current_longitude', 11, 8)->nullable();
            $table->timestamp('last_location_update')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_deliveries')->default(0);
            $table->integer('successful_deliveries')->default(0);
            $table->integer('cancelled_deliveries')->default(0);
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(20); // Platform commission %
            $table->json('working_hours')->nullable();
            $table->json('delivery_zones')->nullable(); // Preferred delivery zones
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index(['status', 'is_available']);
            $table->index('is_verified');
            $table->index(['current_latitude', 'current_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
