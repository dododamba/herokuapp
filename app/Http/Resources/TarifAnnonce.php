<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   TarifAnnonce
|
|
|
|*/


class TarifAnnonce extends Resource
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

        'prix_image'=>$this->prix_image,'prix_caractere'=>$this->prix_caractere,'position'=>$this->position,'annoce'=>$this->annoce
        ,'slug'=>$this->slug
        ];
    }


}
