<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class SyncProducts extends Command
{
    protected $signature = 'sync:products';
    protected $description = 'Sync products from the external FakeStore API';

    public function handle()
    {
        $this->info('Syncing products from API...');
        
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->failed()) {
            $this->error('Failed to fetch products from API.');
            return;
        }

        $products = $response->json();

        foreach ($products as $apiProduct) {
            $category = $apiProduct['category'] ?? 'Uncategorized';

            $product = Product::firstOrNew(['api_id' => $apiProduct['id']]);
            $product->title = $apiProduct['title'];
            $product->description = $apiProduct['description'];
            $product->price = $apiProduct['price'];
            $product->image = $apiProduct['image'];
            $product->category = $category;
            $product->save();
        }

        $this->info('Products synchronized successfully.');
    }
}
