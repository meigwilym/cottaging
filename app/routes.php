<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Mail::pretend(); // debugging

Route::get('/', array('as' => 'home', 'uses' => 'CottageController@getIndex'));

// show all cotagges available
Route::get('cottages', array('as' => 'all', 'uses' => 'CottageController@getIndex'));

// show details, available dates
Route::get('cottages/{slug}', array('as' => 'single', 'uses' => 'CottageController@getCottage'));

// search @todo
// Route::post('search', array('as' => 'search', 'uses' => 'SearchController@doSearch'));

/**
 * API - for ajax calls etc
 */
Route::group(array('prefix'=>'api'), function(){
  
  Route::post('cottage/cost', array('uses' => 'CottageController@postCost'));
  
});


// bookings
Route::group(array('prefix' => 'booking'), function(){
  // booking form
  Route::get('{cottagename}', array('uses', 'BookingController@bookingForm'));
  
  // store draft booking
  Route::post('{cottagename}/book', array('uses'=> 'BookingController@storeBooking'));

  // booking make payment
  Route::get('{id}/payment', array('uses'=> 'BookingController@paymentBooking'));
  Route::post('{id}/payment', array('uses'=> 'BookingController@processPayment'));

  // show confirmation
  Route::get('{id}/confirm', array('uses'=> 'BookingController@confirmBooking'));
  
});


// admin routes
Route::group(array('prefix' => 'admin', 'before'=>'auth.admin'), function()
{
    // home screen
    Route::get('/', array('as'=>'admin.dash', 'uses' => 'Admin\AdminController@showDashboard'));
    
    // all bookings
    Route::get('bookings', array('as'=>'admin.bookings.all', 'uses' => 'Admin\BookingController@index'));
    Route::get('bookings/{period}', array('as'=>'admin.bookings.period', 'uses' => 'Admin\BookingController@index'))
            ->where('period', '(future|active|past)');
    
    // per cottage
    Route::get('bookings/cottage/{id}', array('uses'=>'Admin\BookingController@cottage'));
    
    // single
    Route::get('booking/{id}', array('as' => 'admin.booking', 'uses' => 'Admin\BookingController@show'));
    
    /**
     * Almost a resource controller.
     */    
    Route::get('cottages', array('as' => 'admin.cottage', 'uses' => 'Admin\CottageController@index'));
    Route::get('cottages/create', array('as' => 'admin.cottage.create', 'uses' => 'Admin\CottageController@create'));
    Route::post('cottages', array('as' => 'admin.cottage.store', 'uses' => 'Admin\CottageController@store'));    
    Route::get('cottages/{id}', array('as' => 'admin.cottage.show', 'uses' => 'Admin\CottageController@show'));
    Route::get('cottages/{id}/edit', array('as' => 'admin.cottage.edit', 'uses' => 'Admin\CottageController@edit'));    
    Route::put('cottages/{id}', array('as' => 'admin.cottage.update', 'uses' => 'Admin\CottageController@update'));    
    Route::delete('cottages/{id}', array('as' => 'admin.cottage.destroy', 'uses' => 'Admin\CottageController@destroy'));
    
    // related cottage functions
    Route::post('cottages/{id}/images', array('uses' => 'Admin\Cottage\ImageController@store'));
    Route::delete('cottages/{id}/image', array('uses' => 'Admin\Cottage\ImageController@destroy'));
    Route::post('cottages/{id}/prices', array('uses' => 'Admin\Cottage\PriceController@update'));
    
}); // /admin


Route::get('logout', array('as' => 'admin.logout', 'uses' => 'AuthController@getLogout'));
Route::get('login', array('as' => 'admin.login', 'uses' => 'AuthController@getLogin'));
Route::post('login', array('as' => 'admin.login.post', 'uses' => 'AuthController@postLogin'));