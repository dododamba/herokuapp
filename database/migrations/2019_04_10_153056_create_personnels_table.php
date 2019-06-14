<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreatePersonnelsTable
|
|
|
|*/



class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('personnels', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('prenom');
                $table->date('date_embauche')->nullable();
                $table->date('date_naissance')->nullable();
                $table->string('matricule')->nullable();
                $table->string('sexe')->nullable();
                $table->string('telephone')->nullable();
                $table->string('slug');
                $table->unsignedInteger('user_id')->nullable();
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
        Schema::drop('personnels');
    }


}
