@extends('layouts.app')

@section('title', 'Wishlist - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Wishlist</h1>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
@if(empty($items))
<p class="text-muted">Your wishlist is empty.</p>
<a href="{{ route('catalog.products.index') }}" class="btn btn-primary">Browse products</a>
@else
<ul class="list-group">
    @foreach($items as $item)
    @php $product = $item['product'] ?? []; @endphp
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('catalog.products.show', $product['id'] ?? 0) }}">{{ $product['name'] ?? 'Product' }}</a>
            <span class="text-muted ms-2">{{ money_inr($product['price'] ?? 0) }}</span>
        </div>
        <form method="POST" action="{{ route('wishlist.remove', $product['id'] ?? 0) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
        </form>
    </li>
    @endforeach
</ul>
@endif
@endsection
