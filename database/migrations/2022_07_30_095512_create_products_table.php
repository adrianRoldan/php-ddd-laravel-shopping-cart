<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string("name");
            $table->string("description");
            $table->float("priceAmount");
            $table->float("priceWithDiscountAmount");
            $table->char("priceCurrency", 3);
            $table->smallInteger('minForDiscount');
            $table->integer('createdAt');
            $table->integer('updatedAt');
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
};
