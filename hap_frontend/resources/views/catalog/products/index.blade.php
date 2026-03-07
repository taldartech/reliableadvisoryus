@extends('layouts.app')

@section('title', 'Products - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Products</h1>

<form method="GET" action="{{ route('catalog.products.index') }}" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
    </div>
    <div class="col-auto">
        <input type="number" name="min_price" class="form-control" placeholder="Min price" value="{{ request('min_price') }}" step="0.01">
    </div>
    <div class="col-auto">
        <input type="number" name="max_price" class="form-control" placeholder="Max price" value="{{ request('max_price') }}" step="0.01">
    </div>
    @if(request('category_id'))
    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
    @endif
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Filter</button>
    </div>
</form>

@if(empty($products))
<p class="text-muted">No products found.</p>
@else
<div class="row g-3">
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

@if(!empty($meta) && ($meta['last_page'] ?? 1) > 1)
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        @for($p = 1; $p <= ($meta['last_page'] ?? 1); $p++)
        <li class="page-item {{ ($meta['current_page'] ?? 1) == $p ? 'active' : '' }}">
            <a class="page-link" href="{{ route('catalog.products.index', array_merge(request()->query(), ['page' => $p])) }}">{{ $p }}</a>
        </li>
        @endfor
    </ul>
</nav>
@endif
@endif
@endsection
