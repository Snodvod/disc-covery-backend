<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Auth;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password',];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token',];

	public function messages() { return $this->belongsToMany('App\Messages'); }

	protected function search($query)
    {
        return self::where('firstname', 'LIKE', '%'.$query.'%')
            ->orWhere('lastname', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->get();
	}

	public function follow()
    {
		DB::table('following')->insert([
			'follower_id'   => Auh::user()->id,
			'following_id'  => $this->id
		]);
	}

	public function unfollow()
    {
        DB::table('following')->where([
            'follower_id'   => Auh::user()->id,
            'following_id'  => $this->id
        ])->delete();
    }

    public function findByRecord($record_id)
    {
        return self::join('record_user', 'record_user.user_id', 'users.id')
                    ->join('following', 'following.following_id', 'users.id')
                    ->where('record_user.record_id', $record_id)
                    ->where('following.follower_id', $this->id)
                    ->get();
    }
}
