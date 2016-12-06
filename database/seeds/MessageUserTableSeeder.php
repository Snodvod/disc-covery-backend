<?php

use Illuminate\Database\Seeder;

class MessageUserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('message_user')->insert([
			[
				'message_id'	=> 1,
				'user_id'		=> 2,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-06 16:00:00'))
			],
			[
				'message_id'	=> 1,
				'user_id'		=> 3,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-05 12:00:00'))
			],
			[
				'message_id'	=> 1,
				'user_id'		=> 2,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-06 12:03:00'))
			],
			[
				'message_id'	=> 1,
				'user_id'		=> 3,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-06 14:00:00'))
			],
			[
				'message_id'	=> 1,
				'user_id'		=> 4,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-06 11:00:00'))
			],
			[
				'message_id'	=> 1,
				'user_id'		=> 4,
				'created_at'	=> date('Y-m-d', strtotime('2016-12-06 09:00:00'))
			]
		]);
	}
}
