<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateLocationsTable
|
|
|
|*/



class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('locations', function(Blueprint $table) {
                $table->increments('id');
                $table->string('titre')->nullable();
                $table->text('description')->nullable();
                $table->date('date_debut_disponibilite')->nullable();
                $table->date('date_fin_disponibilite')->nullable();
                $table->unsignedInteger('etat');
                $table->string('slug');

                $table->unsignedInteger('valider_par')->nullable();
                $table->unsignedInteger('partenaire')->nullable();

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
        Schema::drop('locations');
    }


}
