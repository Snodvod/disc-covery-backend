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
				[
					'firstname'	=> 'Ad',
					'lastname'	=> 'Min',
					'email'		=> 'admin@admin.com',
					'password'	=> bcrypt('admin123'),
				],
				[
					'firstname'	=> 'User',
					'lastname'	=> '1',
					'email'		=> 'user1@user.com',
					'password'	=> bcrypt('user1111'),
				],
				[
					'firstname'	=> 'User',
					'lastname'	=> '2',
					'email'		=> 'user2@user.com',
					'password'	=> bcrypt('user2222'),
				],
				[
					'firstname'	=> 'User',
					'lastname'	=> '3',
					'email'		=> 'user3@user.com',
					'password'	=> bcrypt('user333'),
				],
		]);
	}
}
