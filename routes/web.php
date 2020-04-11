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
Route::get('/all-stats', 'GeneralController@allStats');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
//    It should be dashboard/register-delivery for Delivery routes
    Route::view('dashboard/register-delivery-new', 'pages.dashboard.register_delivery_new');
    Route::post('dashboard/register-delivery-new', 'DeliveryController@newDelivery');

    Route::view('dashboard/register-delivery-existing', 'pages.dashboard.register_delivery_existing');
    Route::post('dashboard/register-delivery-existing', 'DeliveryController@existingDelivery');

    Route::get('/view-deliveries', 'DeliveryController@viewDeliveries');
    Route::get('/view-deliveries/{receiver}', 'ReceiverController@viewReceiverData')->name('receiverData');

    Route::get('/dashboard', 'UserController@dashboard');
    Route::view('/dashboard/view-individual-deliveries', 'pages.dashboard.individualDeliveries');
    Route::post('/dashboard/view-individual-deliveries', 'GeneralController@individualData');
    Route::get('/dashboard/my-receivers', 'UserController@myReceivers');

    Route::view('/dashboard/settings', 'pages.dashboard.settings');
    Route::post('/dashboard/settings/update_phone', 'UserController@updatePhone');
    Route::post('/dashboard/settings/update_password', 'UserController@updatePassword');

    Route::get('/dashboard/needs-help/receiver={receiver}&ph_no={phone_no}', 'ReceiverController@determineHelp')->name('help');
});
