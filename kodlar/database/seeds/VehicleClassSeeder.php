<?php

use Illuminate\Database\Seeder;

class VehicleClassSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$item = new \App\Models\VehicleClass();
		$item->name = 'Car';
		$item->max_capacity = 3;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Limousine';
		$item->max_capacity = 3;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Suv';
		$item->max_capacity = 4;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Van';
		$item->max_capacity = 7;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Strech Limoosine';
		$item->max_capacity = 4;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Sprint';
		$item->max_capacity = 19;
		$item->save();
		$item = new \App\Models\VehicleClass();
		$item->name = 'Bus';
		$item->max_capacity = 50;
		$item->save();
	}
}
