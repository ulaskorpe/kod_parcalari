<?php

  Route::get('/jobupdate/{orderid?}', "OrderController@jobupdate")->name('manager.order.jobupdate');
        Route::post('/jobupdate/{orderid?}', "OrderController@jobupdate");

     //   Route::get('/create', "OrderController@create")->name('manager.order.create');
       // Route::post('/create', "OrderController@create");

        //region **AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX**
        Route::get('/gettimetable/{date}/{is_alldrivers}/{vehicle_class_id}/{job_vehicle_class_id}', "OrderController@gettimetable");
        Route::get('/gettimetable/{date}/{is_alldrivers}', "OrderController@gettimetable");//hata yok silme...
        Route::get('/getprices', 'OrderController@getprices');
        Route::post('/getprices', 'OrderController@getprices');
        Route::post('/checkgeocodes', 'OrderController@checkgeocodes');
//        Route::get('/updateform/{job_id}', 'OrderController@updateform');
   //     Route::post('/updateform', 'OrderController@updateform');
 //       Route::get('/getorder/{order_id}', 'OrderController@getorder');
   //     Route::get('/delete/{job_id}', 'OrderController@delete');
        Route::get('/getorderhistory/{client_id}', 'OrderController@getorderhistory');
        Route::get('/getvehicles/{passenger_count}', 'OrderController@getvehicles');
        Route::get('/getplates/{vehicle_class_id}', 'OrderController@getplates');
        Route::get('/addvehicle', 'OrderController@addvehicle');
        Route::get('/getpassengers/{order_id}', 'OrderController@getpassengers');
        Route::get('/getextras/{order_id}', 'OrderController@getextras');
        Route::get('/deletepassenger/{passenger_id}', 'OrderController@deletepassenger');
        Route::get('/deleteorderextra/{id}', 'OrderController@deleteorderextra');
        Route::get('/getpricesummary', 'OrderController@getpricesummary');
        Route::post('/getpricesummary', 'OrderController@getpricesummary');
        Route::get('/sockettimetable', 'OrderController@sockettimetable');
        Route::get('/get_clients/{company_id?}/{department_id?}', 'OrderController@getClients');
        Route::get('/get_companies/{client_id?}', 'OrderController@getCompanies');
        Route::get('/get_departments/{client_id?}/{company_id?}', 'OrderController@getDepartments');
        Route::get('/find_drivers/{is_trip}/{package?}/{duration?}/{startDate?}/{client_id?}/{vehicle_class?}/{driver_id?}', 'OrderController@findDrivers');
        Route::get('/get_special_packages/{client_id?}', 'OrderController@getSpecialPackages');
        Route::get('/getcreditcard/{client_id}', 'OrderController@getcreditcard');