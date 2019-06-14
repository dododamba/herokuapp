<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Partenaire
|
|
|
|*/



class Partenaire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partenaires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_partenaire',
        'numero_tel',
        'adresse',
        'description',
        'site_web',
        'logo',
        'etat',
        'agence_principale',
        'utilisateur',
        'type_partenaire',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getAgencePrincipale()
    {
        return $this->belongsTo(Agence::class, 'agence_principale');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'utilisateur');
    }

    public function getAgence()
    {
        return $this->hasMany(Agence::class, 'partenaire');
    }

    public function getLocation()
    {
        return $this->hasMany(Location::class, 'partenaire');
    }
    public function getVoyage()
    {
        return $this->hasMany(Voyage::class, 'partenaire');
    }

    public function getAnnonce()
    {
        return $this->hasMany(Annonce::class, 'partenaire');
    }


}
