<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Voyage
|
|
|
|*/



class Voyage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'voyages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero',
        'date_depart',
        'description',
        'nombre_place',
        'moyen_transport',
        'slug',
        'etat',
        'itineraire',
        'image',
        'duree',
        'partenaire',
        'valider_par'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

   public function getClasse()
   {
     return $this->belongsToMany(Classe::class,'');
   }

   /* public function getItineraire()
    {
        return $this->hasMany(Itineraire::class,'');
    }
*/
    public function getImage()
    {
        return $this->hasMany(Image::class,'owner');
    }

    public function getPartenaire()
    {
        return $this->belongsTo(Partenaire::class,'partenaire');
    }

    public function getValiderPar()
    {
        return $this->belongsTo(Personnel::class,'valider_par');
    }
}
