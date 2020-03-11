<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use App\Vendor;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, static function (Faker $faker) {
    $name = $faker->name;
    return [
        'vendor_id' => Vendor::pluck('id')->random(),
        'supplier_id' => Vendor::pluck('id')->random(),
        'category_id' => Category::pluck('id')->random(),
        'product_avatar' => 'product_tmp.png',
        'name' => $name,
        'short_description' => $faker->paragraph(rand(3,5)),
        'full_description' => $faker->paragraph(rand(5,10), true),
        'slug' => Str::slug($name),
        'price' => rand(500, 10000),
        'qty' => rand(50,100),
        'unit' => $faker->sentence,
    ];
});
