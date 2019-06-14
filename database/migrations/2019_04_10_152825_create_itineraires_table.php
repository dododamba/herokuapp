<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateItinerairesTable
|
|
|
|*/



class CreateItinerairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('itineraires', function(Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('ville_depart');
                $table->unsignedInteger('ville_arrivee');
                $table->text('description')->nullable(true);
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
        Schema::drop('itineraires');
    }


}
