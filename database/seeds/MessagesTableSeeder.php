<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('messages')->insert([
			[
				'content' => '[user] is now listening to [record]',
			],
			[
				'content' => '[user] is now following [following]',
			]
		]);
	}
}
