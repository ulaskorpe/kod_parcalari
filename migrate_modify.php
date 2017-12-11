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



 <!--
                                    <a href="#">
                                        <button type="button" class="btn btn-blue btn-sm" onclick="showClients({{$vehicle->id}})"><i class="icon-people white"></i>
                                            {{__('vehicles.clients')}}
                                        </button>
                                    </a>
                                    <a href="#">
                                        <button type="button" class="btn btn-green btn-sm" onclick="showExpenses({{$vehicle->id}})"><i class="icon-coin-euro white"></i>
                                            {{__('vehicles.expenses')}}
                                        </button>
                                    </a>
                                    <a href="#">
                                        <button type="button" class="btn btn-warning btn-sm" onclick="showOrders({{$vehicle->id}})"><i class="icon-map-signs white"></i>
                                            {{__('vehicles.orders')}}
                                        </button>
                                    </a>-->                            