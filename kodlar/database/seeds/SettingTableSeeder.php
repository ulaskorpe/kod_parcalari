<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$item = new \App\Models\Setting();
		$item->name = 'editjobbeforemax';
		$item->description = 'The jobs will be locked before value(mins)';
		$item->value = '60';
		$item->save();
	}
}
