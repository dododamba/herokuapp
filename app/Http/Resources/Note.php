<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Note
|
|
|
|*/


class Note extends Resource
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
            'appreciation'=>$this->appreciation,
            'message'=>$this->message,
            'slug'=>$this->slug,

            /**
             * Relation handling
             */
            'voyage'=>new Voyage($this->getVoyage),
            'agence'=>new Agence($this->getAgence),
            'client'=>new Client($this->getUtilisateur),

            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),


        ];
    }


}
