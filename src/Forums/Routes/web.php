<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Forums\Http\Controllers', 'middleware' => ['web']], function(){
	Route::get('forums','ForumController@index');
	Route::get('forums/{slug}','ForumController@board');
	Route::get('forums/discussion/{id}','ForumController@discussion');
});