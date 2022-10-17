<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('address');

//            <option value="1" >راس مال</option>
//                                        <option value="2" > موردين</option>
            //                                        <option value="3" > العملاء</option>
//                                        <option value="4" >موظفين</option
            //                                        <option value="5" >مصروفات</option>
            $table->integer('balance_status');//1=> would get 2=>done 3=> must pay
            $table->decimal('balance');
            $table->integer('start_balance_status');//1=> would get 2=>done 3=> must pay
            $table->decimal('start_balance');
            $table->integer('discount');
            $table->integer('com_code');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('active')->default(1);// 1 is active 0 not active
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
        Schema::dropIfExists('customers');
    }
};
