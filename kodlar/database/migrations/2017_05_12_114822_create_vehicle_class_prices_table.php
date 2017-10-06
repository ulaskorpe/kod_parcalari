<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleClassPricesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('vehicle_class_prices', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('vehicle_class_id');

            $table->double('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('vehicle_class_prices');
    }
}
