<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   TarifAnnonce
|
|
|
|*/



class TarifAnnonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tarifannonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prix_image',
        'prix_caractere',
        'position',
        'annoce',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



}
