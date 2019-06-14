<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User as UserResource;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Personnel
|
|
|
|*/


class Personnel extends Resource
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
                'id' =>$this->id,
                'nom'=>$this->nom,
                'prenom'=>$this->prenom,
                'sexe'=>$this->sexe,
                'date_embauche'=>Carbon::parse($this->date_embauche)->format('d-m-y'),
                'etat'=>$this->etat,
                'date_naissance'=>Carbon::parse($this->date_naissance)->format('d-m-y'),
                'matricule'=>$this->matricule,
                'slug'=>$this->slug,
                'compte' => new UserResource($this->getUser)
               
        ];
    }


}
