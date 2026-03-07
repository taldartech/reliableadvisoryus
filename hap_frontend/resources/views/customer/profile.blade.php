@extends('layouts.app')

@section('title', 'Profile - ' . config('app.name'))

@section('content')
<h1 class="mb-4">My Profile</h1>

<form method="POST" action="{{ route('customer.profile.update') }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer['name'] ?? '') }}">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer['email'] ?? '') }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer['phone'] ?? '') }}">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary">Update profile</button>
</form>

<hr class="my-4">
<h2 class="h5 mb-3">Addresses</h2>
<a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-primary">Manage addresses</a>
@endsection
