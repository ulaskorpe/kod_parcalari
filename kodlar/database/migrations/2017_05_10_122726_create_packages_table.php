<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('packages', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->boolean('start_location')->default(false);
            $table->boolean('end_location')->default(false);
            $table->string('start_map_place')->nullable()->default(null);
            $table->string('end_map_place')->nullable()->default(null);
            $table->unsignedInteger('client_id')->nullable()->default(null);
            $table->unsignedInteger('opposite_id')->nullable();
            $table->boolean('is_fixed_price');
            $table->unsignedTinyInteger('min_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('packages');
    }
}
