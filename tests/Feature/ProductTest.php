<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper Method
     */
    private function authenticate()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        return $user;
    }

    /**
     * Get All Products
     */
    public function test_get_products()
    {
        $this->authenticate();

        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
    }

    /**
     * Create Product
     */
    public function test_create_product()
    {
        $this->authenticate();

        $data = [
            'name' => 'iPhone 16',
            'description' => 'Apple Mobile',
            'price' => 120000,
        ];

        $response = $this->postJson('/api/v1/products', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'iPhone 16'
        ]);
    }

    /**
     * Show Single Product
     */
    public function test_show_product()
    {
        $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200);
    }

    /**
     * Update Product
     */
    public function test_update_product()
    {
        $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->putJson("/api/v1/products/{$product->id}", [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 9999
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Updated Product'
        ]);
    }

    /**
     * Delete Product
     */
    public function test_delete_product()
    {
        $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }

    /**
     * Validation Test
     */
    public function test_product_validation()
    {
        $this->authenticate();

        $response = $this->postJson('/api/v1/products', [
            'name' => '',
            'price' => ''
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'price'
        ]);
    }

    /**
     * Unauthorized User
     */
    public function test_guest_cannot_access_products()
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(401);
    }
}