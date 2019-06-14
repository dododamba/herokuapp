<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Location
|
|
|
|*/



class Location extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'date_debut_disponibilite',
        'slug',
        'date_fin_disponibilite',
        'etat',
        'valider_par',
        'partenaire'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getPartenaire()
    {
        return $this->belongsTo(Partenaire::class,'partenaire');
    }

    public function getImage()
    {
      return $this->belongsToMany(Image::class,'');
    }

    public function getValiderPar()
    {
        return $this->belongsTo(Personnel::class,'valider_par');
    }
}
