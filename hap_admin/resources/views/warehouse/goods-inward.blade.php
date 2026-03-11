@extends('layouts.app')

@section('title', 'Goods Inward')

@section('content')
<h1 class="mb-4">Goods Inward</h1>
<form method="POST" class="row g-3">
    @csrf
    <div class="col-md-4">
        <label class="form-label">Location</label>
        <select name="location_id" class="form-select" required>
            @foreach($locations as $loc)
            <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Product ID</label>
        <input type="number" name="product_id" class="form-control" required min="1">
    </div>
    <div class="col-md-4">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" required min="1">
    </div>
    <div class="col-12">
        <label class="form-label">Reference (optional)</label>
        <input type="text" name="reference" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Notes (optional)</label>
        <input type="text" name="notes" class="form-control">
    </div>
    <div class="col-12"><button type="submit" class="btn btn-primary">Record inward</button></div>
</form>
<a href="{{ route('admin.warehouse.locations') }}" class="btn btn-secondary mt-3">Back to locations</a>
@endsection
