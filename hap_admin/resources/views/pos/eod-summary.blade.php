@extends('layouts.app')

@section('title', 'POS EOD Summary')

@section('content')
<h1 class="mb-4">POS End of Day Summary</h1>
<form method="GET" class="mb-3">
    <input type="date" name="date" value="{{ $date }}" class="form-control d-inline-block w-auto">
    <button type="submit" class="btn btn-primary">Apply</button>
</form>
<p><strong>Date:</strong> {{ $date }}</p>
<p><strong>Total sales:</strong> ₹{{ number_format($data['total_sales'] ?? 0, 2) }}</p>
<p><strong>Transaction count:</strong> {{ $data['transaction_count'] ?? 0 }}</p>
@if(!empty($data['by_location']))
<h2 class="h6 mt-3">By location</h2>
<ul class="list-group">
    @foreach($data['by_location'] as $loc)
    <li class="list-group-item d-flex justify-content-between">{{ $loc['location_name'] ?? '' }} <span>₹{{ number_format($loc['total_amount'] ?? 0, 2) }} ({{ $loc['count'] ?? 0 }})</span></li>
    @endforeach
</ul>
@endif
@endsection
