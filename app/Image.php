<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Image
|
|
|
|*/



class Image extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'alt', 'owner','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function annonce()
    {
      return $this->belongsTo(Annonce::class,'owner');
    }


}
