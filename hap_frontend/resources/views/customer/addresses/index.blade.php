@extends('layouts.app')

@section('title', 'Addresses - ' . config('app.name'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('customer.profile') }}">Profile</a></li>
        <li class="breadcrumb-item active">Addresses</li>
    </ol>
</nav>
<h1 class="mb-4">My Addresses</h1>
<a href="{{ route('customer.addresses.create') }}" class="btn btn-primary mb-3">Add address</a>

@if(empty($addresses))
<p class="text-muted">No addresses yet. Add one for checkout.</p>
@else
<ul class="list-group">
    @foreach($addresses as $addr)
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div>
            <strong>{{ $addr['address_line_1'] }}</strong>@if(!empty($addr['address_line_2'])) {{ $addr['address_line_2'] }}@endif<br>
            {{ $addr['city'] }}@if(!empty($addr['state'])), {{ $addr['state'] }}@endif {{ $addr['postal_code'] }}<br>
            {{ $addr['country'] }}
            @if(!empty($addr['is_default']))<span class="badge bg-primary">Default</span>@endif
        </div>
        <div>
            <a href="{{ route('customer.addresses.edit', $addr['id']) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form method="POST" action="{{ route('customer.addresses.destroy', $addr['id']) }}" class="d-inline" onsubmit="return confirm('Delete this address?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        </div>
    </li>
    @endforeach
</ul>
@endif
@endsection
