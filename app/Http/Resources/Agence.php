<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Agence
|
|
|
|*/


class Agence extends Resource
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
            'libelle' => $this->libelle,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'contact' => $this->contact,
            'adresse' => $this->adresse,
            'email' => $this->email,
            'slug' => $this->slug,
            /**
             * Relation handling
             */
            'ville' => new Ville($this->getVille),
            'partenaire' => new Partenaire($this->getPartenaire),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),
        ];
    }


}
