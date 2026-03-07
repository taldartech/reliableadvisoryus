@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<h1 class="mb-4">Welcome to {{ config('app.name') }}</h1>

@if(!empty($products))
<h2 class="h5 mb-3">Featured Products</h2>
<div class="row g-3 mb-4">
    @foreach($products as $product)
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100">
            @if(!empty($product['images'][0]['image_url']))
            <img src="{{ $product['images'][0]['image_url'] }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 160px; object-fit: cover;">
            @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">No image</div>
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text text-muted mb-2">${{ number_format($product['price'] ?? 0, 2) }}</p>
                <a href="{{ route('catalog.products.show', $product['id']) }}" class="btn btn-primary btn-sm mt-auto">View</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if(!empty($categories))
<h2 class="h5 mb-3">Categories</h2>
<ul class="list-group">
    @foreach($categories as $cat)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('catalog.categories.show', $cat['id']) }}">{{ $cat['name'] }}</a>
        <a href="{{ route('catalog.products.index', ['category_id' => $cat['id']]) }}" class="btn btn-outline-primary btn-sm">Products</a>
    </li>
    @endforeach
</ul>
@endif

@if(empty($products) && empty($categories))
<p class="text-muted">No products or categories yet. Make sure the backend API is running at <code>{{ config('hap.api_url') }}</code>.</p>
@endif
@endsection
