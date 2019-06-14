<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateSharesTable
|
|
|
|*/


class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shared_on');
            $table->string('shared_item');
            $table->integer('sharer');
            $table->string('slug');

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
        Schema::drop('shares');
    }

    /* --Generated with ❤ by Slugger ---*/

}
