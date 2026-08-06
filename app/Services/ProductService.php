<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function getProduct($id)
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data)
    {
        return DB::transaction(function () use ($data) {

            if(isset($data['image'])){

                $data['image']=$data['image']->store(
                    'products',
                    'public'
                );

            }

            return $this->productRepository->create($data);

        });
    }

    public function updateProduct($product,array $data)
    {
        return DB::transaction(function() use($product,$data){

            if(isset($data['image'])){

                if($product->image){

                    Storage::disk('public')->delete($product->image);

                }

                $data['image']=$data['image']->store(
                    'products',
                    'public'
                );

            }

            return $this->productRepository->update(
                $product,
                $data
            );

        });
    }

    public function deleteProduct($product)
    {
        return DB::transaction(function() use($product){

            if($product->image){

                Storage::disk('public')->delete($product->image);

            }

            return $this->productRepository->delete($product);

        });
    }
}