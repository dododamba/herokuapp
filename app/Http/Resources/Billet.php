<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Billet
|
|
|
|*/


class Billet extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $reque st
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code_barre'=>$this->code_barre,
            'validite'=>$this->validite,
            'slug'=>$this->slug,
            /**
             * Relation handling
             */
            'reservation_voyage'=>new ReservationVoyage($this->getReservationVoyage),
            'resevation_location'=>new ReservationLocation($this->getReservationLocation),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
