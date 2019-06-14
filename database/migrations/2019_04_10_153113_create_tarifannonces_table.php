<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateTarifannoncesTable
|
|
|
|*/



class CreateTarifannoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('tarifannonces', function(Blueprint $table) {
                $table->increments('id');
                $table->float('prix_image');
                $table->float('prix_caractere');
                $table->string('slug');
                $table->unsignedInteger('position')->nullable();
                $table->unsignedInteger('type_annonce')->nullable();

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
        Schema::drop('tarifannonces');
    }


}
