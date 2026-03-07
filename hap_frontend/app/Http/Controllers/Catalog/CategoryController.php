<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Services\HapApiService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected HapApiService $api
    ) {}

    public function index(): View
    {
        $response = $this->api->get('catalog/categories');
        $categories = $response['data'] ?? $response;
        return view('catalog.categories.index', ['categories' => is_array($categories) ? $categories : []]);
    }

    public function show(int $id): View
    {
        $response = $this->api->get("catalog/categories/{$id}");
        $category = $response['data'] ?? $response;
        return view('catalog.categories.show', ['category' => $category]);
    }
}
