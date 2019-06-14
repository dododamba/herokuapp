<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Billet
|
|
|
|*/



class Billet extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'billets';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_barre',
        'validite',
        'slug',
        'reservation_voyage',
        'resevation_location'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getResevationVoyage()
    {
        return $this->belongsTo(ReservationVoyage::class, 'reservation_voyage');
    }

    public function getReservationLocation()
    {
        return $this->belongsTo(ReservationLocation::class, 'resevation_location');
    }




}
