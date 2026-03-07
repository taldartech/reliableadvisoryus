<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View|RedirectResponse
    {
        try {
            $response = $this->api->get('cart');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('home')->with('error', $e->response?->json()['message'] ?? 'Could not load cart.');
        }
        $items = $response['data'] ?? [];
        $meta = $response['meta'] ?? [];
        return view('cart.index', [
            'items' => is_array($items) ? $items : [],
            'meta' => $meta,
        ]);
    }

    public function addItem(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        try {
            $this->api->post('cart/items', [
                'product_id' => (int) $request->product_id,
                'quantity' => (int) $request->quantity,
            ]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->with('error', $body['message'] ?? 'Could not add to cart.');
        }
        $back = $request->get('back', route('cart.index'));
        return redirect($back)->with('success', 'Item added to cart.');
    }

    public function updateItem(Request $request, int $id): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        try {
            $this->api->put("cart/items/{$id}", ['quantity' => (int) $request->quantity]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->with('error', $body['message'] ?? 'Could not update cart.');
        }
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function removeItem(int $id): RedirectResponse
    {
        try {
            $this->api->delete("cart/items/{$id}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Could not remove item.');
        }
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        try {
            $this->api->delete('cart');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Could not clear cart.');
        }
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
