<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateNotificationsTable
|
|
|
|*/



class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('notifications', function(Blueprint $table) {
                $table->increments('id');
                $table->string('contenue')->nullable();
                $table->date('date')->nullable();
                $table->string('description')->nullable();
                $table->string('lien')->nullable();
                $table->string('adresse_email')->nullable();
                $table->string('numero_destination')->nullable();
                $table->string('slug');
                $table->integer('type')->nullable();
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
        Schema::drop('notifications');
    }


}
