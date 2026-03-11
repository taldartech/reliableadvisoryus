@extends('layouts.app')

@section('title', 'Inventory Summary')

@section('content')
<h1 class="mb-4">Inventory Summary</h1>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead><tr><th>Product</th><th>Stock</th><th>Price</th></tr></thead>
        <tbody>
            @forelse($data as $p)
            <tr>
                <td>{{ $p['name'] ?? '' }}</td>
                <td>{{ $p['stock'] ?? 0 }}</td>
                <td>₹{{ number_format((float)($p['price'] ?? 0), 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="3">No data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
