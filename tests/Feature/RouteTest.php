<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;

$excludedUris = [
    'sanctum/csrf-cookie',
];

it('has a working response for all routes', function () {
    // Retrieve all routes
    $routes = collect(Route::getRoutes())->map(function ($route) {
        return [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
        ];
    });

    // Iterate over each route
    foreach ($routes as $route) {
        foreach ($route['methods'] as $method) {
            $response = $this->call($method, $route['uri']);
            dump("[$method] /{$route['uri']} => {$response->status()}");

            // Check if the response is successful
            $response->assertSuccessful(); // accepts any 2xx status code
        }
    }
});



