<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Ville
|
|
|
|*/



class Ville extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'villes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'pays','slug','decoupage_un'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getVilleItinetaire()
    {
      return $this->belongsToMany(Itineraire::class,'villeitineraires');
    }


      public function getPays()
      {
        return $this->belongsTo(Pays::class,'pays');
      }

    public function getDecoupageUn()
    {
        return $this->belongsTo(DecoupageUn::class,'decoupage_un');
    }

}
