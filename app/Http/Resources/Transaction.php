<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Transaction
|
|
|
|*/


class Transaction extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'montant'=>$this->montant,
            'date_paiement'=>$this->date_paiement,
            'numero_debiteur'=>$this->numero_debiteur,
            'numero_beneficiaire'=>$this->numero_beneficiaire,
            'slug'=>$this->slug,
            /**
             * Relation handling
             */
            'resevation_voyage'=>new ReservationVoyage($this->getResevationVoyage),
            'reservation_location'=>new ReservationLocation($this->getReservationLocation),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
