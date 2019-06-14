<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateVoyagesTable
|
|
|
|*/



class CreateVoyagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('voyages', function(Blueprint $table) {
                $table->increments('id');
                $table->string('numero')->nullable(true);
                $table->dateTime('date_depart')->nullable(true);

                $table->text('description')->nullable(true);
                $table->string('slug')->nullable(true);
                $table->unsignedInteger('nombre_place')->nullable(true);
                $table->unsignedInteger('moyen_transport')->nullable(true);
                $table->unsignedInteger('etat')->nullable(true);
                $table->time('duree')->nullable(true);

                $table->unsignedInteger('image')->nullable(true);
                $table->unsignedInteger('itineraire')->nullable(true);
                $table->unsignedInteger('partenaire')->nullable(true);
                $table->unsignedInteger('valider_par')->nullable(true);

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
        Schema::drop('voyages');
    }


}
