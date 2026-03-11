<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    public function test_inventory_summary_uses_canonical_schema(): void
    {
        Http::fake([
            '*/admin/reports/inventory-summary' => Http::response([
                'data' => [
                    ['id' => 1, 'name' => 'Test Product', 'slug' => 'test-product', 'stock' => 5, 'price' => 99.5],
                ],
                'low_stock_threshold' => 10,
            ], 200),
        ]);

        $response = $this->get('/admin/reports/inventory-summary');

        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }
}

