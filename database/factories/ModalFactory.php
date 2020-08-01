<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Models\MessageSubject::class, function (Faker $faker) {
    return [
        'subject' => $faker->catchPhrase($maxNbChars = 5)
    ];
});

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Models\News::class, function (Faker $faker) {

    $adminIds = App\Models\Admin::all()->pluck('id')->toArray();

    return [
        'title' => $faker->catchPhrase($maxNbChars = 5),
        'tags' => "news, generated, for, testing, via, factory",
        'description' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'admin_id' => $faker->randomElement($adminIds),
    ];
});