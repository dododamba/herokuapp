<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Like
|
|
|
|*/



class Like extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'likes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user','liked_item', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getLikedItem($related,$ownerKey)
    {
        return $this->belongsTo($related,'liked_item',$ownerKey);
    }

    /* --Generated with ❤ by Slugger ---*/


}
