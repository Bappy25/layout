<?php

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

// Frontend page routes
Route::group(['namespace' => 'Frontend'], function(){

	Route::get('/', 'HomeController@index')->name('welcome');
	Route::get('about_us', 'HomeController@about')->name('about_us');
	Route::get('terms_of_use', 'HomeController@termsOfUse')->name('terms_of_use');
	Route::get('privacy_policy', 'HomeController@privacyPolicy')->name('privacy_policy');

	// Social media signin
	Route::get('google/redirect', 'Auth\LoginController@redirectToGoogleProvider')->name('google.redirect');
	Route::get('google/callback', 'Auth\LoginController@handleGoogleProviderCallback')->name('google.callback');
	Route::get('facebook/redirect', 'Auth\LoginController@redirectToFacebookProvider')->name('facebook.redirect');
	Route::get('facebook/callback', 'Auth\LoginController@handleFacebookProviderCallback')->name('facebook.callback');

	Auth::routes(['verify' => true]);

	Route::get('home', 'HomeController@home')->name('home');

	// User routes
	Route::group(['prefix' => 'users'], function(){
		Route::get('{username}', 'UserController@profile')->name('users.profile');
		Route::post('status', 'UserController@getStatus')->name('users.status');
	});

	// News Routes
	Route::get('news', 'NewsController@index')->name('news.index');
	Route::get('news/{id}', 'NewsController@show')->name('news.show');

	Route::group(['prefix' => 'account', 'namespace' => 'Account'], function(){

		// Account Routes
		Route::get('/', 'AccountController@index')->name('account.index');
		Route::get('edit', 'AccountController@edit')->name('account.edit');
		Route::put('update', 'AccountController@update')->name('account.update');
		Route::put('update/image', 'AccountController@updateImage')->name('account.update.image');

		// Notification Routes
		Route::group(['prefix' => 'notifications'], function(){
			Route::get('/', 'NotificationController@allNotifications')->name('notifications.index');
			Route::get('new', 'NotificationController@newNotifications')->name('notifications.new');
			Route::get('new/count', 'NotificationController@countNotifications')->name('notifications.new.count');
			Route::put('mark/read', 'NotificationController@markNotificationsAsRead')->name('notifications.mark.read');

		});

		// Message Routes
		Route::resource('messages', 'MessageController', ['except' => 'create']);
		Route::group(['prefix' => 'messages'], function(){
			Route::get('new/get', 'MessageController@newMessages')->name('messages.new');
			Route::get('new/count', 'MessageController@newMessagesCount')->name('messages.new.count');
			Route::get('create/{username}', 'MessageController@create')->name('messages.create');
			Route::post('addSubject', 'MessageController@addMessageSubject')->name('messages.add.subject');
			Route::post('status', 'MessageController@getStatus')->name('messages.get.status');
			Route::get('subject/{id}/edit', 'MessageController@editSubject')->name('messages.subject.edit');
			Route::post('subject/{id}/update', 'MessageController@updateSubject')->name('messages.subject.update');
			Route::post('users/search', 'MessageController@getUserList')->name('messages.users');
			Route::post('users/add', 'MessageController@addParticipant')->name('messages.users.add');
			Route::delete('users/{id}', 'MessageController@removeReceipent')->name('messages.users.remove');

		});

	});

});

// Backend page routes
Route::group(['prefix' => 'back', 'namespace' => 'Backend'], function(){

	Route::group(['namespace' => 'Auth'], function(){

		// Authentication Routes
		Route::get('login', 'LoginController@showLoginForm')->name('back.login');
		Route::post('login', 'LoginController@login');
		Route::post('logout', 'LoginController@logout')->name('back.logout');

		// Registration Routes
		Route::group(['prefix' => 'register'], function(){
			Route::get('/', 'RegisterController@showRegistrationForm')->name('back.register');
			Route::post('/', 'RegisterController@register');
		});

		// Password Reset Routes
		Route::group(['prefix' => 'password'], function(){
			Route::get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('back.password.request');
			Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('back.password.email');
			Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('back.password.reset');
			Route::post('reset', 'ResetPasswordController@reset')->name('back.password.update');
		});

	});

	Route::get('home', 'HomeController@index')->name('back.home');

	// Administrators
	Route::resource('admins', 'AdminController', ['as' => 'back']);

	// Users
	Route::resource('users', 'UserController', ['as' => 'back']);
	Route::put('users/{id}/update/image', 'UserController@updateImage')->name('back.users.update.image');

	// Webcontroller
	Route::group(['prefix' => 'contents'], function(){
		Route::get('welcome', 'ContentController@welcome')->name('back.contents.welcome');
		Route::get('about_us', 'ContentController@aboutUs')->name('back.contents.about');
		Route::get('terms_of_use', 'ContentController@termsOfUse')->name('back.contents.terms');
		Route::get('privacy_policy', 'ContentController@privacyPolicy')->name('back.contents.policy');
		Route::put('{id}', 'ContentController@update')->name('back.contents.update');
	});

	// NewsController
	Route::resource('news', 'NewsController', ['as' => 'back', 'except' => 'show']);
	Route::group(['prefix' => 'news'], function(){
		Route::put('{id}/update/image', 'NewsController@updateImage')->name('back.news.update.image');
		Route::put('{id}/publish', 'NewsController@publish')->name('back.news.publish');
	});

});

// General routes
Route::post('add_content_image', 'Controller@addContentImage')->name('contents.image.add');