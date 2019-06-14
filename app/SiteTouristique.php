<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   SiteTouristique
|
|
|
|*/



class SiteTouristique extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sitetouristiques';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'longitude',
        'latitude',
        'description',
        'etat',
        'ville',
        'decoupage_trois',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getDecoupageTrois()
    {

        return $this->belongsTo(DecoupageTrois::class,'decoupage_trois');
    }

}
