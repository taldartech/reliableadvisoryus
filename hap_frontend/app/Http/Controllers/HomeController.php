<?php

namespace App\Http\Controllers;

use App\Services\HapApiService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View
    {
        $categories = [];
        $products = [];
        try {
            $categories = $this->api->get('catalog/categories');
            $productsResponse = $this->api->get('catalog/products', ['per_page' => 8]);
            $products = $productsResponse['data'] ?? [];
        } catch (\Throwable) {
            // ignore API errors on home
        }
        return view('home', [
            'categories' => $categories['data'] ?? $categories,
            'products' => is_array($products) ? $products : [],
        ]);
    }
}
