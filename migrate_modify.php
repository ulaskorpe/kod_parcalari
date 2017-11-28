<?php 
  Schema::table('client_company_special_prices', function (Blueprint $table) {
            $table->double('price_per_passenger')->default(0);
        });


////modifty a column 

  Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->change();
});

        ?>