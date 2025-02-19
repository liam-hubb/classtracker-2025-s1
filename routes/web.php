<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});
Route::get('/roles-permissions', [RolesAndPermissionsController::class, 'index'])->name('roles-permissions.index');
Route::post('/roles-permissions/store', [RolesAndPermissionsController::class, 'assignRole'])->name('roles-permissions.assignRole');
Route::delete('/roles-permissions/destroy', [RolesAndPermissionsController::class, 'removeRole'])->name('roles-permissions.removeRole');

Route::resource('users', UserController::class);
Route::resource('sessions', SessionController::class);

require __DIR__.'/auth.php';
