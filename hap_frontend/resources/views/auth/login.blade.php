@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="mb-4">Login</h2>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <form method="POST" action="{{ route('login') }}" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login with password</button>
            <a href="{{ route('register') }}" class="btn btn-link">Register instead</a>
        </form>

        <hr>
        <h3 class="h6 mb-2">Or login with OTP</h3>
        @if(session('otp_sent'))
        <form method="POST" action="{{ route('login.verify-otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ old('email') }}">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter 6-digit OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required>
            </div>
            <button type="submit" class="btn btn-outline-primary">Verify OTP</button>
        </form>
        @else
        <form method="POST" action="{{ route('login.send-otp') }}">
            @csrf
            <div class="mb-3">
                <label for="otp_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="otp_email" name="email" value="{{ old('email') }}" required>
            </div>
            <button type="submit" class="btn btn-outline-primary">Send OTP</button>
        </form>
        @endif
    </div>
</div>
@endsection
