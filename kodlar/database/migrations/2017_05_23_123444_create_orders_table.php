<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('orders', function (Blueprint $table) {

			$table->increments('id');

			$table->timestamp('start_time')->nullable()->default(null);
			$table->unsignedInteger('duration')->nullable()->default(null);

			$table->double('start_location_lat')->default(false);
			$table->double('start_location_lon')->default(false);

			$table->string('start_address')->nullable()->default(null);

			$table->double('end_location_lat')->default(false);
			$table->double('end_location_lon')->default(false);

			$table->string('kilometer')->nullable()->default(null);

			$table->string('end_address')->nullable()->default(null);

			$table->unsignedInteger('number_of_passengers')->nullable()->default(null);

			$table->double('price')->nullable()->default(null);

			$table->unsignedTinyInteger('payment_type_id');

			$table->string('payment_comment')->nullable()->default(null);

			$table->string('note')->nullable()->default(null);
			$table->string('drivernote')->nullable()->default(null);
			$table->string('kostenstelle')->nullable()->default(null);

			$table->tinyInteger('payment_status')->nullable()->default(null);


			$table->unsignedInteger('client_id')->nullable()->default(null);

			$table->unsignedInteger('package_id')->nullable()->default(null);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('orders');
	}
}
