<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Voyage
|
|
|
|*/


class Voyage extends Resource
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

        'numero'=>$this->numero,'date_depart'=>$this->date_depart,'date_arrive'=>$this->date_arrive,'description'=>$this->description,'nombre_place'=>$this->nombre_place,'moyen_transport'=>$this->moyen_transport,'etat'=>$this->etat,'itineraire'=>$this->itineraire,'image'=>$this->image,'utilisateur'=>$this->utilisateur,'partenire'=>$this->partenire,'personnel'=>$this->personnel
         ,'slug'=>$this->slug
        ];
    }


}
