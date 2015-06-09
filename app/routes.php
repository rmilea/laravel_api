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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/authtest', array('before' => 'auth.basic', function()
{
    return View::make('hello');
}));

// Route group for API versioning
Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('trip', 'TripController');
});

// Route group for API versioning
Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('flight', 'FlightController');
});	

Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::get('getAllFlights/{id}', array('as' => 'getAllFlights', 'uses' => 'FlightController@getAllFlights'));
    Route::get('getAllAirports', array('as' => 'getAllAirports', 'uses' => 'FlightController@getAllAirports'));
    Route::get('addToTrip/{tripId}/newFlight/{airportId}', array('as' => 'addToTrip', 'uses' => 'FlightController@addNewFlightToTrip'));
    Route::get('removeFromTrip/{tripId}/airport/{airportId}', array('as' => 'removeFromTrip', 'uses' => 'FlightController@removeFlightFromTrip'));
    Route::post('addNewAirport', array('as' => 'addNewAirport', 'uses' => 'FlightController@addNewAirport'));
});	