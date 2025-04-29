<?php

use App\Models\Course;
use App\Models\User;
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




//beforeEach(function () {
//    // Ensure test user exists for login route
//    User::factory()->create([
//        'email' => 'test@example.com',
//        'password' => bcrypt('password123'),
//    ]);
//    Course::factory()->create([
//        'id' => 1,
//        'national_code' => 'BSB20006',
//        'aqf_level' => 'Certificate I in',
//        'title' => 'Business',
//        'tga_status' => 'Current',
//        'state_code' => 'GGG6',
//        'nominal_hours' => '150',
//        'type' => 'Qualification',
//    ]);
//});
//it('has a working response for all routes', function () {
//    // Define payloads for routes that need them
//    $payloads = [
//        'api/v1/login' => [
//            'email' => 'test@example.com',
//            'password' => 'password123',
//        ],
//        'api/v1/users' => [
//            'email' => 'newuser@example.com',
//            'password' => 'secret123',
//            'given_name' => 'Test',
//            'family_name' => 'User',
//            'pronouns' => 'him',
//        ],
//        'api/v1/courses' => [
//            'national_code' => 'AAA20006',
//            'aqf_level' => 'Certificate III in',
//            'title' => 'Test Course',
//            'tga_status' => 'active',
//            'state_code' => 'GGG8',
//            'nominal_hours' => 120,
//            'type' => 'online',
//        ],
//
//        'api/v1/courses/1' => [
//            'national_code' => 'BSB20007', // Make sure to provide valid data
//            'aqf_level' => 'Certificate I in',
//            'title' => 'Updated Business Course', // Update title or any other field
//            'tga_status' => 'Current',
//            'state_code' => 'GGG6',
//            'nominal_hours' => '150',
//            'type' => 'Qualification',
//        ],
////        'api/roles-permissions/assign' => [
////            'user_id' => 1,
////            'role' => 'admin',
////        ],
//    ];
//    dd($payloads['api/v1/courses/1']);
//
//
//    // Retrieve and format all routes
//    $routes = collect(Route::getRoutes())->map(function ($route) {
//        return [
//            'uri' => ltrim($route->uri(), '/'),
//            'methods' => array_diff($route->methods(), ['HEAD']), // Exclude HEAD for testing
//        ];
//    });
//
//    foreach ($routes as $route) {
//        foreach ($route['methods'] as $method) {
//            $uri = $route['uri'];
//            $url = preg_replace('/\{[^}]+\}/', '1', '/' . $uri);
//
//            $methodUpper = strtoupper($method);
//            $payload = $payloads[$uri] ?? [];
//
//            // Send request with payload if needed
//            $response = in_array($methodUpper, ['POST', 'PUT', 'PATCH'])
//                ? $this->json($methodUpper, $url, $payload)
//                : $this->call($methodUpper, $url);
//
//            $status = $response->status();
//            dump("[$methodUpper] $url => $status");
//
//            // Optional: Special case for 302 redirects (e.g. auth failures)
//            if ($status === 302) {
//                dump("⚠️ Redirect on [$methodUpper] $url, likely missing auth or validation.");
//                continue;
//            }
//
//            // Expect 2xx responses
//            $response->assertSuccessful();
//        }
//    }
// });


