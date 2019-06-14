<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateCommentairesTable
|
|
|
|*/



class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('commentaires', function(Blueprint $table) {
                $table->increments('id');
                $table->text('contenu');
                $table->string('slug');

                $table->unsignedInteger('utilisateur');
                $table->string('owner_colomn');

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
        Schema::drop('commentaires');
    }


}
