<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Share
|
|
|
|*/



class Share extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shares';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['shared_on', 'shared_item', 'sharer', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getSharedItem($related,$ownerKey)
    {
        return $this->belongsTo($related,'shared_item',$ownerKey);
    }
 /* --Generated with ❤ by Slugger ---*/


}
