<?php

use Illuminate\Database\Seeder;
use App\Models\Payment\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PaymentType = new PaymentType();

        $PaymentType->payment_title='Cache';
        $PaymentType->status  =1;
        $PaymentType->save();
    }
}
