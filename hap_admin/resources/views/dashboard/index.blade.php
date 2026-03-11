@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="mb-4">Dashboard</h1>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sales (this month)</h5>
                <p class="mb-0">Online: ₹{{ number_format($sales_summary['summary']['online_total'] ?? 0, 2) }}</p>
                <p class="mb-0">POS: ₹{{ number_format($sales_summary['summary']['pos_total'] ?? 0, 2) }}</p>
                <p class="fw-bold mb-0">Total: ₹{{ number_format($sales_summary['summary']['grand_total'] ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Order status</h5>
                @foreach(($order_status['by_status'] ?? []) as $status => $count)
                <p class="mb-0 small">{{ $status }}: {{ $count }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
<p><a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View all orders</a>
   <a href="{{ route('admin.reports.sales-summary') }}" class="btn btn-outline-primary">Sales report</a></p>
@endsection
