<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasseVoyageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classe_voyages', function (Blueprint $table) {
            $table->increments('id');
            $table->float('prix_adulte')->nullable(true);
            $table->float('prix_enfant')->nullable(true);
            $table->unsignedInteger('voyage');
            $table->unsignedInteger('classe');
            $table->string('slug');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classe_voyages');
    }
}
