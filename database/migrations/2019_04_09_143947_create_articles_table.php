<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateArticlesTable
|
|
|
|*/



class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('articles', function(Blueprint $table) {
                $table->increments('id');
                $table->string('titre')->nullable();
                $table->text('contenu')->nullable();
                $table->integer('categorie')->nullable();
                $table->unsignedInteger('etat')->nullable();
                $table->unsignedInteger('user')->nullable();
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
        Schema::drop('articles');
    }


}
