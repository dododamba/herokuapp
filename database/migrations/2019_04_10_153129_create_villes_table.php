<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateVillesTable
|
|
|
|*/



class CreateVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('villes', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->unsignedInteger('pays');
                $table->unsignedInteger('decoupage_un');

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
        Schema::drop('villes');
    }


}
