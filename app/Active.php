<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Active extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','user','completed_at'];

  
}
