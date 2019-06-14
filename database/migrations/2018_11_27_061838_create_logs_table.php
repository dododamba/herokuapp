<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('logs', function(Blueprint $table) {
                $table->increments('id');
                $table->string('action')->nullable();
                $table->string('adresseIp')->nullable();
                $table->string('location')->nullable();
                $table->string('user')->nullable();
                $table->string('table')->nullable();
                $table->string('logger_token')->nullable();
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
        Schema::drop('logs');
    }

}
