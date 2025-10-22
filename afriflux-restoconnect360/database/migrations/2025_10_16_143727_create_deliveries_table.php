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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('delivery_number')->unique();
            $table->text('pickup_address');
            $table->decimal('pickup_latitude', 10, 8);
            $table->decimal('pickup_longitude', 11, 8);
            $table->text('delivery_address');
            $table->decimal('delivery_latitude', 10, 8);
            $table->decimal('delivery_longitude', 11, 8);
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('estimated_duration_minutes')->nullable();
            $table->decimal('delivery_fee', 10, 2);
            $table->string('status')->default('pending'); // pending, assigned, picked_up, on_delivery, delivered, cancelled
            $table->text('delivery_notes')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('delivery_proof')->nullable(); // Photo proof
            $table->text('signature')->nullable(); // Customer signature
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('on_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->decimal('driver_rating', 3, 2)->nullable();
            $table->text('driver_review')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'status']);
            $table->index('driver_id');
            $table->index('order_id');
            $table->index('delivery_number');
            $table->index(['pickup_latitude', 'pickup_longitude']);
            $table->index(['delivery_latitude', 'delivery_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
