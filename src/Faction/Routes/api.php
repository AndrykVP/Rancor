<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Faction\Http\Controllers\API', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'factions' => 'FactionController',
		'departments' => 'DepartmentController',
		'ranks' => 'RankController',
	]);
});