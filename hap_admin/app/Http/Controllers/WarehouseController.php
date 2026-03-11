<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function locations(): View
    {
        try {
            $response = $this->api->get('admin/warehouse/locations');
            $locations = $response['data'] ?? [];
        } catch (\Throwable) {
            $locations = [];
        }
        return view('warehouse.locations', ['locations' => $locations]);
    }

    public function goodsInward(Request $request): RedirectResponse|View
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'location_id' => ['required', 'integer'],
                'product_id' => ['required', 'integer'],
                'quantity' => ['required', 'integer', 'min:1'],
            ]);
            try {
                $this->api->post('admin/warehouse/goods-inward', $request->only('location_id', 'product_id', 'quantity') + [
                    'reference' => $request->reference,
                    'notes' => $request->notes,
                ]);
            } catch (\Illuminate\Http\Client\RequestException $e) {
                return back()->withInput()->with('error', $e->response?->json()['message'] ?? 'Failed.');
            }
            return back()->with('success', 'Goods inward recorded.');
        }
        try {
            $locResponse = $this->api->get('admin/warehouse/locations');
            $locations = $locResponse['data'] ?? [];
        } catch (\Throwable) {
            $locations = [];
        }
        return view('warehouse.goods-inward', ['locations' => $locations]);
    }

    public function pickingLists(Request $request): View
    {
        try {
            $response = $this->api->get('admin/warehouse/picking-lists', $request->only('status', 'location_id'));
            $lists = $response['data'] ?? $response;
        } catch (\Throwable) {
            $lists = [];
        }
        return view('warehouse.picking-lists', ['lists' => is_array($lists) ? $lists : []]);
    }

    public function createPickingList(Request $request): RedirectResponse
    {
        $request->validate(['order_id' => ['required', 'integer'], 'location_id' => ['required', 'integer']]);
        try {
            $this->api->post('admin/warehouse/picking-lists', $request->only('order_id', 'location_id'));
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Failed.');
        }
        return back()->with('success', 'Picking list created.');
    }
}
