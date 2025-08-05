<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase; // <-- Ensures a clean database for each test

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user with the 'admin' role
        $this->admin = User::factory()->create(['role' => 'admin']);

        // Create a regular user
        $this->user = User::factory()->create(['role' => 'user']);
    }

    // ... Our tests will go here ...

    #[Test]
    public function any_authenticated_user_can_get_a_list_of_products()
    {
        // Arrange: Create some products
        Product::factory(3)->create();

        // Act: Simulate a GET request as a regular user
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/api/v1/products');

        // Assert: Check for success and that we received 3 products
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    #[Test]
    public function an_admin_can_create_a_product()
    {
        // Act: Simulate a POST request as an admin
        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/v1/products', [
            'name' => 'New Gadget',
            'price' => 99.99,
            'quantity' => 50,
        ]);

        // Assert: Check for success and that the data exists in the database
        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('products', ['name' => 'New Gadget']);
    }

    #[Test]
    public function a_regular_user_cannot_create_a_product()
    {
        // Act: Simulate a POST request as a regular user
        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/v1/products', [
            'name' => 'New Gadget',
            'price' => 99.99,
            'quantity' => 50,
        ]);

        // Assert: Check for a 403 Forbidden error
        $response->assertStatus(403);
    }

    #[Test]
    public function creating_a_product_requires_a_name_price_and_quantity()
    {
        // Act: Send incomplete data
        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/v1/products', [
            'name' => '', // Invalid name
        ]);

        // Assert: Check for a 422 Unprocessable Entity and validation errors
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price', 'quantity']);
    }
}
