<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Services\HapApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(Request $request): View
    {
        $query = array_filter([
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'search' => $request->get('search'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'per_page' => min((int) $request->get('per_page', 15), 50),
            'page' => $request->get('page'),
        ]);
        $response = $this->api->get('catalog/products', $query);
        $products = $response['data'] ?? [];
        $meta = $response['meta'] ?? [];
        $links = $response['links'] ?? [];
        return view('catalog.products.index', [
            'products' => is_array($products) ? $products : [],
            'meta' => $meta,
            'links' => $links,
        ]);
    }

    public function show(int $id): View
    {
        $response = $this->api->get("catalog/products/{$id}");
        $product = $response['data'] ?? $response;
        return view('catalog.products.show', ['product' => $product]);
    }
}
