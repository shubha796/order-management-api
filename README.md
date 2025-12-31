
1) Folder structure
_____________________

app/
    Http/
        Controllers/
            OrderController.php
        Requests/
            OrderRequest.php
    Models/
        Order.php
        OrderItem.php
    Services/ 
        Order/OrderService.php
database/
    migrations/
        2025_12_31_050410_create_orders_table.php
        2025_12_31_050524_create_order_items_table.php

routes/
    api.php

2) Architectural and design decisions
______________________________________

*) Controllers are kept thin and only handle HTTP requests/responses

*) All business logic (calculations, order number generation) is handled in the Service class

*) Validation is done using Form Requests

*) Database operations are wrapped in transactions to ensure data consistency


3) Steps to run the project locally
_____________________________________

Prerequisites: PHP 8+, Composer, XAMPP (MySQL)

git clone https://github.com/shubha796/order-management-api.git
cd order-management-api
composer install
cp .env.example .env

Create Database

Start MySQL in XAMPP

Create database (example: order_management)

Update .env:

DB_DATABASE=order_management
DB_USERNAME=root
DB_PASSWORD=

php artisan key:generate
php artisan migrate
php artisan serve

App runs at: http://localhost


API Usage
Endpoint : POST /api/orders

Headers
Accept: application/json
Content-Type: application/json

Body

{
  "order_date": "2025-01-01",
  "items": [
    { "product_name": "iPhone 17", "quantity": 1, "price": 2500 },
    { "product_name": "phone cover", "quantity": 2, "price": 100 }
  ]
}