@extends('layouts.app')

@section('title', 'Customer')

@section('content')
<h1 class="mb-4">{{ $customer['name'] ?? 'Customer' }}</h1>
<p>Email: {{ $customer['email'] ?? '' }} | Phone: {{ $customer['phone'] ?? '' }}</p>
<h2 class="h6 mt-4">Orders</h2>
<ul class="list-group">
    @foreach($customer['orders'] ?? [] as $o)
    <li class="list-group-item d-flex justify-content-between">
        <a href="{{ route('admin.orders.show', $o['id']) }}">{{ $o['order_number'] ?? $o['id'] }}</a>
        <span>₹{{ number_format((float)($o['total_amount'] ?? 0), 2) }} - {{ $o['order_status'] ?? '' }}</span>
    </li>
    @endforeach
</ul>
<a href="{{ route('admin.customers.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
