<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Admin
|
|
|
|*/

class Admin extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom','prenom','sexe','slug','user_id','date_naissance'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getUser()
    {
       return $this->belongsTo(User::class,'user_id');
    }

}
