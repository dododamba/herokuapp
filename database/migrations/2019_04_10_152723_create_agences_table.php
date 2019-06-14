<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateAgencesTable
|
|
|
|*/



class CreateAgencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('agences', function(Blueprint $table) {
                $table->increments('id');
                $table->string('libelle')->nullable(true);
                $table->string('longitude')->nullable(true);
                $table->string('latitude')->nullable(true);
                $table->string('contact')->nullable(true);
                $table->string('adresse')->nullable(true);
                $table->string('email')->nullable(true);
                $table->string('slug')->nullable(true);

                $table->unsignedInteger('ville');
                $table->unsignedInteger('partenaire');

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
        Schema::drop('agences');
    }


}
