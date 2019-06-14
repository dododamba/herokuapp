<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   DemandePartenaire
|
|
|
|*/


class DemandePartenaire extends Resource
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
            'adresse'=>$this->adresse,
            'description'=>$this->description,
            'logo'=>$this->logo,'etat'=>$this->etat,
            'code_activation'=>$this->code_activation,
            'type_partenaire'=>$this->type_partenaire,
            'etat_traitement'=>$this->etat_traitement,
            'slug'=>$this->slug,

            /**
             * Relation handling
             */
            'utilisateur'=>new User($this->getUtilisateur),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),


        ];
    }


}
