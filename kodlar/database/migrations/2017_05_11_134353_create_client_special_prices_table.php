<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientSpecialPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('client_special_prices', function (Blueprint $table) {

			$table->bigIncrements('id');
			$table->unsignedBigInteger('client_id');
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

		Schema::drop('client_special_prices');
	}
}
