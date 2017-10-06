<?php

use App\Models\Driver;
use App\User;
use Illuminate\Database\Seeder;

class DriverTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$faker = Faker\Factory::create();

		for ($i = 0; $i < 20; $i++) {

			$NewUser = new User();
			$NewUser->name = $faker->firstName;
			$NewUser->last_name = $faker->lastName;
			$NewUser->email = $faker->email;
			$NewUser->password = Hash::make('secret');
			$NewUser->gender = $faker->boolean ? 'female' : 'male';
			$NewUser->birth_date = $faker->date('y-m-d', '-18 years');
			$NewUser->gsm_phone = $faker->phoneNumber;
			$NewUser->status = 1;
			$NewUser->role_id = \App\Role::where('name','=','driver')->get()->first()->id; //TODO Role::where('name', 'client')->first()->id;
			$NewUser->save();

			$NewDriver = new Driver();
			$NewDriver->user_id = $NewUser->id;
			$NewDriver->save();
		}
	}
}
