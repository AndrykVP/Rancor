<?php 

use Illuminate\Support\Facades\Route;
use Rancor\Holocron\Http\Controllers\NodeController;
use Rancor\Holocron\Http\Controllers\CollectionController;
use Rancor\Holocron\Http\Controllers\HolocronController;

$middleware = array_merge(['web'],config('rancor.middleware.web'), ['admin']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => $middleware] , function(){
	Route::post('nodes/search', [NodeController::class, 'search'])->name('nodes.search');
	Route::post('collections/search', [CollectionController::class, 'search'])->name('collections.search');
	Route::resources([
		'nodes' => NodeController::class,
		'collections' => CollectionController::class,
	]);
});

Route::group(['prefix' => 'holocron', 'as' => 'holocron.', 'middleware' => 'web'], function(){
	Route::get('/', [HolocronController::class, 'index'])->name('index');
	Route::get('/collections', [HolocronController::class, 'collection_index'])->name('collection.index');
	Route::get('/nodes', [HolocronController::class, 'node_index'])->name('node.index');
	Route::get('/collections/{collection:slug}', [HolocronController::class, 'collection_show'])->name('collection.show');
	Route::get('/nodes/{node}', [HolocronController::class, 'node_show'])->name('node.show');
});