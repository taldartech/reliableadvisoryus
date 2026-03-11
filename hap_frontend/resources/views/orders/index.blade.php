@extends('layouts.app')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<h1 class="mb-4">My Orders</h1>

@if(empty($orders))
<p class="text-muted">You have no orders yet.</p>
<a href="{{ route('catalog.products.index') }}" class="btn btn-primary">Start shopping</a>
@else
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order['order_number'] ?? $order['id'] }}</td>
                <td>{{ isset($order['order_date']) ? \Carbon\Carbon::parse($order['order_date'])->format('M j, Y') : '' }}</td>
                <td>{{ money_inr((float)($order['total_amount'] ?? 0)) }}</td>
                <td><span class="badge bg-secondary">{{ $order['order_status'] ?? '' }}</span></td>
                <td><a href="{{ route('orders.show', $order['id']) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
