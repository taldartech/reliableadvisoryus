@extends('layouts.app')

@section('title', 'Categories - ' . config('app.name'))

@section('content')
<h1 class="mb-4">Categories</h1>
@if(empty($categories))
<p class="text-muted">No categories found.</p>
@else
<ul class="list-group">
    @foreach($categories as $cat)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('catalog.categories.show', $cat['id']) }}">{{ $cat['name'] }}</a>
        <a href="{{ route('catalog.products.index', ['category_id' => $cat['id']]) }}" class="btn btn-outline-primary btn-sm">Products</a>
    </li>
    @if(!empty($cat['children']))
    <li class="list-group-item list-group-item-light">
        <ul class="list-unstyled ms-3 mb-0">
            @foreach($cat['children'] as $child)
            <li><a href="{{ route('catalog.categories.show', $child['id']) }}">{{ $child['name'] }}</a> — <a href="{{ route('catalog.products.index', ['category_id' => $child['id']]) }}">Products</a></li>
            @endforeach
        </ul>
    </li>
    @endif
    @endforeach
</ul>
@endif
@endsection
