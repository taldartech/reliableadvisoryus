@extends('layouts.app')

@section('title', 'Order Status Report')

@section('content')
<h1 class="mb-4">Order Status Report</h1>
<form method="GET" class="mb-3">
    <input type="date" name="from_date" value="{{ $from_date }}">
    <input type="date" name="to_date" value="{{ $to_date }}">
    <button type="submit" class="btn btn-primary">Apply</button>
</form>
<ul class="list-group">
    @foreach($data['by_status'] ?? [] as $status => $count)
    <li class="list-group-item d-flex justify-content-between">{{ $status }} <span>{{ $count }}</span></li>
    @endforeach
</ul>
@endsection
