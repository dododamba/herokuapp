<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClasseVoyage extends Model
{



    protected  $table = 'classe_voyages';


    protected  $fillable = [
        'prix_adulte',
        'prix_enfant',
        'voyage',
        'classe',
        'slug'
    ];

    use SoftDeletes;


}
