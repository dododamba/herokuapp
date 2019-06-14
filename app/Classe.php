<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Classe
|
|
|
|*/



class Classe extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle','slug', 'description'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVoyage()
    {
        return $this->belongsToMany(Voyage::class,'classe_voyage');
    }
   


}
