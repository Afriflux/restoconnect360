<?php

namespace Tests\Feature;

use App\Models\Restaurant\Order;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_order()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        $product = Product::factory()->create([
            'restaurant_id' => $restaurant->id,
            'price' => 5000,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/orders', [
                'restaurant_id' => $restaurant->id,
                'items' => [
                    [
                        'product_id' => $product->id,
                        'quantity' => 2,
                        'price' => $product->price,
                    ]
                ],
                'order_type' => 'delivery',
                'delivery_address' => '123 Test Street, Dakar',
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
                'customer_email' => $user->email,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'order_number',
                    'status',
                    'total',
                    'items',
                ]
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
    }

    /** @test */
    public function can_update_order_status()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->patchJson("/api/orders/{$order->id}/status", [
                'status' => 'confirmed',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }

    /** @test */
    public function can_get_user_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function cannot_create_order_without_items()
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/orders', [
                'restaurant_id' => $restaurant->id,
                'items' => [],
                'order_type' => 'delivery',
            ]);

        $response->assertStatus(422);
    }
}

