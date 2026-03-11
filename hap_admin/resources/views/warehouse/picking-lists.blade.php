@extends('layouts.app')

@section('title', 'Picking Lists')

@section('content')
<h1 class="mb-4">Picking Lists</h1>
<ul class="list-group">
    @forelse($lists as $list)
    <li class="list-group-item">
        Order #{{ $list['order']['order_number'] ?? $list['order_id'] }} - {{ $list['location']['name'] ?? '' }} - {{ $list['status'] ?? '' }}
    </li>
    @empty
    <li class="list-group-item">No picking lists.</li>
    @endforelse
</ul>
<a href="{{ route('admin.warehouse.locations') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
