<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Manager\UserController as ManagerUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::prefix('manager')->middleware(['manager'])->group(function () {
        Route::get('dashboard', [ManagerUserController::class, 'dashboard'])->name('manager.dashboard');
    });

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::resource('users', AdminUserController::class);
    });
});

require __DIR__ . '/auth.php';
