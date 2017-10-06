<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('vehicles', function (Blueprint $table) {

			$table->increments('id');
			$table->unsignedInteger('vehicle_model_id');
			$table->unsignedInteger('vehicle_class_id');
			$table->string('plate')->unique();
			$table->unsignedInteger('km')->nullable();
			$table->string('notes')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::dropIfExists('vehicles');
	}
}
