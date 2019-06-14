<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   TypeAnnonce
|
|
|
|*/



class TypeAnnonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'typeannonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



}
