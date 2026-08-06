<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Cache::remember('products', 60, function () {
            return Product::all();
        });
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        Cache::forget('products');

        return Product::create($data);
    }

    public function update($product, array $data)
    {
        $product->update($data);

        Cache::forget('products');

        return $product;
    }

    public function delete($product)
    {
        Cache::forget('products');

        return $product->delete();
    }
}