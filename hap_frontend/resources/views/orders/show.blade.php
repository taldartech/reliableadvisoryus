@extends('layouts.app')

@section('title', 'Order ' . ($order['order_number'] ?? '') . ' - ' . config('app.name'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
        <li class="breadcrumb-item active">Order {{ $order['order_number'] ?? $order['id'] }}</li>
    </ol>
</nav>
<h1 class="mb-4">Order {{ $order['order_number'] ?? $order['id'] }}</h1>
@php
    $status = $order['order_status'] ?? '';
    $steps = ['pending_payment' => 'Payment Pending', 'confirmed' => 'Confirmed', 'packed' => 'Packed', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
    $orderStep = array_search($status, array_keys($steps));
@endphp
<div class="mb-4">
    <strong>Status:</strong> <span class="badge bg-primary">{{ $steps[$status] ?? $status }}</span>
</div>
<div class="mb-3">
    <small class="text-muted d-block">Order timeline</small>
    <div class="d-flex flex-wrap gap-2 mt-1">
        @foreach(array_slice(array_keys($steps), 0, 5) as $i => $s)
        <span class="badge {{ $i <= $orderStep ? 'bg-success' : 'bg-light text-dark' }}">{{ $steps[$s] }}</span>
        @if($i < 4)<span class="text-muted">→</span>@endif
        @endforeach
    </div>
</div>
<p><strong>Date:</strong> {{ isset($order['order_date']) ? \Carbon\Carbon::parse($order['order_date'])->format('F j, Y g:i A') : '' }}</p>
<p><strong>Total:</strong> {{ money_inr((float)($order['total_amount'] ?? 0)) }} @if(!empty($order['delivery_charge']))<small class="text-muted">(incl. {{ money_inr($order['delivery_charge']) }} delivery)</small>@endif</p>

@if(!empty($order['shipping_address']))
<h2 class="h6 mt-4">Shipping address</h2>
<p class="text-muted">
    {{ $order['shipping_address']['address_line_1'] ?? '' }}<br>
    @if(!empty($order['shipping_address']['address_line_2'])){{ $order['shipping_address']['address_line_2'] }}<br>@endif
    {{ $order['shipping_address']['city'] ?? '' }}, {{ $order['shipping_address']['state'] ?? '' }} {{ $order['shipping_address']['postal_code'] ?? '' }}<br>
    {{ $order['shipping_address']['country'] ?? '' }}
</p>
@endif

<h2 class="h6 mt-4">Items</h2>
<ul class="list-group">
    @foreach($order['items'] ?? [] as $item)
    @php $product = $item['product'] ?? []; @endphp
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ $product['name'] ?? 'Product' }} x {{ $item['quantity'] ?? 0 }}</span>
        <span>{{ money_inr((float)($item['subtotal'] ?? 0)) }}</span>
    </li>
    @endforeach
</ul>

<a href="{{ route('catalog.products.index') }}" class="btn btn-primary mt-3">Continue shopping</a>
@endsection
