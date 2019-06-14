<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Transaction
|
|
|
|*/



class Transaction extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'montant',
        'date_paiement',
        'numero_debiteur',
        'numero_beneficiaire',
        'resevation_voyage',
        'reservation_location',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getReservationVoyage()
    {
        return $this->belongsTo(ReservationVoyage::class,'resevation_voyage');
    }

    public function getReservationLocation()
    {
        return $this->belongsTo(ReservationLocation::class,'reservation_location');
    }
}
