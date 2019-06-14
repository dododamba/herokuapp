<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateDecoupageunsTable
|
|
|
|*/



class CreateDecoupageunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('decoupageuns', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('libelle');
                $table->unsignedInteger('pays')->nullable();
                $table->unsignedInteger('cheflieu')->nullable();
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
        Schema::drop('decoupageuns');
    }


}
