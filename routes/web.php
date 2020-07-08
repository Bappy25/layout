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

	Route::get('/home', 'HomeController@home')->name('home');

});

Route::group(['prefix' => 'back', 'namespace' => 'Backend'], function(){

	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('back.login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('back.logout');

	// Registration Routes...
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('back.register');
	Route::post('register', 'Auth\RegisterController@register');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('back.password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('back.password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('back.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('back.password.update');

	// Email Verification Routes...
	Route::get('email/verify', 'Auth\VerificationController@show')->name('back.verification.notice');
	Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('back.verification.verify');
	Route::get('email/resend', 'Auth\VerificationController@resend')->name('back.verification.resend');

	Route::get('/home', 'HomeController@index')->name('back.home');

	// Administrators
	Route::resource('admins', 'AdminController', ['as' => 'back']);

	// Users
	Route::resource('users', 'UserController', ['as' => 'back']);
	Route::put('users/{id}/update/image', 'UserController@updateImage')->name('back.users.update.image');

});
