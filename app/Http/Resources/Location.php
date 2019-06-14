<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Location
|
|
|
|*/


class Location extends Resource
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
            'titre'=>$this->titre,
            'description'=>$this->description,
            'date_debut_disponibilite'=>$this->date_debut_disponibilite,
            'date_fin_disponibilite'=>$this->date_fin_disponibilite,
            'etat'=>$this->etat,
            'slug'=> $this->slug,
            /**
             * Relation handling
             */
             'valider_par'=> new Personnel($this->getValiderPar),
             'image'=>new Image($this->getImage),
             'partenaire' => new Partenaire($this->getPartenaire),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
