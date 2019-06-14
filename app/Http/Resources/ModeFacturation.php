<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   ModeFacturation
|
|
|
|*/


class ModeFacturation extends Resource
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
            'libelle'=>$this->libelle,
            'description'=>$this->description,
            'slug'=>$this->slug

        ];
    }


}
