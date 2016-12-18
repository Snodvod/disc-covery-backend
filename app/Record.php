<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Record extends Model
{
    protected $fillable = ['name', 'artist', 'year', 'image'];

    public function add()
    {
        DB::table('record_user')->insert([
            'record_id' => $this->id,
            'user_id'   => Auth::user()->id
        ]);
    }
}
