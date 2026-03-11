@extends('layouts.app')

@section('title', 'Order ' . ($order['order_number'] ?? ''))

@section('content')
<h1 class="mb-4">Order {{ $order['order_number'] ?? $order['id'] }}</h1>
<p><strong>Status:</strong> <span class="badge bg-primary">{{ $order['order_status'] ?? '' }}</span></p>
<p><strong>Total:</strong> ₹{{ number_format((float)($order['total_amount'] ?? 0), 2) }}</p>

<form method="POST" action="{{ route('admin.orders.update-status', $order['id']) }}" class="mb-3 d-inline">
    @csrf
    <select name="order_status" class="form-select form-select-sm d-inline-block w-auto">
        <option value="confirmed" {{ ($order['order_status'] ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="packed" {{ ($order['order_status'] ?? '') == 'packed' ? 'selected' : '' }}>Packed</option>
        <option value="shipped" {{ ($order['order_status'] ?? '') == 'shipped' ? 'selected' : '' }}>Shipped</option>
        <option value="delivered" {{ ($order['order_status'] ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
        <option value="cancelled" {{ ($order['order_status'] ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    <button type="submit" class="btn btn-sm btn-primary">Update status</button>
</form>

<form method="POST" action="{{ route('admin.orders.assign-location', $order['id']) }}" class="mb-3 d-inline ms-2">
    @csrf
    <select name="assigned_location_id" class="form-select form-select-sm d-inline-block w-auto">
        @foreach($locations ?? [] as $loc)
        <option value="{{ $loc['id'] }}" {{ ($order['assigned_location_id'] ?? '') == $loc['id'] ? 'selected' : '' }}>{{ $loc['name'] }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-sm btn-outline-secondary">Assign location</button>
</form>

@if(!in_array($order['order_status'] ?? '', ['shipped', 'delivered', 'cancelled']))
<form method="POST" action="{{ route('admin.orders.dispatch', $order['id']) }}" class="mb-3 d-inline ms-2">
    @csrf
    <input type="text" name="tracking_number" class="form-control form-control-sm d-inline-block w-auto" placeholder="Tracking #">
    <input type="text" name="carrier" class="form-control form-control-sm d-inline-block w-auto" placeholder="Carrier">
    <button type="submit" class="btn btn-sm btn-success">Dispatch</button>
</form>
@endif

<h2 class="h6 mt-4">Items</h2>
<ul class="list-group">
    @foreach($order['items'] ?? [] as $item)
    <li class="list-group-item d-flex justify-content-between">
        <span>{{ $item['product']['name'] ?? 'Product' }} x {{ $item['quantity'] ?? 0 }}</span>
        <span>₹{{ number_format((float)($item['subtotal'] ?? 0), 2) }}</span>
    </li>
    @endforeach
</ul>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Back to orders</a>
@endsection
