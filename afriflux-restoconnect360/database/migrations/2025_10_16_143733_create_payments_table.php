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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_number')->unique();
            $table->string('payment_method'); // cinetpay, paytech, stripe, paypal, cash
            $table->string('payment_provider')->nullable(); // wave, orange_money, mtn_money, moov_money, yas
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('XOF'); // XOF for West African Franc
            $table->string('status')->default('pending'); // pending, processing, completed, failed, refunded
            $table->string('transaction_id')->nullable(); // Provider transaction ID
            $table->string('reference')->nullable(); // Provider reference
            $table->string('payment_url')->nullable(); // Payment URL from provider
            $table->json('metadata')->nullable(); // Additional data from provider
            $table->text('error_message')->nullable();
            $table->integer('error_code')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['order_id', 'status']);
            $table->index('payment_number');
            $table->index('transaction_id');
            $table->index(['payment_method', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
