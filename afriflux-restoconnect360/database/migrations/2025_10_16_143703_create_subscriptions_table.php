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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('plan_name'); // starter, professional, enterprise
            $table->decimal('price', 10, 2);
            $table->string('billing_cycle'); // monthly, yearly
            $table->integer('max_restaurants')->default(1);
            $table->integer('max_products')->default(100);
            $table->integer('max_orders')->default(100);
            $table->boolean('has_pos')->default(false);
            $table->boolean('has_delivery')->default(false);
            $table->boolean('has_whatsapp')->default(false);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_custom_domain')->default(false);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('status')->default('active'); // active, suspended, canceled, expired
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['company_id', 'status']);
            $table->index('ends_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
