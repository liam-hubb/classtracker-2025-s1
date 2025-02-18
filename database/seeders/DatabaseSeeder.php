<?php

namespace Database\Seeders;

use App\Models\Session;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                UserSeeder::class,
                SessionSeeder::class,
                RolesPermissionsSeeder::class,
            ]
        );

//        UserController::factory()->create([
//            'name' => 'Test UserController',
//            'email' => 'test@example.com',
//        ]);
    }
}
