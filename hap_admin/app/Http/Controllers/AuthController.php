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
            $body = $e->response?->json();
            return back()->withInput($request->only('email'))->with('error', $body['message'] ?? 'Invalid credentials.');
        }

        $user = $response['user'] ?? null;
        $roles = $user['roles'] ?? [];
        $adminRoles = ['Super Admin', 'Admin', 'Store Manager', 'Ecommerce Admin'];

        if (empty(array_intersect($roles, $adminRoles))) {
            return back()->with('error', 'You do not have admin access.');
        }

        session([
            'hap_token' => $response['token'],
            'hap_user' => $user,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Logged in.');
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->api->post('auth/logout');
        } catch (\Throwable) {
            // ignore
        }
        $request->session()->forget(['hap_token', 'hap_user']);
        return redirect()->route('admin.login')->with('success', 'Logged out.');
    }
}
