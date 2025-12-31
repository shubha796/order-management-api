
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