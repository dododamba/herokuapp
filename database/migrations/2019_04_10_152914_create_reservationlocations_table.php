<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateReservationlocationsTable
|
|
|
|*/



class CreateReservationlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('reservationlocations', function(Blueprint $table) {
                $table->increments('id');
                $table->date('date_reservation');
                $table->date('date_validation');
                $table->integer('statut');
                $table->date('date_debut')->nullable();
                $table->date('date_fin')->nullable();
                $table->text('commentaire')->nullable();
                $table->string('slug');
                $table->unsignedInteger('note')->nullable();
                $table->unsignedInteger('client')->nullable();
                $table->unsignedInteger('location');

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
        Schema::drop('reservationlocations');
    }


}
