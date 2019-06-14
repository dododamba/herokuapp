<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   ReservationVoyage
|
|
|
|*/


class ReservationVoyage extends Resource
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
        'date_reservation'=>$this->date_reservation,
        'date_validation'=>$this->date_validation,
        'dateVoyage'=>$this->dateVoyage,
        'statut'=>$this->statut,
        'nom_voyageur'=>$this->nom_voyageur,
        'slug'=>$this->slug,

        'voyage' => new Voyage($this->getVoyage),
        'client' => new Client($this->getClient),

             /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
