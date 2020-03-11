<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('supplier_id');
            $table->smallInteger('category_id');
            $table->text('product_avatar');
            $table->string('name');
            $table->text('short_description');
            $table->text('full_description');
            $table->string('slug');
            $table->double('price');
            $table->bigInteger('qty');
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
