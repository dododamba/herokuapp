<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateBilletsTable
|
|
|
|*/



class CreateBilletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('billets', function(Blueprint $table) {
                $table->increments('id');
                $table->string('code_barre');
                $table->string('slug')->nullable();
                $table->boolean('validite');
                $table->unsignedInteger('reservation_voyage')->nullable();
                $table->unsignedInteger('reservation_location')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('billets');
    }


}
