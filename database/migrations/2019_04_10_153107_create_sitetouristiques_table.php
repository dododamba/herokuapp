<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateSitetouristiquesTable
|
|
|
|*/



class CreateSitetouristiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('sitetouristiques', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nom');
                $table->string('longitude')->nullable();
                $table->string('latitude')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('etat')->nullable();
                $table->unsignedInteger('personnel')->nullable();
                $table->unsignedInteger('ville')->nullable();
                $table->unsignedInteger('decoupage_trois')->nullable();

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
        Schema::drop('sitetouristiques');
    }


}
