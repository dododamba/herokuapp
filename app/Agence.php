<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Agence
|
|
|
|*/



class Agence extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agences';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'longitude',
        'latitude',
        'contact',
        'slug',
        'adresse',
        'email',
        'ville',
        'partenaire'
     ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getPartenaire()
    {
        return $this->belongsTo(Partenaire::class,'partenaire');
    }

    public function getVille()
    {
        return $this->belongsTo(Ville::Class,'ville');
    }

    
}
