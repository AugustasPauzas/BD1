<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

//Route::get('/', function () {return view('welcome');});



//ALL IN NAVIGATION TOP
Route::get('/', function () {return view('index');});
Route::get('/phpinfo', function () {return view('phpinfo');});
//Route::get('/category', function () {return view('category');});
Route::get('/category',[MainController::class, 'category_unspec']);
Route::get('/category/{category}',[MainController::class, 'category']);
    //ADMIN NAVIGATION
    Route::get('/categories',[MainController::class, 'categories']);
    Route::get('/specifications',[MainController::class, 'specifications']);


//FUNCTIONAL ROUTES
    //TABLE CATEGORY
    route::post('/add_new_category',[MainController::class, 'add_new_category']);

    //TABLE VALUE
    route::post('/add_new_value',[MainController::class, 'add_new_value']);

    //TABLE PARAMETER
    route::post('/add_new_parameter',[MainController::class, 'add_new_parameter']);




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
