<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

use App\Http\Resources\Role as RoleResource;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   User
|
|
|
|*/


class User extends Resource
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
            'id' =>$this->id,
            'email' =>$this->email,
            'slug' =>$this->slug,
            'langue'=>$this->langue,
            'telephone' => $this->telephone,
            'last_login' =>Carbon::parse($this->last_login)->format('d-m-y'),	
            'user_role'	 =>new RoleResource($this->getUserRole),
            'is_active'=>new ActivationResource($this->isActive),
            'created_at' =>Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' =>Carbon::parse($this->updated_at)->format('d-m-y')
        ];
    }


}
