<?php

use App\Models\Job;
use App\Models\Order;
use Illuminate\Database\Seeder;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 60; $i++) {

            $Order = new Order();
            $Order->start_time = $faker->dateTimeBetween('-10 days', '+10 days');
            $Order->duration = $faker->numberBetween(40, 150);
            $Order->payment_type_id = 1;
            $Order->client_id = \App\Models\Client::inRandomOrder()->first()->id;
            $Order->package_id = \App\Models\Package::inRandomOrder()->first()->id;
            $Order->number_of_passengers = $faker->numberBetween(1, 5);
            $Order->note = 'not';
            $Order->drivernote = 'drvnot';
            $Order->price = $faker->numberBetween(40, 200);
            $Order->save();

            $Job = new Job();

            if ($faker->numberBetween(2, 4) % 2 == 0)
                $Job->driver_id = \App\Models\Driver::inRandomOrder()->first()->id;


            $Job->order_id = $Order->id;
            $Job->vehicle_class_id = 1;
            $Job->save();
        }
    }
}
