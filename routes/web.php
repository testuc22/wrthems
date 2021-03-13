<?php

use Illuminate\Support\Facades\Route;

/*
*************************** Admin Controllers ******************************
*/

Route::prefix('admin')->namespace('Admin')->group(function(){
	Route::name('admin-login')->get('admin-login',[App\Http\Controllers\Admin\AdminController::class,'getAdminLoginPage']);
	Route::name('do-admin-login')->post('do-admin-login',[App\Http\Controllers\Admin\AdminController::class,'doAdminLogin']);
	Route::name('admin-dashboard')->get('admin-dashboard',[App\Http\Controllers\Admin\AdminController::class,'getAdminDashboard']);
	Route::name('admin-logout')->get('admin-logout',[App\Http\Controllers\Admin\AdminController::class,'doAdminLogout']);

	/*-------------------Category Controllers------------------*/

	Route::name('add-product-category')->get('add-product-category',[App\Http\Controllers\Admin\CategoryController::class,'getAddCategoryPage']);
	Route::name('create-product-category')->post('create-product-category',[App\Http\Controllers\Admin\CategoryController::class,'addCategory']);
	Route::name('list-product-categories')->get('list-product-categories',[App\Http\Controllers\Admin\CategoryController::class,'listCategories']);
	Route::name('edit-product-category')->get('edit-product-category/{id}',[App\Http\Controllers\Admin\CategoryController::class,'getEditCategoryPage']);
	Route::name('update-category-status')->put('update-category-status',[App\Http\Controllers\Admin\CategoryController::class,'UpdateCategoryStatus']);
	Route::name('update-product-category')->put('update-product-category/{id}',[App\Http\Controllers\Admin\CategoryController::class,'updateCategory']);
	Route::name('delete-category')->get('delete-category',[App\Http\Controllers\Admin\CategoryController::class,'deleteCategory']);

	/*--------------------Tag Controllers------------------*/

	Route::name('get-add-tag')->get('get-add-tag',[App\Http\Controllers\Admin\TagController::class,'getAddTagPage']);
	Route::name('create-tag')->post('create-tag',[App\Http\Controllers\Admin\TagController::class,'addTag']);
	Route::name('list-tags')->get('list-tags',[App\Http\Controllers\Admin\TagController::class,'getAllTags']);
	Route::name('get-edit-tag')->get('get-edit-tag/{id}',[App\Http\Controllers\Admin\TagController::class,'getEditTagPage']);
	Route::name('update-tag')->put('update-tag/{id}',[App\Http\Controllers\Admin\TagController::class,'updateTag']);
	Route::name('delete-tag')->get('delete-tag',[App\Http\Controllers\Admin\TagController::class,'deleteTag']);

	/*----------------Product Controllers-----------------*/

	Route::name('list-products')->get('list-products',[App\Http\Controllers\Admin\ProductController::class,'getAllProducts']);
	Route::name('get-add-product')->get('get-add-product',[App\Http\Controllers\Admin\ProductController::class,'getAddProductPage']);
	Route::name('create-product')->post('create-product',[App\Http\Controllers\Admin\ProductController::class,'createProduct']);
	Route::name('get-edit-product')->get('get-edit-product/{id}',[App\Http\Controllers\Admin\ProductController::class,'getEditProductPage']);
	Route::name('update-product')->put('update-product/{id}',[App\Http\Controllers\Admin\ProductController::class,'updateProduct']);
	Route::name('upload-product-images')->post('upload-product-images/{id}',[App\Http\Controllers\Admin\ProductController::class,'uploadProductImages']);
	Route::name('delete-product-image')->get('delete-product-image',[App\Http\Controllers\Admin\ProductController::class,'deleteProductImage']);
	Route::name('update-product-status')->put('update-product-status',[App\Http\Controllers\Admin\ProductController::class,'UpdateProductStatus']);
	Route::name('delete-product')->get('delete-product',[App\Http\Controllers\Admin\ProductController::class,'deleteProduct']);
});

/************************** Front End Controllers ***************************/
Route::namespace('Front')->group(function(){
	Route::get('/{any}',[App\Http\Controllers\Front\HomeController::class,'getHomePage'])->where('any', '^(?!download-file).*$');
	Route::name('download-file')->get('/download-file',[App\Http\Controllers\Front\UserController::class,'downloadTemplate']);

});
