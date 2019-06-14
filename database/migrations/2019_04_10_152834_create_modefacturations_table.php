<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateModefacturationsTable
|
|
|
|*/



class CreateModefacturationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('modefacturations', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle');
                $table->text('description')->nullable();
                $table->unsignedInteger('code')->nullable();
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
        Schema::drop('modefacturations');
    }


}
