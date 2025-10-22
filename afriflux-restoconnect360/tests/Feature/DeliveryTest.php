<?php

namespace Tests\Feature;

use App\Models\Delivery\Delivery;
use App\Models\Delivery\Driver;
use App\Models\Restaurant\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function driver_can_accept_delivery()
    {
        $driver = User::factory()->create();
        $driver->assignRole('driver');
        
        $delivery = Delivery::factory()->create([
            'status' => 'pending',
            'driver_id' => null,
        ]);

        $response = $this->actingAs($driver, 'sanctum')
            ->postJson("/api/deliveries/{$delivery->id}/accept");

        $response->assertStatus(200);

        $this->assertDatabaseHas('deliveries', [
            'id' => $delivery->id,
            'driver_id' => $driver->id,
            'status' => 'assigned',
        ]);
    }

    /** @test */
    public function can_update_delivery_location()
    {
        $driver = User::factory()->create();
        $delivery = Delivery::factory()->create([
            'driver_id' => $driver->id,
            'status' => 'in_transit',
        ]);

        $response = $this->actingAs($driver, 'sanctum')
            ->postJson("/api/deliveries/{$delivery->id}/location", [
                'latitude' => 14.7167,
                'longitude' => -17.4677,
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tracking_history', [
            'delivery_id' => $delivery->id,
            'latitude' => 14.7167,
            'longitude' => -17.4677,
        ]);
    }

    /** @test */
    public function can_track_delivery()
    {
        $delivery = Delivery::factory()->create([
            'status' => 'in_transit',
        ]);

        $response = $this->getJson("/api/deliveries/{$delivery->id}/track");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'latitude',
                        'longitude',
                        'timestamp',
                    ]
                ]
            ]);
    }

    /** @test */
    public function can_complete_delivery()
    {
        $driver = User::factory()->create();
        $delivery = Delivery::factory()->create([
            'driver_id' => $driver->id,
            'status' => 'in_transit',
        ]);

        $response = $this->actingAs($driver, 'sanctum')
            ->patchJson("/api/deliveries/{$delivery->id}/status", [
                'status' => 'delivered',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('deliveries', [
            'id' => $delivery->id,
            'status' => 'delivered',
        ]);
    }
}

