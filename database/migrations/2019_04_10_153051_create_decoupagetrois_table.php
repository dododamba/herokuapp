<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateDecoupagetroisTable
|
|
|
|*/



class CreateDecoupagetroisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('decoupagetrois', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('libelle');
                $table->unsignedInteger('decoupage_deux')->nullable();

                $table->string('slug')->nullable();

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
        Schema::drop('decoupagetrois');
    }


}
