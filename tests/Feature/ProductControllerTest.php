<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic user instance for authentication.
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Create a user that can be used for authentication in tests
        $this->user = User::factory()->create();
    }

    //================================================================
    // INDEX METHOD TESTS
    //================================================================

    #[Test]
    public function it_displays_the_products_index_page()
    {
        // Arrange: Create a product to ensure the list is not empty
        Product::factory()->create(['name' => 'Test Product']);

        // Act: Make a GET request to the index route as an authenticated user
        $response = $this->actingAs($this->user)->get(route('products.index'));

        // Assert: Check for a successful response and correct view
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
        $response->assertSee('Test Product');
    }

    #[Test]
    public function it_sorts_products_by_name_ascending_by_default()
    {
        // Arrange: Create products in a specific order
        Product::factory()->create(['name' => 'Banana']);
        Product::factory()->create(['name' => 'Apple']);
        Product::factory()->create(['name' => 'Cherry']);

        // Act: Access the index page as an authenticated user
        $response = $this->actingAs($this->user)->get(route('products.index'));

        // Assert: Check that the products are seen in the correct sorted order
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Apple', 'Banana', 'Cherry']);
    }

    #[Test]
    public function it_can_sort_products_by_price_descending()
    {
        // Arrange: Create products with different prices
        Product::factory()->create(['name' => 'Cheap', 'price' => 10]);
        Product::factory()->create(['name' => 'Expensive', 'price' => 100]);
        Product::factory()->create(['name' => 'Mid-range', 'price' => 50]);

        // Act: Access the index page as an authenticated user
        $response = $this->actingAs($this->user)->get(route('products.index', ['sort_by' => 'price', 'sort_direction' => 'desc']));

        // Assert: Check that the products are seen in the correct sorted order
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Expensive', 'Mid-range', 'Cheap']);
    }

    #[Test]
    public function it_defaults_to_sorting_by_name_if_invalid_column_is_provided()
    {
        // Arrange
        Product::factory()->create(['name' => 'Banana']);
        Product::factory()->create(['name' => 'Apple']);

        // Act: Try to sort by a non-existent column as an authenticated user
        $response = $this->actingAs($this->user)->get(route('products.index', ['sort_by' => 'invalid_column']));

        // Assert: The controller should fall back to sorting by name ascending
        $response->assertStatus(200);
        $response->assertSeeInOrder(['Apple', 'Banana']);
    }


    //================================================================
    // STORE METHOD TESTS
    //================================================================

    #[Test]
    public function it_can_store_a_new_product()
    {
        // Arrange: Prepare the product data
        $productData = [
            'name' => 'New Awesome Gadget',
            'price' => 199.99,
            'quantity' => 25,
        ];

        // Act: Make a POST request to the store route with the data
        $response = $this->actingAs($this->user)->post(route('products.store'), $productData);

        // Assert: Check that the product exists in the database
        $this->assertDatabaseHas('products', ['name' => 'New Awesome Gadget']);
        // Assert that the user is redirected back to the index page
        $response->assertRedirect(route('products.index'));
    }

    #[Test]
    public function it_fails_to_store_a_product_with_invalid_data()
    {
        // Arrange: Prepare invalid data (missing name)
        $invalidData = [
            'price' => 99,
            'quantity' => 10,
        ];

        // Act: Make a POST request
        $response = $this->actingAs($this->user)->post(route('products.store'), $invalidData);

        // Assert: Check for a validation error redirect and that the 'name' field has an error
        $response->assertSessionHasErrors('name');
        // Assert that no product was created
        $this->assertDatabaseCount('products', 0);
    }


    //================================================================
    // UPDATE METHOD TESTS
    //================================================================

    #[Test]
    public function it_can_update_an_existing_product()
    {
        // Arrange: Create a product to be updated
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product Name',
            'price' => 123.45,
            'quantity' => 5,
        ];

        // Act: Make a PUT request to the update route
        $response = $this->actingAs($this->user)->put(route('products.update', $product->id), $updatedData);

        // Assert: Check that the database was updated correctly
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name'
        ]);
        $response->assertRedirect(route('products.index'));
    }


    //================================================================
    // DESTROY METHOD TESTS
    //================================================================

    #[Test]
    public function it_can_delete_a_product()
    {
        // Arrange: Create a product to be deleted
        $product = Product::factory()->create();
        $this->assertDatabaseHas('products', ['id' => $product->id]);

        // Act: Make a DELETE request to the destroy route
        $response = $this->actingAs($this->user)->delete(route('products.destroy', $product->id));

        // Assert: Check that the product is no longer in the database
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $response->assertRedirect(route('products.index'));
    }


    //================================================================
    // PURCHASE METHOD TESTS
    //================================================================

    #[Test]
    public function it_displays_the_purchase_page_for_a_product()
    {
        // Arrange
        $product = Product::factory()->create();

        // Act
        $response = $this->actingAs($this->user)->get(route('products.purchaseView', $product));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('products.purchase');
        $response->assertViewHas('product', $product);
        $response->assertSee($product->name);
    }

    #[Test]
    public function it_returns_404_when_viewing_purchase_page_for_non_existent_product()
    {
        // Act: Request a product ID that doesn't exist
        $response = $this->actingAs($this->user)->get(route('products.purchaseView', 999));

        // Assert
        $response->assertNotFound();
    }

    #[Test]
    public function a_user_can_purchase_a_product()
    {
        // Arrange: Create a product with sufficient quantity
        $product = Product::factory()->create(['quantity' => 10, 'price' => 20.00]);
        $purchaseQuantity = 3;

        // Act: Authenticate as a user and make a POST request to the purchase route
        $response = $this->actingAs($this->user)->post(route('products.purchase', $product->id), [
            'quantity' => $purchaseQuantity,
        ]);

        // Assert: Check the outcomes
        $response->assertRedirect(route('products.index'));

        // 1. Assert product quantity was decremented correctly
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => $product->quantity - $purchaseQuantity, // 10 - 3 = 7
        ]);

        // 2. Assert a transaction was created
        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'total_amount' => $product->price * $purchaseQuantity, // 20 * 3 = 60
        ]);

        // 3. Assert the product was attached to the transaction
        $transaction = Transaction::first();
        $this->assertDatabaseHas('product_transaction', [
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => $purchaseQuantity,
            'price_at_purchase' => $product->price,
        ]);
    }
}
