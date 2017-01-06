<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
//				[
//					'firstname'	=> 'Ino',
//					'lastname'	=> 'Van Winckel',
//					'email'		=> 'admin@admin.com'
//				],
//				[
//					'firstname'	=> 'Tim',
//					'lastname'	=> 'Van Dyck',
//					'email'		=> 'user1@user.com'
//				],
//				[
//					'firstname'	=> 'User',
//					'lastname'	=> '2',
//					'email'		=> 'user2@user.com'
//				],
//				[
//					'firstname'	=> 'User',
//					'lastname'	=> '3',
//					'email'		=> 'user3@user.com'
//				],
		]);
	}
}
