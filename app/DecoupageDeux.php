<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   DecoupageDeux
|
|
|
|*/



class DecoupageDeux extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'decoupagedeuxes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'libelle', 'decoupage_un','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getDecoupageUn()
    {
        return $this->belongsTo(DecoupageUn::class,'decoupage_un');
    }

    public function getDecoupageTrois()
    {
        return $this->hasMany(DecoupageTrois::class,'decoupage_deux');
    }

}
