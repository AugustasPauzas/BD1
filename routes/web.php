<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', function () {return view('index');});
//Route::get('/', function () {return view('welcome');});
Route::get('/phpinfo', function () {return view('phpinfo');});


Route::get('/categories',[MainController::class, 'categories']);

Route::get('/category', function () {return view('category');});
Route::get('/category/{category}',[MainController::class, 'category']);

route::post('/add_new_category',[MainController::class, 'add_new_category']);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
