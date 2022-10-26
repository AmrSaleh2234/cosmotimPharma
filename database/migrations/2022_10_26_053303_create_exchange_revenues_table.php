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
        Schema::create('exchange_revenues', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('fk');
            $table->tinyInteger('type');//1=>supplier 2=>customer 3=>supplier_invoice 4=>customer_invoice 5=>employee 6=>capital 7=>gift
            $table->decimal('amount');
            $table->integer('com_code');
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
        Schema::dropIfExists('exchange_revenues');
    }
};
