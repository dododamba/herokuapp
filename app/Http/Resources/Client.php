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
| Resource   Client
|
|
|
|*/


class Client extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'sexe' => $this->sexe,
            'slug' => $this->slug,
            'date_naissance' => Carbon::parse($this->date_naissance)->format('d-m-y'),
            'compte' => new UserResource($this->getUser)
            
        ];
    }

    
}
