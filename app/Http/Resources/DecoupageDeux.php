<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   DecoupageDeux
|
|
|
|*/


class DecoupageDeux extends Resource
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
             'nom'=>$this->nom,
            'libelle'=>$this->libelle,
            'slug'=>$this->slug,
            /**
             * Relation handling
             */
            'decoupage_un'=>new DecoupageUn($this->getDecoupageUn),
             /**
              * Timestamp
              */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
