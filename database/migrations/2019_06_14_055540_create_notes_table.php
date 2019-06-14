<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Migration class   CreateNotesTable
|
|
|
|*/



class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('notes', function(Blueprint $table) {
                $table->increments('id');
                $table->string('message');
$table->integer('appreciation');
$table->integer('liker');
$table->string('owner_column');

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
        Schema::drop('notes');
    }

     /* --Generated with ❤ by Slugger ---*/

}
