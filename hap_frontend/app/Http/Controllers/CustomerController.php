<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function profile(): View|RedirectResponse
    {
        try {
            $response = $this->api->get('customer/profile');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('home')->with('error', $e->response?->json()['message'] ?? 'Could not load profile.');
        }
        $customer = $response['data'] ?? $response;
        return view('customer.profile', ['customer' => $customer]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);
        $data = $request->only(['name', 'email', 'phone']);
        $data = array_filter($data, fn ($v) => $v !== null && $v !== '');
        try {
            $this->api->put('customer/profile', $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->with('error', $body['message'] ?? 'Could not update profile.');
        }
        return redirect()->route('customer.profile')->with('success', 'Profile updated.');
    }
}
