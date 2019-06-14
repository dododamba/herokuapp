<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Itineraire
|
|
|
|*/



class Itineraire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'itineraires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ville_depart',
        'ville_arrivee',
        'description',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVilleArrive()
    {
        return $this->hasOne(Ville::class,'ville_arrive');
    }

    public function getVilleDepart()
    {
        return $this->hasOne(Ville::class,'ville_depart');

    }



}
