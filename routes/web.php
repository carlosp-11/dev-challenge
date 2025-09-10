<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'InventoryController@index')->name('inventory.index');
    Route::post('/inventory/move', 'InventoryController@store')->name('inventory.store');
    Route::post('/products', 'ProductController@store')->name('products.store');
    Route::post('/warehouses', 'WarehouseController@store')->name('warehouses.store');
});
