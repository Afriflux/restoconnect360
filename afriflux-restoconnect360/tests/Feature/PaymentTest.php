<?php

namespace Tests\Feature;

use App\Models\Payment\Payment;
use App\Models\Restaurant\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_initiate_cinetpay_payment()
    {
        $this->markTestSkipped('CinetPay API requires real credentials');
        
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total' => 10000,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/payments/cinetpay/initiate', [
                'order_id' => $order->id,
                'amount' => 10000,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'payment_url',
                    'transaction_id',
                ]
            ]);
    }

    /** @test */
    public function can_process_cash_payment()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total' => 10000,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/payments/cash', [
                'order_id' => $order->id,
                'amount' => 10000,
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'method' => 'cash',
            'amount' => 10000,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function cannot_pay_more_than_order_total()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total' => 10000,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/payments/cash', [
                'order_id' => $order->id,
                'amount' => 15000, // More than order total
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function can_get_payment_history()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        Payment::factory()->count(3)->create(['order_id' => $order->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/payments?order_id={$order->id}");

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}

