<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function show(): View|RedirectResponse
    {
        try {
            $cartResponse = $this->api->get('cart');
            $addressesResponse = $this->api->get('customer/addresses');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('cart.index')->with('error', $e->response?->json()['message'] ?? 'Could not load checkout.');
        }
        $cartItems = $cartResponse['data'] ?? [];
        $addresses = $addressesResponse['data'] ?? [];
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        if (empty($addresses)) {
            return redirect()->route('customer.addresses.create')->with('error', 'Please add a shipping address first.');
        }
        return view('checkout.show', [
            'items' => $cartItems,
            'addresses' => is_array($addresses) ? $addresses : [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address_id' => ['required', 'integer'],
            'billing_address_id' => ['required', 'integer'],
            'coupon_code' => ['nullable', 'string'],
            'payment_method' => ['required', 'string', 'in:card,stripe,paypal,cod,bank'],
        ]);
        $data = [
            'shipping_address_id' => (int) $request->shipping_address_id,
            'billing_address_id' => (int) $request->billing_address_id,
            'payment_method' => $request->payment_method,
            'gateway' => $request->payment_method,
        ];
        if ($request->filled('coupon_code')) {
            $data['coupon_code'] = $request->coupon_code;
        }
        try {
            $response = $this->api->post('checkout', $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->withInput()->with('error', $body['message'] ?? 'Checkout failed.');
        }
        $order = $response['data'] ?? [];
        $orderId = $order['id'] ?? null;
        if ($orderId) {
            try {
                $this->api->post("orders/{$orderId}/confirm-payment", []);
            } catch (\Throwable) {
                // optional: simulate immediate payment confirmation
            }
            return redirect()->route('orders.show', $orderId)->with('success', 'Order placed successfully.');
        }
        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }
}
