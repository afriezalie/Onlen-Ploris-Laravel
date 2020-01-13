<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'type_id', 'price', 'description', 'stock', 'image',
    ];

    public function type() {
        return $this->belongsTo('App\FlowerType');
    }
}