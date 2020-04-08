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

Route::get('/', 'GeneralController@homepage');
Route::view('/about', 'pages.about');
Route::view('/how-to-use', 'pages.how_to_use');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
//    It should be dashboard/register-delivery for Delivery routes
    Route::view('/register-delivery', 'pages.dashboard.registerDelivery');
    Route::post('/register-delivery', 'DeliveryController@store');
//    It should be dashboard/view-delivery for Delivery routes
    Route::get('/view-deliveries', 'DeliveryController@viewDeliveries');
    Route::get('/view-deliveries/{receiver}', 'DeliveryController@viewReceiverData')->name('receiverData');

//  dashboard route
    Route::get('/dashboard', 'UserController@dashboard');
    Route::view('/dashboard/view-individual-deliveries', 'pages.dashboard.individualDeliveries');
    Route::post('/dashboard/view-individual-deliveries', 'GeneralController@individualData');
    Route::get('/dashboard/my-receivers', 'UserController@myReceivers');

    Route::view('/dashboard/settings', 'pages.dashboard.settings');
    Route::post('/dashboard/settings/update_phone', 'UserController@updatePhone');
    Route::post('/dashboard/settings/update_password', 'UserController@updatePassword');

    Route::view('/dashboard/post-item', 'pages.dashboard.items');
    Route::post('/dashboard/post-item', 'GeneralController@postItem');
    Route::get('/dashboard/get-item', 'GeneralController@getItem');
});
