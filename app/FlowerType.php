<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowerType extends Model
{
    protected $table = 'flower_types';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
