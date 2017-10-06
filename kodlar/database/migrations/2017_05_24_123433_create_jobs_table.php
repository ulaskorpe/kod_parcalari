<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('jobs', function (Blueprint $table) {

			$table->increments('id');
			$table->unsignedInteger('driver_id')->default(0);
			$table->unsignedTinyInteger('vehicle_class_id');
			$table->unsignedInteger('order_id');
			$table->boolean('isaccepted')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('jobs');
	}
}
