<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'courier_id',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function courier() {
        return $this->belongsTo('App\Courier');
    }

    public function flowers() {
        return $this->belongsToMany('App\Flower')->withPivot('qty');
    }
}
