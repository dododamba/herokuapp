<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   PositionAnnonce
|
|
|
|*/


class PositionAnnonce extends Resource
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
             'libelle'=>$this->libelle,
             'slug'=>$this->slug
             /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),
        ];
    }


}
