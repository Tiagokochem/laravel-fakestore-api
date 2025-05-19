<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FakeStoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function store(Request $request): JsonResponse
    {
        $product = Product::create($request->all());
        return response()->json(['message' => 'Product created successfully.', 'product' => $product]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated successfully.', 'product' => $product]);
    }

    public function destroy($id): JsonResponse
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
