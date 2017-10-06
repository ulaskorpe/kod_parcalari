<?php

use Illuminate\Database\Seeder;

class VehicleBrandSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$VehicleBrand = new \App\Models\VehicleBrand();
		$VehicleBrand->name = 'Mercedes';
		$VehicleBrand->save();

		$VehicleBrand = new \App\Models\VehicleBrand();
		$VehicleBrand->name = 'Bmw';
		$VehicleBrand->save();

		$VehicleBrand = new \App\Models\VehicleBrand();
		$VehicleBrand->name = 'Lexus';
		$VehicleBrand->save();
	}
}