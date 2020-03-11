<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vendor;
use App\User;
use Faker\Generator as Faker;

$factory->define(Vendor::class, static function (Faker $faker) {
    return [
        'user_id' => User::pluck('id')->random(),
        'vendor_avatar' => 'vendor_tmp.png',
        'title' => $faker->jobTitle,
        'short_description' => $faker->paragraph(rand(3,5), true),
        'description' => $faker->paragraph(rand(10,20), true),
        'street_address' => $faker->streetAddress,
        'phone_number' => $faker->phoneNumber,
        'postal_code' => $faker->postcode,
        'owner' => $faker->name,
        'date_established' => $faker->date(),
        'is_active' => rand(0,1),
    ];
});
