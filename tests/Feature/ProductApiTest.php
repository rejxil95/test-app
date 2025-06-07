<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;

class ProductApiTest extends TestCase
{
    // Note: RefreshDatabase is commented out since I am using my actual DB
    // It would normally reset the DB using migrations for isolated testing
    // use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Manually truncate the products table before each test
        // to ensure a clean state using your live database.
        Product::truncate();
    }

    /** @test */
    public function it_can_list_all_products()
    {
        // Create 3 fake products using the Product factory
        Product::factory()->count(3)->create();

        // Send a GET request to the product listing API
        $response = $this->getJson('/api/products');

        // Assert that the response status is 200 OK
        // and that the "data" array contains exactly 3 products
        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_create_a_product()
    {
        // Prepare a product payload to send in the request
        $data = [
            'name' => 'Test Product',
            'price' => 49.99,
            'stock' => 100,
            'description' => 'A new product',
        ];

        // Send a POST request to create a new product
        $response = $this->postJson('/api/products', $data);

        // Assert that the response status is 201 Created
        // and the JSON response contains expected fragments
        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Test Product',
                     'price' => 49.99,
                     'stock' => 100,
                 ]);

        // Assert that the product now exists in the database
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_can_show_a_single_product()
    {
        // Create a single product to view
        $product = Product::factory()->create();

        // Send a GET request to fetch that product
        $response = $this->getJson("/api/products/{$product->id}");

        // Assert that the response is OK and includes the product's ID
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $product->id]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        // Create a product to update
        $product = Product::factory()->create();

        // Define the updated values
        $updateData = [
            'name' => 'Updated Name',
            'price' => 59.99,
            'stock' => 80,
            'description' => 'Updated desc',
        ];

        // Send a PUT request to update the product
        $response = $this->putJson("/api/products/{$product->id}", $updateData);

        // Assert that the response is OK and includes updated name
        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        // Verify the update is reflected in the database
        $this->assertDatabaseHas('products', ['name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        // Create a product to delete
        $product = Product::factory()->create();

        // Send a DELETE request for that product
        $response = $this->deleteJson("/api/products/{$product->id}");

        // Assert that the response is OK and confirms deletion
        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Product deleted successfully.']);

        // Check that the product no longer exists in the DB
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
