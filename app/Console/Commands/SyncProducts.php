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
            Product::updateOrCreate(
                ['api_id' => $apiProduct['id']],
                [
                    'title' => $apiProduct['title'],
                    'description' => $apiProduct['description'],
                    'price' => $apiProduct['price'],
                    'image' => $apiProduct['image'],
                ]
            );
        }

        $this->info('Products synchronized successfully.');
    }
}
