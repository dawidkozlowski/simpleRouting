<?php

require_once __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');
define('STORAGE_PATH', __DIR__ . '/../storage');

try {
    $router = new App\Router();

    $router
        ->get('/', [App\Controllers\HomeController::class, 'index'])
        ->post('/upload', [App\Controllers\HomeController::class, 'upload'])
        ->get('/download', [App\Controllers\HomeController::class, 'download'])
        ->get('/invoices', [App\Controllers\InvoiceController::class, 'index'])
        ->get('/invoices/create', [App\Controllers\InvoiceController::class, 'create'])
        ->post('/invoices/create', [App\Controllers\InvoiceController::class, 'store']);

    echo $router->resolve(
        $_SERVER['REQUEST_URI'],
        strtolower($_SERVER['REQUEST_METHOD'])
    );
} catch (\App\Exceptions\RouteNotFoundException $e) {
    http_response_code(404);
//    Will also work
//    header('HTTP/1.1 404 Not Found');
    echo \App\View::make('error/404');
}