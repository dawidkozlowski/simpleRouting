<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new App\Router();

$router
    ->get('/', [App\Controllers\HomeController::class, 'index'])
    ->get('/invoices', [App\Controllers\InvoiceController::class, 'index'])
    ->get('/invoices/create', [App\Controllers\InvoiceController::class, 'create'])
    ->post('/invoices/create', [App\Controllers\InvoiceController::class, 'create'])
    ;
$router->register(
    '/invoices',
    function () {
        echo 'invoices';
    }
);

echo $router->resolve($_SERVER['REQUEST_URI']);