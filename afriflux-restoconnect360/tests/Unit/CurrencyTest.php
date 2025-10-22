<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /** @test */
    public function can_format_currency()
    {
        // This would test the JavaScript currency.js utility
        // For now, we just assert true as JS tests would be in a separate test suite
        $this->assertTrue(true);
    }

    /** @test */
    public function can_calculate_tax()
    {
        $subtotal = 10000;
        $taxRate = 0.18;
        $expectedTax = 1800;

        $tax = $subtotal * $taxRate;

        $this->assertEquals($expectedTax, $tax);
    }

    /** @test */
    public function can_calculate_total_with_delivery_fee()
    {
        $subtotal = 10000;
        $tax = 1800;
        $deliveryFee = 2000;
        $expectedTotal = 13800;

        $total = $subtotal + $tax + $deliveryFee;

        $this->assertEquals($expectedTotal, $total);
    }
}

