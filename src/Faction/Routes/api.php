<?php 

Route::group(['namespace' => 'AndrykVP\Rancor\Faction\Http\Controllers', 'prefix' => 'api', 'middleware' => ['api']], function(){
	Route::apiResources([
		'faction' => 'FactionController',
		'department' => 'DepartmentController',
		'rank' => 'RankController',
	]);
});