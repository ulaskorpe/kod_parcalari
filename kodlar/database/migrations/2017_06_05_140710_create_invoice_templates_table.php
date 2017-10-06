<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTemplatesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('invoice_templates', function (Blueprint $table) {

			$table->increments('id');

			$table->string('name');

			$table->text('header')->nullable();

			$table->text('footer')->nullable();

			$table->boolean('showrownumber')->default(1);
			$table->string('rowtitle')->nullable();
			$table->unsignedSmallInteger('rowwidth')->nullable();

			$table->boolean('showname')->default(1);
			$table->string('nametitle')->nullable();
			$table->unsignedSmallInteger('namewidth')->nullable();

			$table->boolean('showquantity')->default(1);
			$table->string('quantitytitle')->nullable();
			$table->unsignedSmallInteger('quantitywidth')->nullable();

			$table->boolean('shownetto')->default(1);
			$table->string('nettotitle')->nullable();
			$table->unsignedSmallInteger('nettowidth')->nullable();

			$table->boolean('showtax')->default(1);
			$table->string('taxtitle')->nullable();
			$table->unsignedSmallInteger('taxwidth')->nullable();

			$table->boolean('showbrutto')->default(1);
			$table->string('bruttotitle')->nullable();
			$table->unsignedSmallInteger('bruttowidth')->nullable();

			$table->boolean('showtotal')->default(1);
			$table->string('totaltitle')->nullable();
			$table->unsignedSmallInteger('totalwidth')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::dropIfExists('invoice_templates');
	}
}
