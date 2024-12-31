<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\LikeItemController;
use App\Http\Controllers\Step2Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoriesController;

use App\Http\Controllers\OrdersController;




//Route::get('/', function () {return view('welcome');});

//ALL IN NAVIGATION TOP
//Route::get('/', function () {return view('index');});

Route::get('/', [IndexController::class, 'returnIndex']);

Route::get('/phpinfo', function () {return view('phpinfo');});
Route::get('/privacy-policy', function () {return view('privacy');});
Route::get('/rule',[MainController::class, 'rule']);
Route::get('/FAQ', function () {return view('faq');});

//Route::get('/orders',function () {return view('orders');});

Route::get('/orders', [OrdersController::class, 'orders'])->name('orders');



Route::post('/ordersubmit', [Step2Controller::class, 'orderSubmit'])->name('ordersubmit');

//Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::get('/order/{order_group}', [OrderController::class, 'order'])->name('order');

//categories
Route::get('/update_category_name/{category_id}',[CategoriesController::class, 'update_category_name']);
Route::get('/Live_categories',[CategoriesController::class, 'Live_categories']);
Route::post('/add_new_category',[CategoriesController::class, 'add_new_category']);
Route::post('/update_category_name', [categoriesController::class, 'update_category_name'])->name('update_category_name');
Route::post('/update_category_name_full', [categoriesController::class, 'update_category_name_full'])->name('update_category_name_full');

Route::post('/category_status_set_active/{category_id}', [categoriesController::class, 'category_status_set_active'])->name('category_status_set_active');
Route::post('/category_status_set_inactive/{category_id}', [categoriesController::class, 'category_status_set_inactive'])->name('category_status_set_inactive');
Route::post('/category_set_image', [categoriesController::class, 'category_set_image'])->name('category_set_image');






//Route::get('/category', function () {return view('category');});
Route::get('/category/{category_name_or_id}',[MainController::class, 'category_spec']);


Route::get('/view/{item_id}',[MainController::class, 'view_item']);
//Route::get('/category/{category}',[MainController::class, 'category']);
Route::get('/cart',[MainController::class, 'cart']);


Route::get('/cart/step-2',[Step2Controller::class, 'Step2Load']);
//Route::get('/cart/step-2', function () {return view('cart_step_2');});

//ADMIN NAVIGATION
Route::get('/categories',[MainController::class, 'categories']);
Route::get('/specifications',[MainController::class, 'specifications']);
Route::get('/create',[MainController::class, 'create']); //<- validation done
Route::get('/update/view/{item_id}',[MainController::class, 'view_item_update']);


Route::post('/add_item_too_cart/{item_id}',[MainController::class, 'add_item_too_cart']);
Route::get('/add/item/cart/{item_id}',[MainController::class, 'add_item_too_cart_no_quan']);


Route::get('/remove_item_from_cart/{item_id}',[MainController::class, 'remove_item_from_cart']);

Route::get('/ajax_cart_increase_quantity/{item_id}',[AjaxController::class, 'ajax_cart_increase_quantity']);
Route::get('/ajax_cart_decrease_quantity/{item_id}',[AjaxController::class, 'ajax_cart_decrease_quantity']);




//LIVE
//Route::get('/reload/specifications/{item_id}', [MainController::class, 'reloadSpecifications']);
Route::get('/Live_view_update_big_pick/{item_id}',[LiveController::class, 'Live_view_update_big_pick']);
Route::get('/live_reload_all_images/{item_id}', [LiveController::class, 'Live_reload_all_images']);
Route::get('/Live_reload_update_specification/{item_id}', [LiveController::class, 'Live_reload_update_specification']);
Route::get('/Live_specification_add_form/{item_id}',[LiveController::class, 'Live_specification_add_form']);
Route::get('/Live_cart',[LiveController::class, 'Live_cart']);
Route::get('/Live_rule',[LiveController::class, 'Live_rule']);

//Route::get('Live_reload_update_images/{item_id}',[MainController::class, 'Live_reload_update_images']);

//AJAX
Route::post('ajax_move_image_to_left/{image_parse_id}', [AjaxController:: class,'ajax_move_image_to_left']);
Route::post('ajax_move_image_to_right/{image_parse_id}', [AjaxController::class, 'ajax_move_image_to_right']);
Route::post('/ajax_add_new_item', [AjaxController::class, 'ajax_add_new_item']);
Route::post('/ajax_update_item', [AjaxController::class, 'ajax_update_item']);
Route::post('/ajax_add_specification',[AjaxController::class, 'ajax_add_specification']);
Route::post('/ajax_delete_specification_row',[AjaxController::class, 'ajax_delete_specification_row']);
Route::post('/ajax_add_only_value_form',[AjaxController::class, 'ajax_add_only_value_form']);
Route::post('/ajax_update_view_delete_value',[AjaxController::class, 'ajax_update_view_delete_value']);
Route::post('ajax_item_image_upload', [AjaxController:: class,'ajax_item_image_upload']);
Route::post('/ajax_create_rule', [AjaxController:: class,'ajax_create_rule'])->name('ajax_create_rule');





Route::get('/ajax_delete_rule/{rule_id}', [AjaxController:: class,'ajax_delete_rule'])->name('ajax_delete_rule');

Route::post('/ajax_update_specification_parameter', [AjaxController::class, 'ajax_update_specification_parameter'])->name('ajax_update_specification_parameter');


route::post('/add_new_value',[MainController::class, 'add_new_value']);
route::post('/add_new_parameter',[MainController::class, 'add_new_parameter']);
Route::post('/add_new_image/{item_id}', [MainController::class, 'add_new_image']);
Route::get('/delete/item/image/{item_id}/{image_parse_id}', [MainController::class, 'delete_image']);

//Liked items 
Route::get('/like-item',[LikeItemController::class, 'view_like']);
Route::get('/add/like/item/{item_id}',[LikeItemController::class, 'add_like'])->name('add.like');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
