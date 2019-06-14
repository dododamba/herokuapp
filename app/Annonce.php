<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Annonce
|
|
|
|*/



class Annonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'annonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [


        'titre', 
        'contenue',
        'dateDebut',
        'dateFin', 
        'prix',
        'slug', 
        'nombreCaratere', 
        'position', 
        'etat', 
        'date_validation', 
        'utilisateur',
        'partenaire',
        'valider_par'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getTransaction()
    {
        return $this->hasOne(Transaction::class,'transaction');
    }

    public function getUtilisateur()
    {
        return $this->belongsTo(Utilisateur::class,'utilisateur');
    }

    public function getImage()
    {
        return $this->hasMany(Image::class,'owner');
    }

    public function getPosition()
    {
        return $this->belongsTo(PositionAnnonce::class,'position');
    }

    public function getPartenaire()
    {
        return $this->belongsTo(Partenaire::class,'position');
    }

    public function getValidateur()
    {
        return $this->belongsTo(Personnel::class,'position');
    }

    public function getTypeAnnonce()
    {
        return $this->belongsTo(TypeAnnonce::class,'position');
    }

}
