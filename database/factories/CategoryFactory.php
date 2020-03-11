<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph(rand(3,5). true)
    ];
});
