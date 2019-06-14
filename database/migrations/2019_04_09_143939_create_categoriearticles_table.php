<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateCategoriearticlesTable
|
|
|
|*/



class CreateCategoriearticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('categoriearticles', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('description')->nullable();
                $table->unsignedInteger('ajoute_par')->nullable();
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
        Schema::drop('categoriearticles');
    }


}
