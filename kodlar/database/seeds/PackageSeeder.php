<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $VIEN = "ChIJn8o2UZ4HbUcRRluiUYrlwv0";

        $item = new \App\Models\Package();
        $item->name = 'Km Unlimited';
        $item->start_location = 1;
        $item->end_location = 1;
        $item->is_fixed_price = 0;
        $item->min_price = 10;
        $item->opposite_id = 0;
        $item->save();

        $item = new \App\Models\Package();
        $item->name = 'In Vienna';
        $item->start_location = 1;
        $item->end_location = 1;
        $item->end_map_place = $VIEN;
        $item->start_map_place = $VIEN;
        $item->is_fixed_price = 1;
        $item->opposite_id = 0;
        $item->save();

        $item = new \App\Models\Package();
        $item->name = 'Km From Vienna';
        $item->start_location = 1;
        $item->end_location = 1;
        $item->start_map_place = $VIEN;
        $item->is_fixed_price = 0;
        $item->min_price = 10;
        $item->opposite_id = 0;
        $item->save();


        $item = new \App\Models\Package();
        $item->name = 'Airport to Vienna';
        $item->start_location = 0;
        $item->end_location = 1;
        $item->end_map_place = $VIEN;
        $item->is_fixed_price = 1;
        $item->save();

        $airporttovien = $item;

        $item = new \App\Models\Package();
        $item->name = 'Vienna to Airport';
        $item->start_location = 1;
        $item->end_location = 0;
        $item->start_map_place = "ChIJn8o2UZ4HbUcRRluiUYrlwv0";
        $item->is_fixed_price = 1;

        $item->opposite_id = $airporttovien->id;
        $item->save();
        $airporttovien->opposite_id = $item->id;

        $item = new \App\Models\Package();
        $item->name = '1 Hour - 25 KM';
        $item->start_location = 1;
        $item->end_location = 0;
        $item->is_fixed_price = 1;
        $item->save();

        $item = new \App\Models\Package();
        $item->name = '3 Hour - 60 KM';
        $item->start_location = 1;
        $item->end_location = 0;
        $item->is_fixed_price = 1;
        $item->save();

        $item = new \App\Models\Package();
        $item->name = '8 Hour - 150 KM';
        $item->start_location = 1;
        $item->end_location = 0;
        $item->is_fixed_price = 1;
        $item->save();

        $item = new \App\Models\Package();
        $item->name = '12 Hour - 300 KM';
        $item->start_location = 1;
        $item->end_location = 0;
        $item->is_fixed_price = 1;
        $item->save();
    }
}
