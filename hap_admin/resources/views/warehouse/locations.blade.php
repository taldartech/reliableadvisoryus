@extends('layouts.app')

@section('title', 'Warehouse Locations')

@section('content')
<h1 class="mb-4">Locations</h1>
<ul class="list-group">
    @forelse($locations as $loc)
    <li class="list-group-item">{{ $loc['name'] ?? '' }} ({{ $loc['type'] ?? '' }}) - {{ ($loc['is_active'] ?? true) ? 'Active' : 'Inactive' }}</li>
    @empty
    <li class="list-group-item">No locations.</li>
    @endforelse
</ul>
<a href="{{ route('admin.warehouse.goods-inward') }}" class="btn btn-primary mt-3">Goods inward</a>
<a href="{{ route('admin.warehouse.picking-lists') }}" class="btn btn-outline-primary mt-3">Picking lists</a>
@endsection
