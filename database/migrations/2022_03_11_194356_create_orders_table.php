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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('article_code')->default(0);
            $table->string('article_name')->default(0);
            $table->float('unit_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('order_code')->unique()->nullable(true);
            $table->string('order_date')->nullable(true);
            $table->float('total_amount_without_discount')->nullable(true);
            $table->float('total_amount_with_discount')->nullable(true);
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
        Schema::dropIfExists('orders');
    }
};
