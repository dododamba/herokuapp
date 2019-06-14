<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateDecoupagedeuxesTable
|
|
|
|*/



class CreateDecoupagedeuxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('decoupagedeux', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('libelle');
                $table->unsignedInteger('decoupage_un')->nullable();
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
        Schema::drop('decoupagedeux');
    }


}
