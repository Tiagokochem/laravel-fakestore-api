<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FakeStoreService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('FAKESTORE_API_URL');
    }

    public function getProducts()
    {
        return Http::get("{$this->apiUrl}/products")->json();
    }

    public function getProduct($id)
    {
        return Http::get("{$this->apiUrl}/products/{$id}")->json();
    }

    public function getCategories()
    {
        return Http::get("{$this->apiUrl}/products/categories")->json();
    }
}
