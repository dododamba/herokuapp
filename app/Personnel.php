<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Personnel
|
|
|
|*/



class Personnel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personnels';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'prenom', 'date_embauche', 'sexe', 'date_naissance', 'matricule','user_id','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getUser()
    {
       return $this->belongsTo(User::class,'user_id');
    }

}
