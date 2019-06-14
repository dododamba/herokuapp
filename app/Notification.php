<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Notification
|
|
|
|*/



class Notification extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenue',
        'date',
        'description',
        'lien',
        'adresse_email',
        'numero_destination',
        'type',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

  


}
