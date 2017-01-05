<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['name', 'duration', 'spotify_id'];
    public $timestamps = false;

    public function records()
    {
        return $this->belongsToMany('App\Record');
    }
}