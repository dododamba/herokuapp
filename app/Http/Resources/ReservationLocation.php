<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   ReservationLocation
|
|
|
|*/


class ReservationLocation extends Resource
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
            'date_reservation'=>$this->date_reservation,
            'date_validation'=>$this->date_validation,
            'statut'=>$this->statut,
            'date_debut'=>$this->date_debut,
            'date_fin'=>$this->date_fin,
                        'slug'=>$this->slug,
             /**
              *
              */
            'location'=>new Location($this->getLocation),
            'commentaire'=>new Commentaire($this->getCommentaire),
           // 'note'=>$this->note,
            'client'=>new Client($this->getClient),
             /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),
        ];
    }


}
