@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<h1 class="mb-4">Online Orders</h1>
<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="order_status" class="form-select form-select-sm">
            <option value="">All statuses</option>
            <option value="pending_payment" {{ request('order_status') == 'pending_payment' ? 'selected' : '' }}>Pending payment</option>
            <option value="confirmed" {{ request('order_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="packed" {{ request('order_status') == 'packed' ? 'selected' : '' }}>Packed</option>
            <option value="shipped" {{ request('order_status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    <div class="col-auto"><input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" placeholder="From"></div>
    <div class="col-auto"><input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" placeholder="To"></div>
    <div class="col-auto"><button type="submit" class="btn btn-sm btn-primary">Filter</button></div>
</form>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($orders as $o)
            <tr>
                <td>{{ $o['order_number'] ?? $o['id'] }}</td>
                <td>{{ isset($o['order_date']) ? \Carbon\Carbon::parse($o['order_date'])->format('M j, Y') : '' }}</td>
                <td>₹{{ number_format((float)($o['total_amount'] ?? 0), 2) }}</td>
                <td><span class="badge bg-secondary">{{ $o['order_status'] ?? '' }}</span></td>
                <td><a href="{{ route('admin.orders.show', $o['id']) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
            @empty
            <tr><td colspan="5">No orders.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
