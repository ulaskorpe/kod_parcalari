<?php

use App\Models\Client;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */


	public function run() {

		$faker = Faker\Factory::create();

		$managerRole = Role::where('name', 'manager')->first();
		$clientRole = Role::where('name', 'client')->first();

		$NewUser = new User();
		$NewUser->name = 'hakan';
		$NewUser->last_name = 'test';
		$NewUser->email = 'test@orangetechsoft.at';
		$NewUser->password = Hash::make('secret');
		$NewUser->gender = 'male';
		$NewUser->birth_date = $faker->date('y-m-d', '-18 years');
		$NewUser->gsm_phone = $faker->phoneNumber;
		$NewUser->status = 1;
		$NewUser->save();

		$NewUser->attachRole($managerRole);

		$NewUser = new User();
		$NewUser->name = 'hakan';
		$NewUser->last_name = 'hakan';
		$NewUser->email = 'hakan@orangetechsoft.at';
		$NewUser->password = Hash::make('secret');
		$NewUser->gender = 'male';
		$NewUser->birth_date = $faker->date('y-m-d', '-18 years');
		$NewUser->gsm_phone = $faker->phoneNumber;
		$NewUser->status = 1;
		$NewUser->save();

		$NewUser->attachRole($clientRole);

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
			$NewUser->save();

			$NewUser->attachRole($clientRole);

			$NewClient = new Client();
			$NewClient->user_id = $NewUser->id;
			$NewClient->corporate = $faker->numberBetween(0, 1);

			$randomCompany = Client::where('corporate', '=', 1)
				->inRandomOrder()->get()->first();

			$NewClient->company_name = $NewClient->corporate ? 'company' . $i : null;
			$NewClient->save();
			$NewClient->company_client_id = $randomCompany ? $randomCompany->id : 0;
			$NewClient->save();
		}
	}
}
