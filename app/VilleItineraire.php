<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   VilleItineraire
|
|
|
|*/



class VilleItineraire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'villeitineraires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rang', 'ville', 'itineraire', 'escale','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



}
