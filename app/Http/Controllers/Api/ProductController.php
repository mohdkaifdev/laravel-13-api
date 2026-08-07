<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;
    /*
     *
     * Display a listing of the resource.
     */

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();

        return $this->success([
            ProductResource::collection($products),
            'Products fetched successfully.',
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        return $this->success(
            new ProductResource($product),
            'Product created successfully.',
            201
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $product = $this->productService->getProduct($product->id);

        return $this->success(
            new ProductResource($product),
            'Product fetched successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->updateProduct(
            $product,
            $request->validated()
        );

        return $this->success(
            new ProductResource($product->fresh()),
            'Product updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(Product $product)
    {
        $this->productService->deleteProduct($product);

        return $this->success(
            null,
            'Product deleted successfully.'
        );
    }
}
