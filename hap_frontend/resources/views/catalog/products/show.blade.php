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
        @php $images = $product['images'] ?? []; @endphp
        @if(count($images) > 0)
        <div id="productGallery" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
                @foreach($images as $i => $img)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <img src="{{ $img['image_url'] ?? '' }}" class="d-block w-100 img-fluid rounded" alt="{{ $product['name'] }}">
                </div>
                @endforeach
            </div>
            @if(count($images) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
            @endif
        </div>
        @else
        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">No image</div>
        @endif
    </div>
    <div class="col-md-7">
        <h1>{{ $product['name'] ?? 'Product' }}</h1>
        <p class="fs-4 text-primary">{{ money_inr($product['price'] ?? 0) }}</p>
        @if(isset($product['gst_slab']))
        <span class="badge bg-secondary">GST {{ $product['gst_slab'] }}%</span>
        @endif
        @if(isset($product['stock']))
        <p class="text-muted">In stock: {{ $product['stock'] }}</p>
        @endif
        @if(!empty($product['short_description']))
        <p>{{ $product['short_description'] }}</p>
        @endif
        @if(!empty($product['specifications']) && count($product['specifications']) > 0)
        <dl class="row mb-3">
            @foreach($product['specifications'] as $spec)
            <dt class="col-sm-4">{{ $spec['specification_name'] ?? '' }}</dt>
            <dd class="col-sm-8">{{ $spec['specification_value'] ?? '' }}</dd>
            @endforeach
        </dl>
        @endif
        @if(!empty($product['variant_details']) && count($product['variant_details']) > 0)
        <p class="text-muted small">Variants: @foreach($product['variant_details'] as $vd) {{ $vd['variant_type'] ?? '' }} ({{ collect($vd['items'] ?? [])->pluck('option_value')->join(', ') }}) @endforeach</p>
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
            <div class="col-auto mt-4">
                <form action="{{ route('wishlist.add', $product['id']) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Add to wishlist</button>
                </form>
            </div>
        </form>
        @else
        <p><a href="{{ route('login') }}">Log in</a> to add to cart.</p>
        @endif
    </div>
</div>
@endsection
