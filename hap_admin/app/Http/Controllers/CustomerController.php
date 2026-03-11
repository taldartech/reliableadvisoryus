<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(Request $request): View
    {
        try {
            $response = $this->api->get('admin/customers', array_filter([
                'search' => $request->search,
                'per_page' => $request->get('per_page', 15),
            ]));
        } catch (\Throwable) {
            $response = ['data' => [], 'meta' => []];
        }
        $customers = $response['data'] ?? [];
        $meta = $response['meta'] ?? [];

        return view('customers.index', [
            'customers' => is_array($customers) ? $customers : [],
            'meta' => $meta,
        ]);
    }

    public function show(int $id): View
    {
        try {
            $response = $this->api->get("admin/customers/{$id}");
        } catch (\Throwable) {
            $response = ['data' => []];
        }
        return view('customers.show', ['customer' => $response['data'] ?? []]);
    }
}
