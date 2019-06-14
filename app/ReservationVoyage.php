<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Reservation Voyage
|
|
|
|*/



class ReservationVoyage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservationvoyages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_reservation', 
        'date_validation', 
        'dateVoyage', 
        'statut', 
        'nom_voyageur', 
        'client',
        'slug',
        'voyage'
      ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVoyage()
    {
        return $this->belongsTo(Voyage::class,'voyage');
   }

    public function getClient()
    {
        return $this->belongsTo(Client::class);
   }

}
