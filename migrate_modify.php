<?php 

///add a column
  Schema::table('client_company_special_prices', function (Blueprint $table) {
            $table->double('price_per_passenger')->default(0);
        });


////modifty a column 

  Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->change();
});

        ?>

         ,"amount"=>            __("expenses.table_expense_amount")
                            ,"expense_title"=>     __("expenses.table_expense_description")
                            ,"type_name"=>         __("expenses.table_expense_type")
                            ,"companyname"=>       __("expenses.table_expense_belongs_to")
                            ,"date"=>              __("expenses.table_expense_date")
                            ,"last_updatedby"=>    __("expenses.table_expense_created_by")