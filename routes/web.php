<?php

use App\Http\Controllers\armorController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\hunterController;

use App\Http\Controllers\monsterController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\weaponController;

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

/* Route::get('/', function () {
    return view('compartidos.headerAndFooter');
}); */

/* Route::get('/', function () {
    return  view('index');
}); */

/* Route::get('/dashboard', function () {
    return view('auth.hunter');
})->middleware(['auth', 'verified'])->name('dashboard');
 
Route::get('/dashboard', [hunterController::class, 'datos'])->middleware(['auth', 'verified'])->name('dashboard');*/



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/monsters', [monsterController::class, 'index'])->name('monsters');

Route::resource('/monster', monsterController::class)->only(['show']);

Route::get('/weapons', [weaponController::class, 'index'])->name('weapons');

Route::resource('/weapon', weaponController::class)->only(['show']);

Route::get('/armors', [armorController::class, 'index'])->name('armors');

Route::resource('/armor', armorController::class)->only(['show']);