<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Pay
|
|
|
|*/


class Pays extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pays';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso',
        'name',
        'numcode',
        'nicename',
        'iso3',
        'phonecode'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getDeoupageUn()
    {
        return $this->hasMany(DecoupageUn::class, 'pays');
    }

    public function getVille()
    {
        return $this->hasMany(Ville::class, 'pays');
    }
}
