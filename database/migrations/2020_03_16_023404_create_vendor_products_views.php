<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVendorProductsViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE OR REPLACE VIEW vendorProducts AS
            select products.*, categories.name as catName, vendors.id as venId
            from vendors
                 inner join products on products.vendor_id = vendors.id
                 inner join users on vendors.user_id = users.id
                 inner join categories on products.category_id = categories.id
            group by products.id, categories.name, vendors.id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW vendorProducts');
    }
}
