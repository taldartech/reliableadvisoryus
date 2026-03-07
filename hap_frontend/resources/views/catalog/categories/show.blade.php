@extends('layouts.app')

@section('title', ($category['name'] ?? 'Category') . ' - ' . config('app.name'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalog.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">{{ $category['name'] ?? 'Category' }}</li>
    </ol>
</nav>
<h1 class="mb-4">{{ $category['name'] ?? 'Category' }}</h1>
<a href="{{ route('catalog.products.index', ['category_id' => $category['id'] ?? null]) }}" class="btn btn-primary mb-3">View products</a>
@if(!empty($category['children']))
<h2 class="h6">Subcategories</h2>
<ul class="list-group">
    @foreach($category['children'] as $child)
    <li class="list-group-item"><a href="{{ route('catalog.categories.show', $child['id']) }}">{{ $child['name'] }}</a></li>
    @endforeach
</ul>
@endif
@endsection
