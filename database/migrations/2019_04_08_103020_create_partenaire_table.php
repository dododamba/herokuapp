<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartenaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partenaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_partenaire');
            $table->string('adresse');
            $table->text('description')->nullable(true);
            $table->string('site_web')->nullable(true);
            $table->string('logo')->nullable(true);
            $table->string('numero_tel')->nullable(true);
            $table->integer('etat');
            $table->string('nom_partenaire');

            $table->string('code_activation')->nullable();
            $table->unsignedInteger('agence_principale')->nullable();
            $table->unsignedInteger('utilisateur')->nullable();

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
        Schema::dropIfExists('partenaire');
    }
}
