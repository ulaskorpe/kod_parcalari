<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('clients', function (Blueprint $table) {

			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('company_client_id')->nullable();
			// Client Company Info
			$table->boolean('corporate')->nullable()->default(null);
			$table->string('company_name')->nullable()->default(null);
			$table->string('company_address')->nullable()->default(null);
			$table->string('company_email')->nullable()->default(null);
			$table->string('company_phone_number1')->nullable()->default(null);
			$table->string('company_phone_number2')->nullable()->default(null);
			$table->string('company_phone_number3')->nullable()->default(null);
			$table->string('company_firm_number')->nullable()->default(null);
			$table->string('company_tax_number')->nullable()->default(null);

			// Client Info
			$table->string('title', 32)->nullable()->default(null);
			$table->text('address')->nullable()->default(null);
			$table->string('residential_id')->nullable()->default(null);
			$table->string('postcode')->nullable()->default(null);
			$table->string('place')->nullable()->default(null);
			$table->string('backup_first_phone')->nullable()->default(null);
			$table->string('spare_second_phone')->nullable()->default(null);

			// Client Bank Info
			$table->string('bank_account_owner')->nullable()->default(null);
			$table->string('bank_name')->nullable()->default(null);
			$table->string('iban')->nullable()->default(null);
			$table->string('bic')->nullable()->default(null);
			$table->string('identification_card')->nullable()->default(null);
			$table->string('identification_number')->nullable()->default(null);
			$table->string('nationality_id')->nullable()->default(null);
			$table->text('phones')->nullable()->default(null);

			// Client Account Info
			$table->rememberToken();

			// Client Login Info
            $table->string('last_login_ip')->nullable()->default(null);
            $table->timestamp('last_login')->nullable()->default(null);

			// Client Invoice Info
			$table->enum('invoice_company_name', ['show', 'hide'])->nullable()->default(null);
			$table->enum('invoice_customer_name', ['show', 'hide'])->nullable()->default(null);

			//Client Status Info
			$table->enum('status', ['active', 'passive'])->default('active');

			// Client Timestamps
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::dropIfExists('clients');
	}
}
