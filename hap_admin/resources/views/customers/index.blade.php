@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<h1 class="mb-4">Customers</h1>
<form method="GET" class="mb-3">
    <input type="text" name="search" class="form-control d-inline-block w-auto" placeholder="Search name, email, phone" value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
</form>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th></th></tr></thead>
        <tbody>
            @forelse($customers as $c)
            <tr>
                <td>{{ $c['name'] ?? '' }}</td>
                <td>{{ $c['email'] ?? '' }}</td>
                <td>{{ $c['phone'] ?? '' }}</td>
                <td>{{ $c['orders_count'] ?? 0 }}</td>
                <td><a href="{{ route('admin.customers.show', $c['id']) }}" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
            @empty
            <tr><td colspan="5">No customers.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
