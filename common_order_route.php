   <?php 

   Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {
    //    Route::get('/', "OrderController@index")->name('client.order.index');
      //  Route::get('/orders', "OrderController@index")->name('client.order.orders');

        Route::get('/orderlist', "OrderController@orderlist")->name('client.order.index');
        Route::post('/orderlist', "OrderController@orderlist");
        Route::get('/getorder/{order_id}', 'OrderController@getorder');

        Route::get('/updateform/{job_id}', 'OrderController@updateform');
        Route::post('/updateform', 'OrderController@updateform');


    });

    ?>