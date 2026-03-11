@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Checkout</h1>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <h2 class="h6 mb-3">Shipping address</h2>
            <select name="shipping_address_id" class="form-select mb-3" required>
                <option value="">Select address</option>
                @foreach($addresses as $addr)
                <option value="{{ $addr['id'] }}" {{ old('shipping_address_id') == $addr['id'] ? 'selected' : '' }}>
                    {{ $addr['address_line_1'] }}, {{ $addr['city'] }}, {{ $addr['postal_code'] }}, {{ $addr['country'] }}
                </option>
                @endforeach
            </select>
            <h2 class="h6 mb-3">Billing address</h2>
            <select name="billing_address_id" class="form-select mb-3" required>
                <option value="">Select address</option>
                @foreach($addresses as $addr)
                <option value="{{ $addr['id'] }}" {{ old('billing_address_id') == $addr['id'] ? 'selected' : '' }}>
                    {{ $addr['address_line_1'] }}, {{ $addr['city'] }}, {{ $addr['postal_code'] }}, {{ $addr['country'] }}
                </option>
                @endforeach
            </select>
            <div class="mb-3">
                <label for="coupon_code" class="form-label">Coupon code (optional)</label>
                <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}">
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment method</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on delivery</option>
                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank transfer</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <h2 class="h6 mb-3">Order summary</h2>
            <ul class="list-group mb-3">
                @foreach($items as $item)
                @php
                    $product = $item['product'] ?? [];
                    $price = (float) ($product['price'] ?? 0);
                    $qty = (int) ($item['quantity'] ?? 0);
                @endphp
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $product['name'] ?? 'Product' }} x {{ $qty }}</span>
                    <span>{{ money_inr($price * $qty) }}</span>
                </li>
                @endforeach
            </ul>
            <div class="list-group list-group-flush mb-3">
                <div class="list-group-item d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span>{{ money_inr($subtotal ?? 0) }}</span>
                </div>
                <div class="list-group-item d-flex justify-content-between">
                    <span>Delivery</span>
                    <span>{{ money_inr($delivery_charge ?? 0) }} @if(($delivery_charge ?? 0) == 0)<small class="text-muted">(Free delivery – order above {{ money_inr($threshold_amount ?? 2000) }})</small>@endif</span>
                </div>
                <div class="list-group-item d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span>{{ money_inr(($subtotal ?? 0) + ($delivery_charge ?? 0)) }}</span>
                </div>
            </div>
            @if(!empty($delivery_sla_hours))<p class="small text-muted">{{ $delivery_sla_hours }}-hour delivery</p>@endif
            <button type="submit" class="btn btn-primary btn-lg">Place order</button>
        </div>
    </div>
</form>
@endsection
