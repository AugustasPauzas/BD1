<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

//Route::get('/', function () {return view('welcome');});



//ALL IN NAVIGATION TOP
Route::get('/', function () {return view('index');});
Route::get('/phpinfo', function () {return view('phpinfo');});
//Route::get('/category', function () {return view('category');});
Route::get('/category/{category_name_or_id}',[MainController::class, 'category_spec']);

Route::get('/category',[MainController::class, 'category_unspec']);

Route::get('/view/{item_id}',[MainController::class, 'view_item']);
//Route::get('/category/{category}',[MainController::class, 'category']);
Route::get('/cart',[MainController::class, 'cart']);
    //ADMIN NAVIGATION
    Route::get('/categories',[MainController::class, 'categories']);
    Route::get('/specifications',[MainController::class, 'specifications']);

    Route::get('/create',[MainController::class, 'create']); //<- validation done

    Route::get('/update/view/{item_id}',[MainController::class, 'view_item_update']);

//LIVE


Route::get('/reload/specifications/{item_id}', [MainController::class, 'reloadSpecifications']);



Route::get('/Live_view_update_big_pick/{item_id}',[MainController::class, 'Live_view_update_big_pick']);

Route::get('/live_reload_all_images/{item_id}', [MainController::class, 'Live_reload_all_images']);

Route::get('/Live_reload_update_specification/{item_id}', [MainController::class, 'Live_reload_update_specification']);

Route::get('/Live_specification_add_form/{item_id}',[MainController::class, 'Live_specification_add_form']);


//Route::get('Live_reload_update_images/{item_id}',[MainController::class, 'Live_reload_update_images']);




//FUNCTIONAL ROUTES
    //TABLE CATEGORY
    route::post('/add_new_category',[MainController::class, 'add_new_category']);
    //TABLE SPECIFICATION
    route::post('/ajax_add_specification',[MainController::class, 'ajax_add_specification']);
    route::post('/ajax_delete_specification_row',[MainController::class, 'ajax_delete_specification_row']);


    //TABLE VALUE
    route::post('/add_new_value',[MainController::class, 'add_new_value']);
    route::post('/ajax_update_view_delete_value',[MainController::class, 'ajax_update_view_delete_value']);
    route::post('/ajax_add_only_value_form',[MainController::class, 'ajax_add_only_value_form']);



    //TABLE PARAMETER
    route::post('/add_new_parameter',[MainController::class, 'add_new_parameter']);
    Route::post('/ajax_update_specification_parameter', [MainController::class, 'ajax_update_specification_parameter'])->name('ajax_update_specification_parameter');



    //TABLE ITEM
    //Route::post('/add_new_item', [MainController::class, 'add_new_item']);
    Route::post('/ajax_add_new_item', [MainController::class, 'ajax_add_new_item']);
    Route::post('/ajax_update_item', [MainController::class, 'ajax_update_item']);


    //TABLE IMAGE IMAGEPARSE
    //route::post('/add_new_image/{item_id}',[MainController::class, 'add_new_image']);

    route::post('ajax_item_image_upload', [MainController:: class,'ajax_item_image_upload']);

    route::post('ajax_move_image_to_left/{image_parse_id}', [MainController:: class,'ajax_move_image_to_left']);
    Route::post('ajax_move_image_to_right/{image_parse_id}', [MainController::class, 'ajax_move_image_to_right']);
    //route::post('ajax_move_image_to_right/{image_parse_id}', [MainController:: class,'ajax_move_image_to_right']);

    Route::post('/add_new_image/{item_id}', [MainController::class, 'add_new_image']);

    Route::get('/delete/item/image/{item_id}/{image_parse_id}', [MainController::class, 'delete_image']);






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
