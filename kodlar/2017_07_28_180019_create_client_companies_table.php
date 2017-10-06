<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     /*   Schema::create('client_companies', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('client_company_id')->default(0);

            $table->string('company_name')->nullable()->default(null);
            $table->string('company_address')->nullable()->default(null);
            $table->string('company_email')->nullable()->default(null);
            $table->string('company_phone_number1')->nullable()->default(null);
            $table->string('company_phone_number2')->nullable()->default(null);
            $table->string('company_phone_number3')->nullable()->default(null);
            $table->string('company_firm_number')->nullable()->default(null);
            $table->string('company_tax_number')->nullable()->default(null);
            $table->string('company_eu_tax_number')->nullable()->default(null);
            $table->string('company_int_tax_number')->nullable()->default(null);
            $table->integer('company_country_id')->default('0');

            // Client Info
            $table->string('title', 32)->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('residential_id')->nullable()->default(null);
            $table->string('postcode')->nullable()->default(null);


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

            // Client Invoice Info
            $table->enum('invoice_company_name', ['show', 'hide'])->nullable()->default(null);
            $table->enum('invoice_customer_name', ['show', 'hide'])->nullable()->default(null);
            $table->enum('invoice_type', ['instant', 'monthly'])->default('instant');
            $table->tinyInteger('invoice_via_email')->default('1');
            $table->tinyInteger('invoice_via_mail')->default('0');
            $table->tinyInteger('invoice_via_sms')->default('0');

            //Client Status Info
            $table->enum('status', ['active', 'passive'])->default('active');

            // Client Timestamps
            $table->softDeletes();
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('client_companies');
    }
}
