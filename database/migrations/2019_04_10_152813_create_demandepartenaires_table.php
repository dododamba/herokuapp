<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateDemandepartenairesTable
|
|
|
|*/



class CreateDemandepartenairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('demandepartenaires', function(Blueprint $table) {
                $table->increments('id');
                $table->string('adresse')->nullable();
                $table->text('description')->nullable();
                $table->string('logo')->nullable();
                $table->boolean('etat')->nullable();
                $table->string('code_activation')->nullable();
                $table->string('slug')->nullable();
                $table->string('etat_traitement')->nullable();

                $table->unsignedInteger('type_partenaire')->nullable();
                $table->unsignedInteger('utilisateur')->nullable();

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
        Schema::drop('demandepartenaires');
    }


}
