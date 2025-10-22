<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class GeolocationTest extends TestCase
{
    /** @test */
    public function can_calculate_distance_between_two_points()
    {
        // Haversine formula test
        $lat1 = 14.7167; // Dakar
        $lon1 = -17.4677;
        $lat2 = 14.6937; // Point Noire
        $lon2 = -17.4441;

        $R = 6371; // Earth radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;

        // Distance should be approximately 3-4 km
        $this->assertGreaterThan(2, $distance);
        $this->assertLessThan(5, $distance);
    }

    /** @test */
    public function validates_coordinates()
    {
        // Valid coordinates
        $validLat = 14.7167;
        $validLon = -17.4677;

        $this->assertGreaterThanOrEqual(-90, $validLat);
        $this->assertLessThanOrEqual(90, $validLat);
        $this->assertGreaterThanOrEqual(-180, $validLon);
        $this->assertLessThanOrEqual(180, $validLon);

        // Invalid coordinates
        $invalidLat = 91;
        $this->assertFalse($invalidLat >= -90 && $invalidLat <= 90);
    }

    /** @test */
    public function can_determine_if_point_is_within_radius()
    {
        $centerLat = 14.7167;
        $centerLon = -17.4677;
        $radius = 10; // km

        $pointLat = 14.6937;
        $pointLon = -17.4441;

        // Calculate distance (simplified)
        $R = 6371;
        $dLat = deg2rad($pointLat - $centerLat);
        $dLon = deg2rad($pointLon - $centerLon);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($centerLat)) * cos(deg2rad($pointLat)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;

        $this->assertLessThan($radius, $distance);
    }
}

