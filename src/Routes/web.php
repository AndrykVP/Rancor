<?php 

use AndrykVP\SWC\Models\Planet;

Route::group(['namespace' => 'AndrykVP\SWC\Http\Controllers', 'middleware' => ['web']], function(){
	Route::get('register', 'AccessCode@dispatch');
	Route::get('siggen','IDGenController@signature');
	Route::get('dev', function() {
		return view('form');
	});
});

Route::group(['namespace' => 'AndrykVP\SWC\Http\Controllers', 'middleware' => ['api']], function(){
	Route::post('facility/find','FacilityController@search');
});