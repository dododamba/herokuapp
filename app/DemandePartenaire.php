<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   DemandePartenaire
|
|
|
|*/



class DemandePartenaire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'demandepartenaires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'adresse',
        'description',
        'slug',
        'logo',
        'etat',
        'code_activation',
        'type_partenaire',
        'etat_traitement',
        'utilisateur'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getUtilisateur()
    {
        return $this->belongsTo(Utilisateur::class,'utilisateur');
    }

}
