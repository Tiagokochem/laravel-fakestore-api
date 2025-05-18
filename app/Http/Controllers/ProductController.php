<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FakeStoreService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected $fakeStoreService;

    public function __construct(FakeStoreService $fakeStoreService)
    {
        $this->fakeStoreService = $fakeStoreService;
    }

    public function index(): JsonResponse
    {
        $products = Product::all();

        if ($products->isNotEmpty()) {
            return response()->json($products);
        }

        $products = $this->fakeStoreService->getProducts();
        return response()->json($products);
    }

    public function show($id): JsonResponse
    {
        $product = $this->fakeStoreService->getProduct($id);
        return response()->json($product);
    }

    public function categories(): JsonResponse
    {
        $categories = $this->fakeStoreService->getCategories();
        return response()->json($categories);
    }
}
