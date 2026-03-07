@extends('layouts.app')

@section('title', 'Edit address - ' . config('app.name'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('customer.profile') }}">Profile</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.addresses.index') }}">Addresses</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
<h1 class="mb-4">Edit address</h1>
<form method="POST" action="{{ route('customer.addresses.update', $address['id']) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="address_line_1" class="form-label">Address line 1 *</label>
        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $address['address_line_1'] ?? '') }}" required>
        @error('address_line_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="address_line_2" class="form-label">Address line 2</label>
        <input type="text" class="form-control" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $address['address_line_2'] ?? '') }}">
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="city" class="form-label">City *</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $address['city'] ?? '') }}" required>
            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $address['state'] ?? '') }}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="postal_code" class="form-label">Postal code *</label>
            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $address['postal_code'] ?? '') }}" required>
            @error('postal_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="country" class="form-label">Country *</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $address['country'] ?? '') }}" required>
            @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1" {{ old('is_default', $address['is_default'] ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_default">Set as default address</label>
    </div>
    <button type="submit" class="btn btn-primary">Update address</button>
    <a href="{{ route('customer.addresses.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
