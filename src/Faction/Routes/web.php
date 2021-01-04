<?php 
$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['namespace' => 'AndrykVP\Rancor\Faction\Http\Controllers', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware ], function(){
	Route::resources([
		'factions' => 'FactionController',
		'departments' => 'DepartmentController',
		'ranks' => 'RankController',
	]);
});