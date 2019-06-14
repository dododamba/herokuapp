<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Notification
|
|
|
|*/


class Notification extends Resource
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

        'contenue'=>$this->contenue,'date'=>$this->date,'description'=>$this->description,'lien'=>$this->lien,'adresse_email'=>$this->adresse_email,'numero_destination'=>$this->numero_destination,'type'=>$this->type,'slug'=>$this->slug

        ];
    }


}
