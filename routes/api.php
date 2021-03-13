<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Front')->group(function(){
	Route::get('/categories',[App\Http\Controllers\Front\HomeController::class,'getCategories']);
	Route::get('/webtemplates',[App\Http\Controllers\Front\HomeController::class,'getWebTemplates']);
	Route::get('/webtemplates-by-category',[App\Http\Controllers\Front\HomeController::class,'getWebTemplatesByCategory']);
	Route::get('/webtemplates-by-tag',[App\Http\Controllers\Front\HomeController::class,'getWebTemplatesByTag']);
	Route::get('/web-template-details',[App\Http\Controllers\Front\HomeController::class,'getWebTemplateDetails']);

	/*----------------------------------User Controller-------------------------------------*/
	
	Route::post('/register',[App\Http\Controllers\Front\UserController::class,'registerUser']);
	Route::post('/login',[App\Http\Controllers\Front\UserController::class,'loginUser']);

	Route::name('search-templates')->get('/search-templates',[App\Http\Controllers\Front\UserController::class,'searchTemplates']);
	
	Route::middleware('auth:api')->group(function(){
		Route::post('/add-to-cart',[App\Http\Controllers\Front\UserController::class,'addToCart']);
		Route::name('user-cart')->get('/user-cart',[App\Http\Controllers\Front\UserController::class,'getUserCartItems']);
		Route::delete('/remove-from-cart/{id}',[App\Http\Controllers\Front\UserController::class,'removeFromCart']);
		Route::post('/place-order',[App\Http\Controllers\Front\UserController::class,'placeOrder']);
		Route::post('/capture-paypal-transaction',[App\Http\Controllers\Front\UserController::class,'capturePaypalTransaction']);
		
		Route::name('get-user-orders')->get('/get-user-orders',[App\Http\Controllers\Front\UserController::class,'getUserOrders']);
	});
});



/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
