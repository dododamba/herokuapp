<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Commentaire
|
|
|
|*/



class Commentaire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'commentaires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenu',
        'utilisateur',
        'slug',
        'owner_colomn'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getArticle()
    {
        return $this->belongsTo(Article::class,'article');
    }

    public function getUtilsateur()
    {
       return $this->belongsTo(Article::class,'utilisateur');
    }

}
