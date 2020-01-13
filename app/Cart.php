<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
    ];

    public function flowers() {
        return $this->belongsToMany('App\Flower')->withPivot('qty');
    }
}
