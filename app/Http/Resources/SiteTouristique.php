<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   SiteTouristique
|
|
|
|*/


class SiteTouristique extends Resource
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
            'nom'=>$this->nom,
            'longitude'=>$this->longitude,
            'latitude'=>$this->latitude,
            'description'=>$this->description,
            'etat'=>$this->etat,'ville'=>$this->ville,
            'slug'=>$this->slug,
            /**
             * Relation handling
             */
            'decoupage_trois'=> new DecoupageTrois($this->getDeoupageTrois),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
