<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, withFaker;
    /**
     * Test the get method of the ProductController.
     *
     * @return void
     */
    public function test_index_method_returns_all_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'productName',
                    'price',
                    'description',
                    'createdAt',
                    'updatedAt',
                ]
            ]
        ]);
    }

    /**
     * Test the store method of the ProductController.
     *
     * @return void
     */
    public function test_store_method_creates_new_product()
    {
        $product_data = [
            'productName' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];

        $response = $this->postJson('/api/v1/products', $product_data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'product_name' => $product_data['productName'],
            'description' => $product_data['description'],
            'price' => $product_data['price']
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'productName',
                'description',
                'price',
                'createdAt',
                'updatedAt',
            ]
        ]);
    }

        /**
     * Test the update method of the ProductController.
     *
     * @return void
     */
    public function test_update_method_updates_existing_product()
    {
        $product = Product::factory()->create();

        $updated_product_data = [
            'productName' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];

        $response = $this->putJson('/api/v1/products/' . $product->id, $updated_product_data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => $updated_product_data['productName'],
            'description' => $updated_product_data['description'],
            'price' => $updated_product_data['price'],
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'productName',
                'description',
                'price',
                'createdAt',
                'updatedAt',
            ]
        ]);
    }

    /**
     * Test the destroy method of the ProductController.
     *
     * @return void
     */
    public function test_destroy_method_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/v1/products/' . $product->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $response->assertJson([
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Test validation rules when storing a product.
     *
     * @return void
     */
    public function test_store_validation_rules()
    {
        // Missing all required fields
        $response = $this->postJson('/api/v1/products', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['productName', 'description', 'price']);

        // Invalid data type 
        $response = $this->postJson('/api/v1/products', [
            'productName' => '',
            'description' => '',
            'price' => 'not-a-number',
        ]);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['productName', 'description', 'price']);

        // Price with more than 3 decimals
        $response = $this->postJson('/api/v1/products', [
            'productName' => 'Test Product',
            'description' => 'A great product',
            'price' => 99.999,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['price']);
        
        // Valid data
        $response = $this->postJson('/api/v1/products', [
            'productName' => 'Valid Product',
            'description' => 'A valid description',
            'price' => 99.99,
        ]);
        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'productName',
                        'description',
                        'price',
                        'createdAt',
                        'updatedAt',
                    ]
                ]);
    }

    /**
     * Test validation rules when updating a product.
     *
     * @return void
     */
    public function test_update_validation_rules()
    {
        $product = Product::factory()->create();

        // Missing all required fields
        $response = $this->putJson('/api/v1/products/' . $product->id, []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['productName', 'description', 'price']);

        // Invalid data types
        $response = $this->putJson('/api/v1/products/' . $product->id, [
            'productName' => '',
            'description' => '',
            'price' => 'not-a-number',
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['productName', 'description', 'price']);

        // Price with more than two decimal places
        $response = $this->putJson('/api/v1/products/' . $product->id, [
            'productName' => 'Test Product',
            'description' => 'A great product',
            'price' => 99.999,
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['price']);

        // Valid data
        $response = $this->putJson('/api/v1/products/' . $product->id, [
            'productName' => 'Updated Product',
            'description' => 'An updated description',
            'price' => 99.99,
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'productName',
                        'description',
                        'price',
                        'createdAt',
                        'updatedAt',
                    ]
                ]);
    }
}
