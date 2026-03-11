<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View|RedirectResponse
    {
        try {
            $response = $this->api->get('wishlist');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return redirect()->route('home')->with('error', $e->response?->json()['message'] ?? 'Could not load wishlist.');
        }
        $items = $response['data'] ?? [];
        return view('wishlist.index', ['items' => is_array($items) ? $items : []]);
    }

    public function add(int $id): RedirectResponse
    {
        try {
            $this->api->post("wishlist/{$id}", []);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Could not add to wishlist.');
        }
        return back()->with('success', 'Added to wishlist.');
    }

    public function remove(int $id): RedirectResponse
    {
        try {
            $this->api->delete("wishlist/{$id}");
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return back()->with('error', $e->response?->json()['message'] ?? 'Could not remove from wishlist.');
        }
        return back()->with('success', 'Removed from wishlist.');
    }
}
