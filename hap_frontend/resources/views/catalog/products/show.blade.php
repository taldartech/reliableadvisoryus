@extends('layouts.app')

@section('title', ($product['name'] ?? 'Product') . ' - ' . config('app.name'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalog.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">{{ $product['name'] ?? 'Product' }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-5 mb-3">
        @if(!empty($product['images'][0]['image_url']))
        <img src="{{ $product['images'][0]['image_url'] }}" class="img-fluid rounded" alt="{{ $product['name'] }}">
        @else
        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">No image</div>
        @endif
    </div>
    <div class="col-md-7">
        <h1>{{ $product['name'] ?? 'Product' }}</h1>
        <p class="fs-4 text-primary">${{ number_format($product['price'] ?? 0, 2) }}</p>
        @if(isset($product['stock']))
        <p class="text-muted">In stock: {{ $product['stock'] }}</p>
        @endif
        @if(!empty($product['short_description']))
        <p>{{ $product['short_description'] }}</p>
        @endif
        @if(!empty($product['description']))
        <div class="mb-3">{!! nl2br(e($product['description'])) !!}</div>
        @endif

        @if(session('hap_token'))
        <form method="POST" action="{{ route('cart.items.store') }}" class="row g-2 align-items-center">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <div class="col-auto">
                <label for="quantity" class="form-label mb-0">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product['stock'] ?? 999 }}" style="width: 80px;">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mt-4">Add to cart</button>
            </div>
        </form>
        @else
        <p><a href="{{ route('login') }}">Log in</a> to add to cart.</p>
        @endif
    </div>
</div>
@endsection
