<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreatePositionannoncesTable
|
|
|
|*/



class CreatePositionannoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('positionannonces', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle');
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
        Schema::drop('positionannonces');
    }


}
