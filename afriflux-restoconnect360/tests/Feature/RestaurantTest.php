<?php

namespace Tests\Feature;

use App\Models\Platform\Company;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_restaurants()
    {
        Restaurant::factory()->count(5)->create(['is_active' => true]);

        $response = $this->getJson('/api/restaurants');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'cuisine_type',
                        'rating',
                        'is_active',
                    ]
                ],
                'meta'
            ]);
    }

    /** @test */
    public function can_get_restaurant_details()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $restaurant->id,
                    'name' => $restaurant->name,
                ],
            ]);
    }

    /** @test */
    public function can_search_nearby_restaurants()
    {
        // Create restaurants with coordinates
        Restaurant::factory()->create([
            'latitude' => 14.7167,
            'longitude' => -17.4677,
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/geolocation/nearby?latitude=14.7167&longitude=-17.4677&radius=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'latitude',
                        'longitude',
                        'distance',
                    ]
                ]
            ]);
    }

    /** @test */
    public function inactive_restaurants_are_not_listed()
    {
        Restaurant::factory()->create(['is_active' => false]);
        Restaurant::factory()->create(['is_active' => true]);

        $response = $this->getJson('/api/restaurants');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertTrue($data[0]['is_active']);
    }
}

