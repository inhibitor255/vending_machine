# Vending Machine

This is a Laravel application that simulates a vending machine. It is built with the TALL stack (Tailwind CSS, Alpine.js, Livewire, and Laravel).

## Features

*   **User Authentication:** Standard Laravel authentication with email verification, powered by Laravel Breeze.
*   **Role-Based Access Control:** The application has a basic role-based access control system with `admin` and `user` roles.
*   **Product Management:** Users can create, read, update, and delete products.
*   **Transaction System:** The application has a system for handling transactions.
*   **User Settings:** Users can manage their profile and password.

## Tech Stack

*   **Backend:** PHP 8.2, Laravel 12
*   **Frontend:** Livewire, Volt, Tailwind CSS, Alpine.js
*   **Database:** SQLite (by default)

## Getting Started

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/inhibitor255/vending_machine.git
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Set up your environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Run the database migrations:**
    ```bash
    php artisan migrate
    ```
5.  **Start the development server:**
    ```bash
    npm run dev
    ```

## Authorization

The application uses a Gate to authorize actions. The following Gates are defined:

*   `is_admin`: This gate checks if the authenticated user has the `admin` role.

## Testing

To run the tests, use the following command:

```bash
php artisan test
```
