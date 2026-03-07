<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View|RedirectResponse
    {
        try {
            $response = $this->api->get('orders');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('home')->with('error', $e->response?->json()['message'] ?? 'Could not load orders.');
        }
        $orders = $response['data'] ?? [];
        $meta = $response['meta'] ?? [];
        return view('orders.index', [
            'orders' => is_array($orders) ? $orders : [],
            'meta' => $meta,
        ]);
    }

    public function show(int $id): View|RedirectResponse
    {
        try {
            $response = $this->api->get("orders/{$id}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('orders.index')->with('error', $e->response?->json()['message'] ?? 'Order not found.');
        }
        $order = $response['data'] ?? $response;
        return view('orders.show', ['order' => $order]);
    }
}
