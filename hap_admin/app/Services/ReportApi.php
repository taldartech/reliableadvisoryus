<?php

namespace App\Services;

use Illuminate\Support\Arr;

class ReportApi
{
    public function __construct(
        protected HapApiService $api,
    ) {}

    public function salesSummary(array $filters): array
    {
        try {
            $data = $this->api->get('admin/reports/sales-summary', $filters);
        } catch (\Throwable) {
            $data = [];
        }

        $summary = Arr::get($data, 'summary', []);

        return [
            'from_date' => $filters['from_date'] ?? null,
            'to_date' => $filters['to_date'] ?? null,
            'summary' => [
                'online_total' => (float) ($summary['online_total'] ?? 0),
                'pos_total' => (float) ($summary['pos_total'] ?? 0),
                'grand_total' => (float) ($summary['grand_total'] ?? 0),
            ],
            'by_date' => Arr::get($data, 'by_date', []),
        ];
    }

    public function orderStatus(array $filters): array
    {
        try {
            $data = $this->api->get('admin/reports/order-status', $filters);
        } catch (\Throwable) {
            $data = [];
        }

        return [
            'from_date' => $filters['from_date'] ?? null,
            'to_date' => $filters['to_date'] ?? null,
            'by_status' => Arr::get($data, 'by_status', []),
        ];
    }

    public function inventorySummary(): array
    {
        try {
            $response = $this->api->get('admin/reports/inventory-summary');
        } catch (\Throwable) {
            $response = [];
        }

        return [
            'data' => Arr::get($response, 'data', []),
            'low_stock_threshold' => (int) Arr::get($response, 'low_stock_threshold', 10),
        ];
    }
}

