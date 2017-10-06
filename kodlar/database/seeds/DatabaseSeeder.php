<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public static $faker;

	public function run() {

		$item = new \App\Models\Theme();
		$item->is_selected = 1;
		$item->theme_title = "Robust";
		$item->theme_folder = "robust";
		$item->save();

		$this->call(VehicleClassSeeder::class);
		$this->call(PackageSeeder::class);


        $this->call(PaymentTypeSeeder::class);
		$this->call(SettingTableSeeder::class);
		$this->call(VehicleBrandSeeder::class);
		$this->call(VehicleModelSeeder::class);
		$this->call(VehicleSeeder::class);
		$this->call(PermissionsTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(ClientsTableSeeder::class);
		$this->call(OrderTableSeeder::class);
        $this->call(DriverTableSeeder::class);
		$this->call(JobTableSeeder::class);
        $this->call(JobsStatusTableSeeder::class);


	}
}
