<?php 

Route::group(['namespace' => 'CasWaryn\API\Http\Controllers', 'middleware' => ['web']], function(){
	Route::get('register', 'AccessCode@dispatch');
});