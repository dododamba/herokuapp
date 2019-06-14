<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Commentaire
|
|
|
|*/


class Commentaire extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contenu' => $this->contenu,
            'slug' => $this->slug,
            /**
             * Relation handling
             */
            'utilisateur' => new Client($this->getUtilisateur),
            'article' => new Article($this->getArticle),
             /**
              * Timestamp
              */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
