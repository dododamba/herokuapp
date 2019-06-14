<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   ModeFacturation
|
|
|
|*/



class ModeFacturation extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modefacturations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle', 'description','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function facturation_relation_ship()
    {
      return $this->belongsToMany(Partenaire::class,'');
    }

}
