<?php

use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = 's500';
		$VehicleModel->vehicle_brand_id = 1;
		$VehicleModel->save();

		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = 's600';
		$VehicleModel->vehicle_brand_id = 1;
		$VehicleModel->save();

		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = '520';
		$VehicleModel->vehicle_brand_id = 2;
		$VehicleModel->save();

		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = '530';
		$VehicleModel->vehicle_brand_id = 2;
		$VehicleModel->save();

		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = 'ABC';
		$VehicleModel->vehicle_brand_id = 3;
		$VehicleModel->save();

		$VehicleModel = new \App\Models\VehicleModel();
		$VehicleModel->name = 'DEF';
		$VehicleModel->vehicle_brand_id = 3;
		$VehicleModel->save();
	}
}
