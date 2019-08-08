<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'email_verified_at' => now(),
        'password' => '$2y$10$IsDKvEVI2mHroUj9sHAaTeBZNaTH5gCWz05hbRMTeRxJsxe2N1V2W', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Models\Admin::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'email_verified_at' => now(),
        'password' => '$2y$10$IsDKvEVI2mHroUj9sHAaTeBZNaTH5gCWz05hbRMTeRxJsxe2N1V2W', // password
        'remember_token' => Str::random(10),
    ];
});

