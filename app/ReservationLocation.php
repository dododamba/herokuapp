<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   ReservationLocation
|
|
|
|*/



class ReservationLocation extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservationlocations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [

        'date_reservation', 
        'date_validation', 
        'statut', 
        'date_debut',
         'date_fin', 
         'location', 
         'commentaire', 
       //  'note', ? 
         'client',
         'slug'
     ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getLocation()
    {
        return $this->belongsTo(Location::class,'location');
    }

    public function getClient()
    {
        return $this->belongsTo(Client::class,'client');
    }

    public function getCommentaire()
    {
       return $this->hasMany(Commentaire::class,'commentaire');
    }



}
