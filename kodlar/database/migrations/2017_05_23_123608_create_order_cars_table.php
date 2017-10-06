<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCarsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('order_cars', function (Blueprint $table) {

			$table->increments('id');

			$table->unsignedInteger('order_id')->nullable()->default(null);

			$table->unsignedInteger('vehicle_class_id')->nullable()->default(null);

			$table->unsignedTinyInteger('quantity')->nullable()->default(null);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('order_cars');
	}
}
