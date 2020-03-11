<?php

use App\Category;
use App\Product;
use App\Supplier;
use App\User;
use App\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('suppliers')->truncate();
        DB::table('categories')->truncate();
        DB::table('vendors')->truncate();
        DB::table('products')->truncate();

        // $this->call(UsersTableSeeder::class);
        factory(Supplier::class, 50)->create();
        factory(Category::class, 20)->create();
        factory(User::class, 50)->create();
        factory(Vendor::class, 50)->create()->each(static function($v) {
            $v->products()->saveMany(factory(Product::class, rand(1,10))->make());
        });
    }
}
