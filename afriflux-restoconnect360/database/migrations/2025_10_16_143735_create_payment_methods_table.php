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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name'); // CinetPay, PayTech, Stripe, etc.
            $table->string('slug'); // cinetpay, paytech, stripe, etc.
            $table->string('type'); // mobile_money, card, cash, etc.
            $table->string('provider')->nullable(); // wave, orange_money, mtn, moov, yas
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->json('configuration')->nullable(); // API keys, etc (encrypted)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->decimal('transaction_fee_percentage', 5, 2)->default(0);
            $table->decimal('transaction_fee_fixed', 10, 2)->default(0);
            $table->integer('display_order')->default(0);
            $table->json('supported_currencies')->nullable();
            $table->json('supported_countries')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'is_active']);
            $table->index('slug');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
