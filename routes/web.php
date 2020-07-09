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

	Route::group(['prefix' => 'account', 'namespace' => 'Account'], function(){

		// Account Routes
		Route::get('/', 'AccountController@index')->name('account.index');
		Route::get('edit', 'AccountController@edit')->name('account.edit');
		Route::put('{id}/update', 'AccountController@update')->name('account.update');
		Route::put('update/image', 'AccountController@updateImage')->name('account.update.image');

		// Notification Routes
		Route::group(['prefix' => 'notifications'], function(){
			
			Route::get('/', 'NotificationController@allNotifications')->name('notifications.index');
			Route::get('new', 'NotificationController@newNotifications')->name('notifications.new');
			Route::get('new/count', 'NotificationController@countNotifications')->name('notifications.new.count');
			Route::get('mark/read', 'NotificationController@markNotificationsAsRead')->name('notifications.mark.read');

		});

		// Message Routes
		Route::group(['prefix' => 'messages'], function(){

			Route::get('newmessages', 'MessageController@newMessages')->name('messages.new');
			Route::get('newmessages/count', 'MessageController@newMessagesCount')->name('messages.new.count');
			Route::get('/', 'MessageController@index')->name('messages.index');
			Route::get('create/{username}', 'MessageController@create')->name('messages.create');
			Route::post('addSubject', 'MessageController@addMessageSubject')->name('messages.add.subject');
			Route::get('{id}', 'MessageController@show')->name('messages.show');
			Route::post('status', 'MessageController@getStatus')->name('messages.get.status');
			Route::post('image/add', 'MessageController@addImage')->name('messages.image.add');
			Route::post('/', 'MessageController@store')->name('messages.store');
			Route::get('{id}/edit', 'MessageController@edit')->name('messages.edit');
			Route::put('{id}', 'MessageController@update')->name('messages.update');
			Route::get('subject/{id}/edit', 'MessageController@editSubject')->name('messages.subject.edit');
			Route::post('subject/{id}/update', 'MessageController@updateSubject')->name('messages.subject.update');
			Route::post('users/search', 'MessageController@getUserList')->name('messages.users');
			Route::post('users/add', 'MessageController@addParticipant')->name('messages.users.add');
			Route::delete('users/{id}', 'MessageController@removeReceipent')->name('messages.users.remove');
			Route::delete('{id}', 'MessageController@destroy')->name('messages.destroy');

		});

	});

});

Route::group(['prefix' => 'back', 'namespace' => 'Backend'], function(){

	// Authentication Routes
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('back.login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('back.logout');

	// Registration Routes
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('back.register');
	Route::post('register', 'Auth\RegisterController@register');

	// Password Reset Routes
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('back.password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('back.password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('back.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('back.password.update');

	Route::get('home', 'HomeController@index')->name('back.home');

	// Administrators
	Route::resource('admins', 'AdminController', ['as' => 'back']);

	// Users
	Route::resource('users', 'UserController', ['as' => 'back']);
	Route::put('users/{id}/update/image', 'UserController@updateImage')->name('back.users.update.image');

});
