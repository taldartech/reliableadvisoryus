@extends('layouts.app')

@section('title', 'Cart - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Your Cart</h1>

@if(empty($items))
<p class="text-muted">Your cart is empty.</p>
<a href="{{ route('catalog.products.index') }}" class="btn btn-primary">Continue shopping</a>
@else
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            @php
                $product = $item['product'] ?? [];
                $price = (float) ($product['price'] ?? 0);
                $qty = (int) ($item['quantity'] ?? 0);
                $subtotal = $price * $qty;
            @endphp
            <tr>
                <td>{{ $product['name'] ?? 'Product' }}</td>
                <td>{{ money_inr($price) }}</td>
                <td>
                    <form method="POST" action="{{ route('cart.items.update', $item['id']) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $qty }}" min="1" class="form-control form-control-sm d-inline-block" style="width: 70px;" onchange="this.form.submit()">
                    </form>
                </td>
                <td>{{ money_inr($subtotal) }}</td>
                <td>
                    <form method="POST" action="{{ route('cart.items.destroy', $item['id']) }}" class="d-inline" onsubmit="return confirm('Remove this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<p class="fw-bold">Total items: {{ $meta['total_items'] ?? array_sum(array_column($items, 'quantity')) }}</p>

<form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-secondary" onclick="return confirm('Clear entire cart?');">Clear cart</button>
</form>
<a href="{{ route('checkout.show') }}" class="btn btn-primary">Proceed to checkout</a>
<a href="{{ route('catalog.products.index') }}" class="btn btn-link">Continue shopping</a>
@endif
@endsection
