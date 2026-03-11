@extends('layouts.app')

@section('title', 'Sales Summary')

@section('content')
<h1 class="mb-4">Sales Summary</h1>
<form method="GET" class="row g-2 mb-3">
    <div class="col-auto"><input type="date" name="from_date" class="form-control" value="{{ $from_date }}"></div>
    <div class="col-auto"><input type="date" name="to_date" class="form-control" value="{{ $to_date }}"></div>
    <div class="col-auto"><button type="submit" class="btn btn-primary">Apply</button></div>
</form>
<p><strong>Online total:</strong> ₹{{ number_format($data['summary']['online_total'] ?? 0, 2) }} |
   <strong>POS total:</strong> ₹{{ number_format($data['summary']['pos_total'] ?? 0, 2) }} |
   <strong>Grand total:</strong> ₹{{ number_format($data['summary']['grand_total'] ?? 0, 2) }}</p>
@endsection
