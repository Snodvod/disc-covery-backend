<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Record extends Model
{
    public function add()
    {
        DB::table('record_user')->insert([
            'record_id' => $this->id,
            'user_id'   => Auth::user()->id
        ]);
    }
}
