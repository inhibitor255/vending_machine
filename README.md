# Vending Machine

This is a Laravel application that simulates a vending machine. It is built with the Tailwind CSS, Blade, and Laravel).

## Features

* **User Authentication:** Standard Laravel authentication with email verification, powered by Laravel Breeze.
* **Role-Based Access Control:** The application has a basic role-based access control system with `admin` and `user` roles.
* **Product Management:** Admins can create, read, update, and delete products.
* **Product Purchase:** Users can purchase products, which decrements the product quantity and logs the transaction.
* **Transaction System:** The application has a system for handling transactions.
* **User Settings:** Users can manage their profile and password.
* **Paginated Product List:** The product list is paginated and includes sorting controls for product name, price, and quantity.
* **Server-Side and Client-Side Validation:** Product input forms utilize server-side validation via `ProductRequest` to ensure data integrity. Fields like name, price, and quantity are validated for presence, format, and range. Validation errors are automatically available in Client (Blade) views for display.
* **API Validation** Secure API validation with sanctum with token based authentication.
* **REST API** Standard API format for other frontend applications to interact with the
vending machine system.
* **Testing** Can Test Products API with `php artisan test tests/Feature/Api/V1/ProductControllerTest.php` and Test Products with `php artisan test tests/Feature/ProductControllerTest.php` or you can simply just type `php artisan test`.
* **Deployment** Deployment using Docker for contaninerization on AWS server.

## Tech Stack

* **Backend:** PHP 8.2, Laravel 12
* **Frontend:** Blade
* **Database:** MySQL
* **Deployment** Docker, AWS

## Getting Started

1. **Clone the repository:**

    ```bash
    git clone https://github.com/inhibitor255/vending_machine.git
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Set up your environment:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

5. **Start the development server:**

    ```bash
    npm run dev
    ```

## Authorization

The application uses a Gate to authorize actions. The following Gates are defined:

* `is_admin`: This gate checks if the authenticated user has the `admin` role.

## Testing

To run the tests, use the following command:

```bash
php artisan test
```
