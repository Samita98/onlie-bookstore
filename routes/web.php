<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('product/{permalink}', 'Front\ProductController@load_product')->name('product.detail');
Route::get('category/{permalink}', 'Front\ProductController@load_category')->name('category.detail');
Route::get('author/{permalink}', 'Front\ProductController@load_author')->name('author.detail');
Route::get('/author', ['uses' => 'Front\ProductController@author_list', 'as'=>'author_list']);
Route::post('/submit/form/{id}', 'Front\FrontController@submit_form')->name('form.submit');

Route::get('/search','Front\ProductController@search')->name('search');
Route::post('/place-order','Front\CheckoutController@placeorder')->name('placeorder');

Auth::routes(['verify' => true]);


Route::post('product/cart/add/{id}', 'Front\ProductController@add_cart')->name('cart.add');
Route::post('product/cart/update/{id}', 'Front\ProductController@update_cart')->name('cart.update');
Route::get('product/cart/{id}/remove', 'Front\ProductController@remove_cart')->name('cart.remove');
Route::get('cart', 'Front\ProductController@view_cart')->name('cart.view');

Route::get('checkout', 'Front\CheckoutController@index')->name('checkout');




Route::get('/', 'HomeController@index')->name('home');
Route::get('{permalink}', ['uses' => 'Front\FrontController@page_detail', 'as'=>'route.page']);

Route::prefix('admin')->group(function() {
	Route::get('login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\Admin\LoginController@login')->name('admin.login');
	Route::prefix('dashboard')->group(function() {
		Route::group(['middleware' => ['auth:admin']], function () {
			Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
			Route::resource('admin', 'Admin\AdminUserController')->names('admin.admin');
			Route::resource('product', 'Admin\ProductController')->names('admin.product');
            Route::post('/product/ajax', ['uses'=>'Admin\ProductController@ajax', 'as'=>'admin.product.ajax']);
            Route::post('/product/{id}/restore', ['uses'=>'Admin\ProductController@restore', 'as'=>'admin.product.restore']);
			Route::resource('page', 'Admin\PageController')->names('admin.page');
			Route::post('/page/{id}/restore', ['uses'=>'Admin\PageController@restore', 'as'=>'admin.page.restore']);
            

			Route::resource('author', 'Admin\AuthorController')->names('admin.author');
			Route::post('/author/{id}/restore', ['uses'=>'Admin\AuthorController@restore', 'as'=>'admin.author.restore']);

			Route::resource('category', 'Admin\CategoryController')->names('admin.category');
			Route::post('/category/{id}/restore', ['uses'=>'Admin\CategoryController@restore', 'as'=>'admin.category.restore']);
			Route::get('/media', ['uses'=>'Admin\MediaController@index', 'as'=>'admin.media.index']);
			Route::post('/media', ['uses'=>'Admin\MediaController@action', 'as'=>'admin.media.action']);
			Route::post('/media/ajax', ['uses'=>'Admin\MediaController@ajax', 'as'=>'admin.media.ajax']);
			Route::delete('/media/{id}', ['uses'=>'Admin\MediaController@destroy', 'as'=>'admin.media.destroy']);
            Route::post('/media/{id}/restore', ['uses'=>'Admin\MediaController@restore', 'as'=>'admin.media.restore']);
            
           	Route::get('/menu/create/{id}', ['uses'=>'Admin\MenuController@create', 'as'=>'admin.menu.new']);
	        Route::post('/menu/ajax', ['uses'=>'Admin\MenuController@ajax', 'as'=>'admin.menu.ajax']);
	        Route::post('/menu/{id}', ['uses'=>'Admin\MenuController@store', 'as'=>'admin.menu.store']);
            Route::resource('/menu', 'Admin\MenuController')->except(['create', 'store'])->names('admin.menu');
            
            Route::resource('/form', 'Admin\FormController')->only(['index', 'edit', 'update', 'show'])->names('admin.form');
            Route::get('/form/entries/{id}', ['uses'=>'Admin\FormController@entries', 'as'=>'admin.form.entries']);
            Route::get('/form/entry/{id}/pdf', ['uses'=>'Admin\FormController@entry_pdf', 'as'=>'admin.form.entry_pdf']);
            
            Route::resource('slider', 'Admin\SliderController')->names('admin.slider');
            Route::post('/slider/{id}/restore', ['uses'=>'Admin\SliderController@restore', 'as'=>'admin.slider.restore']);
        	Route::post('/slider/ajax', ['uses'=>'Admin\SliderController@ajax', 'as'=>'admin.slider.ajax']);
            
           	Route::get('/setting', ['uses'=>'Admin\SettingController@index', 'as'=>'admin.setting.index']);
            Route::post('/setting', ['uses'=>'Admin\SettingController@store', 'as'=>'admin.setting.store']);
    
        	Route::get('/setting/home', ['uses'=>'Admin\SettingController@home', 'as'=>'admin.setting.home']);
        	Route::post('/setting/home', ['uses'=>'Admin\SettingController@home_store', 'as'=>'admin.setting.home_store']);
        	
        	Route::get('/setting/legal-documents', ['uses'=>'Admin\SettingController@ldocuments', 'as'=>'admin.setting.ldocuments']);
        	Route::post('/setting/legal-documents', ['uses'=>'Admin\SettingController@ldocuments_store', 'as'=>'admin.setting.ldocuments_store']);
            
            Route::get('/setting/site-images', ['uses'=>'Admin\SettingController@homeimages', 'as'=>'admin.setting.homeimages']);
        	Route::post('/setting/site-images', ['uses'=>'Admin\SettingController@homeimages_store', 'as'=>'admin.setting.homeimages_store']);

			Route::resource('review', 'Admin\ReviewController')->except(['create', 'store'])->names('admin.review');
            Route::post('/review/{id}/restore', ['uses'=>'Admin\ReviewController@restore', 'as'=>'admin.review.restore']);
            Route::post('/review/ajax', ['uses'=>'Admin\ReviewController@ajax', 'as'=>'admin.review.ajax']);
            

			Route::resource('user', 'Admin\UserController')->except(['create', 'store'])->names('admin.user');
            Route::post('/user/{id}/restore', ['uses'=>'Admin\UserController@restore', 'as'=>'admin.user.restore']);
            Route::post('/user/ajax', ['uses'=>'Admin\UserController@ajax', 'as'=>'admin.user.ajax']);

			Route::get('/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');
		});
	});
});
Route::prefix('user')->group(function() {
	Route::prefix('dashboard')->group(function() {
		Route::group(['middleware' => ['auth:web', 'verified']], function () {
			Route::get('/', ['uses'=>'User\MainController@index', 'as'=>'user.dashboard']);
			Route::post('/review/post/{id}', ['uses'=>'User\MainController@add_review', 'as'=>'user.review.add']);

			Route::get('/profile/edit', ['uses'=>'User\ProfileController@edit', 'as'=>'user.profile.edit']);
			Route::post('/profile/update', ['uses'=>'User\ProfileController@update', 'as'=>'user.profile.update']);

			Route::get('/product/create', ['uses'=>'User\ProductController@create', 'as'=>'user.product.create']);
			Route::get('/product', ['uses'=>'User\ProductController@index', 'as'=>'user.product.index']);
			Route::post('/product', ['uses'=>'User\ProductController@store', 'as'=>'user.product.store']);
			Route::get('/product/{id}/edit', ['uses'=>'User\ProductController@edit', 'as'=>'user.product.edit']);
			Route::post('/product/{id}/update', ['uses'=>'User\ProductController@update', 'as'=>'user.product.update']);
			Route::post('/product/ajax', ['uses'=>'User\ProductController@ajax', 'as'=>'user.product.ajax']);
            Route::post('/product/{id}/restore', ['uses'=>'User\ProductController@restore', 'as'=>'user.product.restore']);
            Route::delete('/product/{id}', ['uses'=>'User\ProductController@destroy', 'as'=>'user.product.destroy']);

            Route::get('/media', ['uses'=>'User\MediaController@index', 'as'=>'user.media.index']);
			Route::post('/media', ['uses'=>'User\MediaController@action', 'as'=>'user.media.action']);
			Route::post('/media/ajax', ['uses'=>'User\MediaController@ajax', 'as'=>'user.media.ajax']);
			Route::delete('/media/{id}', ['uses'=>'User\MediaController@destroy', 'as'=>'user.media.destroy']);
            
		});
	});
});
