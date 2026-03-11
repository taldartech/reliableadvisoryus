@extends('layouts.app')

@section('title', 'Guest Checkout - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Guest Checkout</h1>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-md-6">
        <h2 class="h6 mb-3">Contact details</h2>
        <form method="POST" action="{{ route('guest-checkout.store', $product['id']) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Full name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">Phone (optional)</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
            </div>

            <h2 class="h6 mb-3">Shipping address</h2>
            <div class="mb-3">
                <label class="form-label" for="shipping_address_line_1">Address line 1</label>
                <input type="text" name="shipping_address[address_line_1]" id="shipping_address_line_1" class="form-control" value="{{ old('shipping_address.address_line_1') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_city">City</label>
                <input type="text" name="shipping_address[city]" id="shipping_city" class="form-control" value="{{ old('shipping_address.city') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_state">State</label>
                <input type="text" name="shipping_address[state]" id="shipping_state" class="form-control" value="{{ old('shipping_address.state') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_postal_code">Postal code</label>
                <input type="text" name="shipping_address[postal_code]" id="shipping_postal_code" class="form-control" value="{{ old('shipping_address.postal_code') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_country">Country</label>
                <input type="text" name="shipping_address[country]" id="shipping_country" class="form-control" value="{{ old('shipping_address.country', 'India') }}" required>
            </div>

            <h2 class="h6 mb-3">Billing address</h2>
            <div class="mb-3">
                <label class="form-label" for="billing_address_line_1">Address line 1</label>
                <input type="text" name="billing_address[address_line_1]" id="billing_address_line_1" class="form-control" value="{{ old('billing_address.address_line_1') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="billing_city">City</label>
                <input type="text" name="billing_address[city]" id="billing_city" class="form-control" value="{{ old('billing_address.city') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="billing_state">State</label>
                <input type="text" name="billing_address[state]" id="billing_state" class="form-control" value="{{ old('billing_address.state') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="billing_postal_code">Postal code</label>
                <input type="text" name="billing_address[postal_code]" id="billing_postal_code" class="form-control" value="{{ old('billing_address.postal_code') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="billing_country">Country</label>
                <input type="text" name="billing_address[country]" id="billing_country" class="form-control" value="{{ old('billing_address.country', 'India') }}" required>
            </div>

            <h2 class="h6 mb-3">Order details</h2>
            <div class="mb-3">
                <label class="form-label" for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', $quantity) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="coupon_code">Coupon code (optional)</label>
                <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="{{ old('coupon_code') }}">
            </div>

            <div class="mb-3">
                <label class="form-label" for="payment_method">Payment method</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on delivery</option>
                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                    <option value="wallets" {{ old('payment_method') == 'wallets' ? 'selected' : '' }}>Wallets</option>
                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank transfer</option>
                    <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Place order as guest</button>
        </form>
    </div>
    <div class="col-md-6">
        <h2 class="h6 mb-3">Product</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] ?? 'Product' }}</h5>
                @if(!empty($product['short_description']))
                    <p class="card-text text-muted">{{ $product['short_description'] }}</p>
                @endif
                <p class="card-text fw-bold mb-0">{{ money_inr((float)($product['price'] ?? 0)) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

