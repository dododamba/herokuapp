<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   DecoupageUn
|
|
|
|*/


class DecoupageUn extends Resource
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
            'nom' => $this->nom,
            'libelle' => $this->libelle,
            'cheflieu' => $this->cheflieu,
            'slug' => $this->slug,

            /**
             * Relation handling
             */
            'pays' => new Pays($this->getPays),
            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),


        ];
    }


}
