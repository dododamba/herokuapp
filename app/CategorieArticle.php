<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   CategorieArticle
|
|
|
|*/



class CategorieArticle extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categoriearticles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
        'slug',
        'ajoute_par'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getArticle()
    {
      return $this->hasMany(Article::class,'categorie');
    }

    public function getAjouterPar()
    {
        return $this->belongsTo(Personnel::class,'ajoute_par');
    }



}
