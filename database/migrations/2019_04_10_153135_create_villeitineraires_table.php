<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateVilleitinerairesTable
|
|
|
|*/



class CreateVilleitinerairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('villeitineraires', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('rang');
                $table->boolean('escale');
                $table->unsignedInteger('ville');
                $table->unsignedInteger('itineraire');
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
        Schema::drop('villeitineraires');
    }


}
