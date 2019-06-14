<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Image
|
|
|
|*/


class Image extends Resource
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
            'alt'=>$this->alt,
            'owner'=>$this->owner,
            'slug'=>$this->slug

        ];
    }


}
