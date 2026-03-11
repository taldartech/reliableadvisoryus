<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">HAP Admin</a>
            <div class="d-flex">
                <a class="nav-link text-white me-3" href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="nav-link text-white me-3" href="{{ route('admin.customers.index') }}">Customers</a>
                <a class="nav-link text-white me-3" href="{{ route('admin.reports.sales-summary') }}">Reports</a>
                <a class="nav-link text-white me-3" href="{{ route('admin.reports.inventory-summary') }}">Inventory</a>
                <a class="nav-link text-white me-3" href="{{ route('admin.pos.eod-summary') }}">POS EOD</a>
                <a class="nav-link text-white me-3" href="{{ route('admin.warehouse.locations') }}">Warehouse</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container py-4">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
