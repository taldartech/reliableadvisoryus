<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $response = $this->api->post('auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $status = $e->response?->status();
            $body = $e->response?->json();
            $message = $body['message'] ?? 'Invalid credentials.';
            return back()->withInput($request->only('email'))->with('error', $message);
        }

        session([
            'hap_token' => $response['token'],
            'hap_user' => $response['user'] ?? null,
        ]);

        return redirect()->intended(route('home'))->with('success', 'Logged in successfully.');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        try {
            $response = $this->api->post('auth/register', [
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            $message = $body['message'] ?? 'Registration failed.';
            $errors = $body['errors'] ?? [];
            if (! empty($errors)) {
                return back()->withInput($request->except('password', 'password_confirmation'))->withErrors($errors)->with('error', $message);
            }
            return back()->withInput($request->except('password', 'password_confirmation'))->with('error', $message);
        }

        session([
            'hap_token' => $response['token'],
            'hap_user' => $response['user'] ?? null,
        ]);

        return redirect()->route('home')->with('success', 'Registered successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->api->post('auth/logout');
        } catch (\Throwable) {
            // ignore
        }
        $request->session()->forget(['hap_token', 'hap_user']);
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
