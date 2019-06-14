<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Categorie
|
|
|
|*/


class Categorie extends Resource
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

        'nom'=>$this->nom,'description'=>$this->description,'slug'=>$this->slug

        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
