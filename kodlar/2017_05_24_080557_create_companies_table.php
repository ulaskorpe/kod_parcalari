<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
/////companies diye bir table artık yok ,  client_companies ve driver_companies var
	/*	Schema::create('companies', function (Blueprint $table) {

			$table->increments('id');
			$table->string('name');
			$table->string('address');
			$table->string('email');
			$table->string('phone_number1');
			$table->string('phone_number2')->nullable()->default(null);
			$table->string('phone_number3')->nullable()->default(null);
			$table->string('firm_number');
            $table->integer('country_id')->default('0');
            $table->string('tax_number');
            $table->string('eu_tax_number')->nullable()->default(null);
            $table->string('int_tax_number')->nullable()->default(null);
			$table->decimal('earnings_guarantee', 10, 2)->nullable()->default(null);
            $table->integer('commission')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
		});*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		////Schema::dropIfExists('companies');
	}
}
