<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   VilleItineraire
|
|
|
|*/


class VilleItineraire extends Resource
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

        'rang'=>$this->rang,'ville'=>$this->ville,'itineraire'=>$this->itineraire,'escale'=>$this->escale,'slug'=>$this->slug

        ];
    }


}
