<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Itineraire
|
|
|
|*/


class Itineraire extends Resource
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
            'description'=>$this->description,
            'slug'=>$this->slug,
            /**
             * Relation handling
             */
            'ville_depart'=>new Ville($this->getVilleDepart),
            'ville_arrivee'=>new Ville($this->getVilleArrivee),

            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
