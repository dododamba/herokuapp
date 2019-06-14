<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Migration class   CreateTransactionsTable
|
|
|
|*/



class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('transactions', function(Blueprint $table) {
                $table->increments('id');
                $table->float('montant');
                $table->date('date_paiement');
                $table->string('numero_debiteur');
                $table->string('numero_beneficiaire');
                $table->unsignedInteger('reservation_voyage')->nullable();
                $table->unsignedInteger('reservation_location')->nullable();

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
        Schema::drop('transactions');
    }


}
