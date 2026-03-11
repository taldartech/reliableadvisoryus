<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestCheckoutController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function show(Request $request, int $productId): View|RedirectResponse
    {
        try {
            $productResponse = $this->api->get("catalog/products/{$productId}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('catalog.products.index')
                ->with('error', $e->response?->json()['message'] ?? 'Product not found.');
        }

        $product = $productResponse['data'] ?? $productResponse;

        return view('checkout.guest', [
            'product' => $product,
            'quantity' => (int) $request->input('quantity', 1),
        ]);
    }

    public function store(Request $request, int $productId): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'shipping_address.address_line_1' => ['required', 'string'],
            'shipping_address.city' => ['required', 'string'],
            'shipping_address.state' => ['nullable', 'string'],
            'shipping_address.postal_code' => ['nullable', 'string'],
            'shipping_address.country' => ['required', 'string'],
            'billing_address.address_line_1' => ['required', 'string'],
            'billing_address.city' => ['required', 'string'],
            'billing_address.state' => ['nullable', 'string'],
            'billing_address.postal_code' => ['nullable', 'string'],
            'billing_address.country' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'coupon_code' => ['nullable', 'string'],
            'payment_method' => ['required', 'string', 'in:cash,card,upi,wallets,cod,bank,stripe,paypal'],
        ]);

        $items = [[
            'product_id' => $productId,
            'quantity' => (int) $validated['quantity'],
        ]];

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'shipping_address' => $validated['shipping_address'],
            'billing_address' => $validated['billing_address'],
            'items' => $items,
            'payment_method' => $validated['payment_method'],
            'gateway' => $validated['payment_method'],
        ];

        if (! empty($validated['coupon_code'])) {
            $payload['coupon_code'] = $validated['coupon_code'];
        }

        try {
            $response = $this->api->post('checkout/guest', $payload);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->withInput()->with('error', $body['message'] ?? 'Guest checkout failed.');
        }

        $order = $response['data'] ?? [];

        return redirect()->route('home')->with('success', 'Order placed successfully. We have emailed your order details.');
    }
}

