<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        try {
            $params = array_filter([
                'order_status' => $request->order_status,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'per_page' => $request->get('per_page', 15),
            ]);
            $response = $this->api->get('admin/orders', $params);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('admin.dashboard')->with('error', $e->response?->json()['message'] ?? 'Could not load orders.');
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
            $response = $this->api->get("admin/orders/{$id}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found.');
        }
        $order = $response['data'] ?? [];
        $locations = [];
        try {
            $locations = $this->api->get('admin/warehouse/locations')['data'] ?? [];
        } catch (\Throwable) {
        }

        return view('orders.show', ['order' => $order, 'locations' => $locations]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate(['order_status' => ['required', 'in:confirmed,packed,shipped,delivered,cancelled']]);
        try {
            $this->api->put("admin/orders/{$id}/status", ['order_status' => $request->order_status]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Update failed.');
        }
        return back()->with('success', 'Status updated.');
    }

    public function assignLocation(Request $request, int $id): RedirectResponse
    {
        $request->validate(['assigned_location_id' => ['required', 'integer']]);
        try {
            $this->api->put("admin/orders/{$id}/assign-location", ['assigned_location_id' => (int) $request->assigned_location_id]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Update failed.');
        }
        return back()->with('success', 'Order assigned to location.');
    }

    public function dispatch(Request $request, int $id): RedirectResponse
    {
        try {
            $this->api->post("admin/orders/{$id}/dispatch", [
                'tracking_number' => $request->tracking_number,
                'carrier' => $request->carrier,
            ]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Dispatch failed.');
        }
        return back()->with('success', 'Order dispatched.');
    }
}
