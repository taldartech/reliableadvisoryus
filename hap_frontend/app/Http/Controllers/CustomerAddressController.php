<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerAddressController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View|RedirectResponse
    {
        try {
            $response = $this->api->get('customer/addresses');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('customer.profile')->with('error', $e->response?->json()['message'] ?? 'Could not load addresses.');
        }
        $addresses = $response['data'] ?? [];
        return view('customer.addresses.index', ['addresses' => is_array($addresses) ? $addresses : []]);
    }

    public function create(): View
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ]);
        $data = $request->only(['address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country']);
        $data['is_default'] = $request->boolean('is_default');
        try {
            $this->api->post('customer/addresses', $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->withInput()->with('error', $body['message'] ?? 'Could not create address.');
        }
        return redirect()->route('customer.addresses.index')->with('success', 'Address created.');
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $response = $this->api->get('customer/addresses');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('customer.addresses.index')->with('error', 'Could not load addresses.');
        }
        $addresses = $response['data'] ?? [];
        $address = collect($addresses)->firstWhere('id', $id);
        if (! $address) {
            return redirect()->route('customer.addresses.index')->with('error', 'Address not found.');
        }
        return view('customer.addresses.edit', ['address' => $address]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'is_default' => ['nullable', 'boolean'],
        ]);
        $data = $request->only(['address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country']);
        $data['is_default'] = $request->boolean('is_default');
        try {
            $this->api->put("customer/addresses/{$id}", $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $body = $e->response?->json();
            return back()->withInput()->with('error', $body['message'] ?? 'Could not update address.');
        }
        return redirect()->route('customer.addresses.index')->with('success', 'Address updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->api->delete("customer/addresses/{$id}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Could not delete address.');
        }
        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted.');
    }
}
