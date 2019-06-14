<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Decoupage Un
|
|
|
|*/



class DecoupageUn extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'decoupageuns';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'libelle',
        'pays',
        'cheflieu',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getPays()
    {
        return $this->belongsTo(Pays::class,'pays');
    }


    public function getDecoupageDeux()
    {
        return $this->hasMany(DecoupageDeux::class,'decoupage_un');
    }
    



}
