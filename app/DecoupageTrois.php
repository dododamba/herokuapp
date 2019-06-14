<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   DecoupageTrois
|
|
|
|*/



class DecoupageTrois extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'decoupagetrois';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'libelle',
        'decoupage_deux',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getDecoupageDeux()
    {
      return $this->belongsTo(DecoupageDeux::class,'decoupage_deux');
    }

}
