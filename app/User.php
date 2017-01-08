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
	protected $fillable = ['firstname', 'lastname', 'email', 'image', 'playlist_id', 'api_user_id'];
	public $timestamps = false;

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

    public function following() {
	    return self::join('following', 'following.following_id', '=', 'following.follower_id')
                    ->where('following.following_id', $this->id)
                    ->get();
    }

    protected function findOrCreateRecord($record_id) {
	    $user = User::find(1);

	    $record = DB::table('record_user')->where('record_id', $record_id)->first();

	    if($record) {
	        $user->records()->updateExistingPivot($record_id);
        } else {
	        $user->records()->attach($record_id);
        }
    }

    public function records()
    {
        return $this->belongsToMany('App\Record')->withPivot('spotified')->withTimestamps();
    }

    protected function findByFbToken($token) {
	    return User::join('social_accounts', 'social_accounts.user_id', '=', 'users.id')
                    ->where('social_accounts.token', $token)
                    ->where('social_accounts.platform', 'facebook')
                    ->first();
    }
}
