<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->paragraph(rand(3,5), false),
        'contact_name' => $faker->name,
        'contact_number' => $faker->phoneNumber
    ];
});
