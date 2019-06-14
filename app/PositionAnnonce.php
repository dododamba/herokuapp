<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   PositionAnnonce
|
|
|
|*/



class PositionAnnonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'positionannonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



}
