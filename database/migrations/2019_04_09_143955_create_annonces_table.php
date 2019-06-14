<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateAnnoncesTable
|
|
|
|*/



class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('annonces', function(Blueprint $table) {
                $table->increments('id');
                $table->string('titre')->nullable(true);
                $table->string('contenue')->nullable(true);
                $table->dateTime('dateDebut')->nullable(true);
                $table->dateTime('dateFin')->nullable(true);
                $table->float('prix')->nullable(true);
                $table->unsignedInteger('nombreCaratere')->nullable(true);
                $table->unsignedInteger('position')->nullable(true);
                $table->unsignedInteger('etat')->nullable(true);
                $table->date('date_validation')->nullable(true);
                $table->integer('utilisateur')->nullable(true);
                $table->integer('transaction')->nullable(true);
                $table->unsignedInteger('image')->nullable(true);
                $table->unsignedInteger('type_annonce')->nullable(true);
                $table->unsignedInteger('partenaire')->nullable(true);
                $table->unsignedInteger('valider_par')->nullable(true);
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
        Schema::drop('annonces');
    }


}
