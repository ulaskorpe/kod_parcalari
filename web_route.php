<?php

<?php

/** * OrangeTech Soft Taxi & Mietwagen Verwaltungssystem
 *
 * @package   Premium
 * @author    OrangeTech Soft <support@orangetechsoft.at>
 * @link      http://www.orangetechsoft.at/
 * @copyright 2017 OrangeTech Soft
 */

/**
 * @package OrangeTech Soft Taxi & Mietwagen Verwaltungssystem
 * @author  OrangeTech Soft <support@orangetechsoft.at>
 */


use Enum\TaskPriorities;
use Vsch\TranslationManager\Translator;


Route::group(['middleware' => 'web', 'prefix' => 'translations'], function () {
    Translator::routes();
});

Route::get('/', 'Manager\HomeController@index')->middleware('auth');


Route::get('/test', function () {
   dd( TaskPriorities::getListUcfirst());
});

Route::post('/changelanguage', 'LocalizationController@changelanguage')->name("changelanguage");

Route::group(["namespace" => "Todo", "prefix" => "todo", "middleware" => "auth"], function () {

    Route::get('/all/{status?}', 'TodoController@todo')->name('todo.list');
    Route::get('/new_task_count', 'TodoController@newTaskCount')->name('todo.new_task_count');

});
Route::group(["namespace" => "User", "middleware" => "auth"], function () {

    Route::get('/edit-profile', 'UserController@editprofile')->name('edit.profile');
    Route::post('/edit-profile', 'UserController@editprofile')->name('edit.profile');

    Route::get('/change-password', 'UserController@changepassword')->name('change.password');
    Route::post('/change-password', 'UserController@changepassword')->name('change.password');


    Route::group(["prefix" => "tasks", 'namespace' => 'Task'], function () {

        //    Route::get('/', 'TaskController@ok');

        Route::get('/', 'TaskController@index')->name('user.tasks.index');


        Route::get('/show_tasks/{user_id?}/{status?}/{start_at?}/{end_at?}/{priority?}', 'TaskController@show_tasks')->name('user.tasks.show_tasks');

        Route::get('/create/{start_date?}/{user_id?}', 'TaskController@create')->name('user.tasks.create');
        Route::post('/create', 'TaskController@create');


        Route::get('/timeline/{user_id?}/{status?}/{start_at?}/{end_at?}', 'TaskController@timeline')->name('user.tasks.timeline');

        Route::get('/show_timeline/{user_id?}/{status?}/{start_at?}/{mode?}/{priority?}', 'TaskController@show_timeline')->name('user.tasks.show_timeline');

        Route::get('/user_view/{task_id?}', 'TaskController@user_view')->name('user.tasks.user_view');

        Route::get('/update/{task_id?}', 'TaskController@edit')->name('user.tasks.edit');
        Route::post('/update/{task_id?}', 'TaskController@edit');
        Route::post('/update_status', 'TaskController@update_status');

        Route::get('/drag_task/{task_id?}/{start_at?}/{end_at?}', 'TaskController@drag_task')->name('user.tasks.drag_task');


        Route::get('/user_status/{task_id?}/{status?}', 'TaskController@user_status')->name('user.tasks.user_status');

        Route::get('/delete/{task_id?}', 'TaskController@delete')->name('user.tasks.delete');
        Route::post('/cancel', 'TaskController@cancel')->name('user.tasks.cancel');
        Route::get('/update_done/{task_id?}/{user_id?}', 'TaskController@update_done')->name('user.tasks.update_done');
        Route::get('/find_user/{user_id?}', 'TaskController@findUser')->name('user.tasks.findUser');
        Route::get('/timelineprocess', 'TaskController@taskProcess')->name('taskProcess');/////ajax
    });

});
Route::group(["namespace" => "Auth"], function () {

    Route::get('/login', 'LoginController@login')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
    Route::get('/register', 'RegisterController@register')->name('register');
    Route::post('/register', 'RegisterController@register');

    Route::get('/smsregister', 'RegisterController@smsregister')->name('smsregister');
    Route::get('/smsregister/{id}', 'RegisterController@smsregister')->name('smsregister');
    Route::get('/sendsms', 'RegisterController@sendsms')->name('sendsms');
    Route::get('/validatesms', 'RegisterController@validatesms')->name('validatesms');
    Route::get('/finishregister', 'RegisterController@finishregister')->name('finishregister');
    Route::get('/login-facebook', 'LoginController@redirectToProvider');
    Route::get('/login-facebook/callback', 'LoginController@handleProviderCallback');
    Route::get('/facebookregister', 'RegisterController@facebookregister');
    Route::post('/facebookregister', 'RegisterController@facebookregister');
    Route::get('/forgot-password', 'ForgotPasswordController@forgotPassword');
    Route::get('/sendresetlinkemail', 'ForgotPasswordController@sendresetlinkemail');
    Route::post('/sendresetlinkemail', 'ForgotPasswordController@sendresetlinkemail');
    Route::post('/resetpassword', 'ForgotPasswordController@resetpassword');
    Route::get('/resetpassword/{token}/{user_id}', 'ForgotPasswordController@resetpassword');


});
Route::group(['namespace' => 'Client', 'prefix' => 'client', 'middleware' => 'role:client'], function () {
    Route::get('/', 'HomeController@index')->name('client');
    //Profil
    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('/', "ProfileController@index")->name('client.profile.index');
        Route::post('/updateprofile', "ProfileController@updateprofile")->name('client.profile.updateprofile');
        Route::post('/updateaccount', "ProfileController@updateaccount")->name('client.profile.updateaccount');
    });
    //Order
    Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {
        Route::get('/', "OrderController@index")->name('client.order.index');
        Route::get('/orders', "OrderController@orders")->name('client.order.orders');

        Route::get('/create', "OrderController@create")->name('client.order.create');
        Route::post('/create', "OrderController@create")->name('client.order.create');

        Route::get('/update/{id}', "OrderController@update")->name('client.order.update');
        Route::post('/update/{id}', "OrderController@update")->name('client.order.update');

        Route::get('/copy/{id}', "OrderController@copy")->name('client.order.copy');
        Route::post('/copy/{id}', "OrderController@copy")->name('client.order.copy');

        Route::get('/opposite/{id}', "OrderController@opposite")->name('client.order.opposite');
        Route::post('/opposite/{id}', "OrderController@opposite")->name('client.order.opposite');

        Route::post('/rate', "OrderController@rate")->name('client.order.rate');
        Route::get('/getrate/{id}', "OrderController@getrate")->name('client.order.getrate');

        Route::get('/addtofavorite/{id}', "OrderController@addtofavorite")->name('client.order.addtofavorite');
        Route::get('/removefavorite/{id}', "OrderController@removefavorite")->name('client.order.removefavorite');

        //Ajax
        Route::get('/getprices', 'OrderController@getprices');

        Route::post('/checkgeocodes', 'OrderController@checkgeocodes');
        Route::get('/updateform/{job_id}', 'OrderController@updateform');
        Route::post('/updateform', 'OrderController@updateform');
        Route::get('/delete/{job_id}', 'OrderController@delete');

    });

    Route::group(['prefix' => 'company', 'namespace' => 'Company'], function () {

        Route::get('/', "CompanyController@index")->name('client.company.index');
        Route::get('/update/{id}', "CompanyController@update")->name('client.company.update');
        Route::post('/update/{id}', "CompanyController@update");
        Route::get('/delete/{id}', 'CompanyController@delete')->name('client.company.delete');
        Route::get('/profile/{id}', 'CompanyController@profile')->name('client.company.profile');
        Route::get('/departments/{company_id}', 'CompanyController@departments')->name('client.company.departments');
        Route::post('/add-department', 'CompanyController@addDepartment');
        Route::post('/remove-department', 'CompanyController@removeDepartment');
    });

    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function () {

        Route::get('/', "ClientController@index")->name('client.client.index');
        Route::get('/create', "ClientController@create")->name('client.client.create');
        Route::post('/create', "ClientController@create")->name('client.client.create');
        Route::get('/update/{id?}', "ClientController@update")->name('client.client.update');
        Route::post('/update/{id?}', "ClientController@update");
        Route::get('/delete/{job_id}', 'ClientController@delete')->name('client.client.delete');
        Route::get('/find_country_code/{values?}', "ClientController@findCountryCode")->name('client.client.find_country_code');
        Route::get('/find_country/{values?}', "ClientController@findCountry")->name('client.client.find_country');
        Route::get('/add_client_company/{values?}', "ClientController@addClientCompany")->name('client.client.add_client_company');
        Route::get('/find_company/{company_id?}', "ClientController@findCompany")->name('client.client.find_company');
        Route::get('/get_departments/{company_id?}', "ClientController@getDepartments")->name('client.client.get_departments');
    });

    Route::get('/favorite-drivers', 'FavoriteDriverController@index')->name('client.favorite-drivers');
    Route::post('/favorite-drivers', 'FavoriteDriverController@index')->name('client.favorite-drivers');
});
Route::group(['namespace' => 'Manager', 'prefix' => 'manager', 'middleware' => 'role:manager'], function () {

    Route::get('/', 'HomeController@index');


    Route::group(["prefix" => "releasenotifications", 'namespace' => 'Notification'], function () {
        Route::get("/release/{notification_id?}", "ReleaseNotificationController@releasenotification")->name("releasevehicle");
    });

    Route::group(['prefix' => 'path', 'namespace' => 'Permission'], function () {

        Route::get('/', 'PathController@index')->name('manager.path.index');

        Route::get('/create', 'PathController@create')->name('manager.path.create');
        Route::post('/create', 'PathController@create');

        Route::get('/update/{id}', 'PathController@update')->name('manager.path.edit');
        Route::post('/update/{id}', 'PathController@update');

        Route::get('/delete/{id}', 'PathController@delete')->name('manager.path.delete');

    });
    Route::group(['prefix' => 'role', 'namespace' => 'Permission'], function () {

        Route::get('/', 'RoleController@index')->name('manager.role.index');

        Route::get('/create', 'RoleController@create')->name('manager.role.create');
        Route::post('/create', 'RoleController@create');

        Route::get('/edit/{role_id}', 'RoleController@update')->name('manager.role.edit');
        Route::post('/edit/{role_id}', 'RoleController@update');

        Route::get('/permissions/{role_id}', 'RolePermissionController@update')->name('manager.role.permission.edit');
        Route::post('/permissions/{role_id}', 'RolePermissionController@update');

    });
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function () {

        Route::get('/', "ClientController@index")->name('manager.client.index');

        Route::get('/create', "ClientController@create")->name('manager.client.create');
        Route::post('/create', "ClientController@create");

        Route::get('/edit/{id?}', "ClientController@edit")->name('manager.client.edit');
        Route::post('/edit/{id?}', "ClientController@edit");

        Route::get('/delete/{id}', "ClientController@delete")->name('manager.client.delete');
        Route::post('/delete', "ClientController@delete");

        Route::get('/profile/{id}', "ClientController@profile")->name('manager.client.profile');
        Route::get('/add_client_company/{values?}', "ClientController@addClientCompany")->name('manager.client.add_client_company');
        Route::get('/find_company/{company_id?}', "ClientController@findCompany")->name('manager.client.find_company');
        Route::get('/find_country_code/{values?}', "ClientController@findCountryCode")->name('manager.client.find_country_code');
        Route::get('/find_country/{values?}', "ClientController@findCountry")->name('manager.client.find_country');
        Route::get('/get_departments/{company_id?}', "ClientController@getDepartments")->name('manager.client.get_departments');

    });
    Route::group(['prefix' => 'vehicleclass', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehicleClassController@index")->name('manager.vehicleclass.index');

        Route::get('/edit/{class_id}', 'VehicleClassController@update')->name('manager.vehicleclass.edit');
        Route::post('/edit/{class_id}', 'VehicleClassController@update');

        Route::get('/create', 'VehicleClassController@create')->name('manager.vehicleclass.create');
        Route::post('/create', 'VehicleClassController@create');

        Route::post('/delete', 'VehicleClassController@delete')->name('manager.vehicleclass.delete');
        Route::get('/profile/{class_id}', 'VehicleClassController@profile')->name('manager.vehicleclass.profile');

    });
    Route::group(['prefix' => 'vehiclebrand', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehicleBrandController@index")->name('manager.vehiclebrand.index');

        Route::get('/edit/{brand_id}', 'VehicleBrandController@update')->name('manager.vehiclebrand.edit');
        Route::post('/edit/{brand_id}', 'VehicleBrandController@update');

        Route::get('/create', 'VehicleBrandController@create')->name('manager.vehiclebrand.create');
        Route::post('/create', 'VehicleBrandController@create');

        Route::post('/delete', 'VehicleBrandController@delete')->name('manager.vehiclebrand.delete');
    });
    Route::group(['prefix' => 'vehiclemodel', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehicleModelController@index")->name('manager.vehiclemodel.index');

        Route::get('/edit/{model_id}', 'VehicleModelController@update')->name('manager.vehiclemodel.edit');
        Route::post('/edit/{model_id}', 'VehicleModelController@update');

        Route::get('/create', 'VehicleModelController@create')->name('manager.vehiclemodel.create');
        Route::post('/create', 'VehicleModelController@create');

        Route::post('/delete', 'VehicleModelController@delete')->name('manager.vehiclemodel.delete');
    });
    Route::group(['prefix' => 'vehicleproperty', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehiclePropertyController@index")->name('manager.vehicleproperty.index');

        Route::get('/edit/{model_id}', 'VehiclePropertyController@update')->name('manager.vehicleproperty.edit');
        Route::post('/edit/{model_id}', 'VehiclePropertyController@update');

        Route::get('/create', 'VehiclePropertyController@create')->name('manager.vehicleproperty.create');
        Route::post('/create', 'VehiclePropertyController@create');

        Route::get('/delete/{class_id}', 'VehiclePropertyController@delete')->name('manager.vehicleproperty.delete');
    });
    Route::group(['prefix' => 'tank_card', 'namespace' => 'Vehicle'], function () {
        Route::get('/', "TankCardController@index")->name('manager.tank_card.index');
        Route::get('/edit/{card_id?}', 'TankCardController@update')->name('manager.tank_card.edit');
        Route::post('/edit/{card_id}', 'TankCardController@update');
        Route::get('/create', 'TankCardController@create')->name('manager.tank_card.create');
        Route::post('/create', 'TankCardController@create');
        Route::post('/delete', 'TankCardController@delete')->name('manager.tank_card.delete');
        Route::get('/profile/{card_id?}', 'TankCardController@profile')->name('manager.tank_card.profile');
    });
    Route::group(['prefix' => 'tank_card_company', 'namespace' => 'Vehicle'], function () {
        Route::get('/', "TankCardCompanyController@index")->name('manager.tank_card_company.index');
        Route::get('/edit/{card_id?}', 'TankCardCompanyController@update')->name('manager.tank_card_company.edit');
        Route::post('/edit/{card_id}', 'TankCardCompanyController@update');
        Route::get('/create', 'TankCardCompanyController@create')->name('manager.tank_card_company.create');
        Route::post('/create', 'TankCardCompanyController@create');
        Route::post('/delete', 'TankCardCompanyController@delete')->name('manager.tank_card_company.delete');
    });
    Route::group(['prefix' => 'vehicle', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehicleController@index")->name('manager.vehicle.index');

        Route::get('/edit/{vehicle_id}', 'VehicleController@update')->name('manager.vehicle.edit');
        Route::post('/edit/{vehicle_id}', 'VehicleController@update');

        Route::get('/create', 'VehicleController@create')->name('manager.vehicle.create');
        Route::post('/create', 'VehicleController@create');

        Route::post('/delete', 'VehicleController@delete')->name('manager.vehicle.delete');

        Route::get('/getmodels/{brand_id}', 'VehicleController@getmodels')->name('manager.vehicle.getmodels');
        Route::get('/profile/{vehicle_id}', 'VehicleController@profile')->name('manager.vehicle.profile');
        Route::get('/profile-show/{vehicle_id?}', 'VehicleController@show_profile')->name('manager.vehicle.profile-show');

        Route::get('/show_clients/{vehicle_id?}', 'VehicleController@show_clients')->name('manager.vehicleclass.show_clients');
        Route::get('/show_expenses/{vehicle_id?}', 'VehicleController@show_expenses')->name('manager.vehicleclass.show_expenses');
        Route::get('/show_orders/{vehicle_id?}', 'VehicleController@show_orders')->name('manager.vehicleclass.show_orders');
    });
    Route::group(['prefix' => 'package', 'namespace' => 'Package'], function () {

        Route::get('/', "PackageController@index")->name('manager.package.index');
        Route::get('/package_view/{is_private?}', "PackageController@indexView")->name('manager.package.indexView');

        Route::get('/create', 'PackageController@create')->name('manager.package.create');
        Route::post('/create', 'PackageController@create');

        Route::get('/edit/{package_id}', 'PackageController@edit')->name('manager.package.edit');
        Route::post('/edit/{package_id}', 'PackageController@edit');

        // Route::get('/delete/{package_id}', 'PackageController@delete')->name('manager.package.delete');
        Route::post('/delete', 'PackageController@delete')->name('manager.package.delete');
    });
    Route::group(['prefix' => 'driver', 'namespace' => 'Driver'], function () {

        Route::get('/', "DriverController@index")->name('manager.driver.index');

        Route::get('/create', 'DriverController@create')->name('manager.driver.create');
        Route::post('/create', 'DriverController@create');

        Route::get('/edit/{package_id}', 'DriverController@edit')->name('manager.driver.edit');
        Route::post('/edit/{package_id}', 'DriverController@edit');

        // Route::get('/delete/{package_id}', 'DriverController@delete')->name('manager.driver.delete');
        Route::post('/delete', 'DriverController@delete')->name('manager.driver.delete');
        Route::get('/profile/{id}', 'DriverController@profile')->name('manager.driver.profile');
        Route::get('/getvehicles/{company_id?}', 'DriverController@getvehicles')->name('manager.driver.getvehicles');

        Route::get('/punishmentreason', 'PunishmentController@reasonlist')->name('manager.driver.reasonlist');
        Route::get('/createreason', 'PunishmentController@createreason')->name('manager.driver.createreason');
        Route::post('/createreason', 'PunishmentController@createreason');
        Route::get('/updatereason/{driver_punishment_reason_id}', 'PunishmentController@updatereason')->name('manager.driver.updatereason');
        Route::post('/updatereason', 'PunishmentController@updatereason');
        Route::post('/deletereason', 'PunishmentController@deletereason');
        Route::get('/createpunishment/{job_id}/{driver_id}', 'PunishmentController@createpunishment')->name('manager.driver.createpunishment');
        Route::post('/createpunishment', 'PunishmentController@createpunishment');

    });
    Route::group(['prefix' => 'driver_company', 'namespace' => 'DriverCompany'], function () {

        Route::get('/', "DriverCompanyController@index")->name('manager.driver_company.index');

        Route::get('/create', 'DriverCompanyController@create')->name('manager.driver_company.create');
        Route::post('/create', 'DriverCompanyController@create');

        Route::get('/edit/{package_id}', 'DriverCompanyController@edit')->name('manager.driver_company.edit');
        Route::post('/edit/{package_id}', 'DriverCompanyController@edit');

        //   Route::get('/delete/{package_id}', 'DriverCompanyController@delete')->name('manager.driver_company.delete');
        Route::post('/delete', 'DriverCompanyController@delete')->name('manager.driver_company.delete');

        Route::get('/profile/{id}', 'DriverCompanyController@profile')->name('manager.driver_company.profile');
    });
    Route::group(['prefix' => 'client_company', 'namespace' => 'ClientCompany'], function () {

        Route::get('/', "ClientCompanyController@index")->name('manager.client_company.index');

        Route::get('/create', 'ClientCompanyController@create')->name('manager.client_company.create');
        Route::post('/create', 'ClientCompanyController@create');

        Route::get('/edit/{package_id?}', 'ClientCompanyController@edit')->name('manager.client_company.edit');
        Route::post('/edit/{package_id?}', 'ClientCompanyController@edit');

        // Route::get('/delete/{package_id}', 'ClientCompanyController@delete')->name('manager.client_company.delete');
        Route::post('/delete', 'ClientCompanyController@delete')->name('manager.client_company.delete');

        Route::get('/profile/{id}', 'ClientCompanyController@profile')->name('manager.client_company.profile');
    });
    Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {

        Route::get('/', "OrderController@timetable")->name('manager.order.index');

        Route::get('/orderlist', "OrderController@orderlist")->name('manager.order.orderlist');
        Route::post('/orderlist', "OrderController@orderlist");

        Route::get('/timetable', "OrderController@timetable")->name('manager.order.timetable');
        Route::post('/timetable', "OrderController@timetable");
        Route::get('/jobupdate/{orderid?}', "OrderController@jobupdate")->name('manager.order.jobupdate');
        Route::post('/jobupdate/{orderid?}', "OrderController@jobupdate");

        Route::get('/create', "OrderController@create")->name('manager.order.create');
        Route::post('/create', "OrderController@create");
        Route::get('/createreorder/{orderid}', "OrderController@createreorder")->name('manager.order.createreorder');
        Route::post('/createreorder', "OrderController@createreorder");
        Route::get('/getclientdirections/{client_id}', "OrderController@getclientdirections")->name('manager.order.getclientdirections');
        Route::get('/getdirectiondetail/{order_location_id}', "OrderController@getdirectiondetail")->name('manager.order.getdirectiondetail');

        //region **AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX**
        Route::get('/gettimetable/{date}/{is_alldrivers}/{vehicle_class_id}/{job_vehicle_class_id}', "OrderController@gettimetable");
        Route::get('/gettimetable/{date}/{is_alldrivers}', "OrderController@gettimetable");//hata yok silme...
        Route::get('/getprices', 'OrderController@getprices');
        Route::post('/getprices', 'OrderController@getprices');
        Route::post('/checkgeocodes', 'OrderController@checkgeocodes');
        Route::get('/updateform/{job_id}', 'OrderController@updateform');
        Route::post('/updateform', 'OrderController@updateform');
        Route::get('/getorder/{order_id}', 'OrderController@getorder');
        Route::get('/delete/{job_id}', 'OrderController@delete');
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
        //endregion

    });
    Route::group(['prefix' => 'calculate', 'namespace' => 'Calculate'], function () {
        Route::get('/', "CalculateController@index")->name('manager.calculate.index');
        Route::get('/calculator', "CalculateController@calculator")->name('manager.calculate.calculator');
        Route::get('/getdata', "CalculateController@getdata")->name('manager.calculate.getdata');
        Route::post('/getdata', "CalculateController@getdata");
        Route::get('/savecalculate', "CalculateController@savecalculate")->name('manager.calculate.savecalculate');
        Route::post('/savecalculate', "CalculateController@savecalculate");
        Route::get('/getcalculate/{calculate_id}', "CalculateController@getcalculate")->name('manager.calculate.getcalculate');
        Route::post('/delete', "CalculateController@delete")->name('manager.calculate.delete');
        Route::get('/cuteoff/{calculate_item_id}', "CalculateController@cuteoff")->name('manager.calculate.cuteoff');
        Route::get('/getperiod', "CalculateController@getperiod")->name('manager.calculate.getperiod');
        Route::get('/detailcalculate/{calculate_id}', "CalculateController@detailcalculate");
        Route::get('/detailcalculate', "CalculateController@detailcalculate")->name('manager.calculate.detailcalculate');
        Route::get('/report', "CalculateController@report")->name('manager.calculate.report');
        Route::get('/getcompanyperiods', "CalculateController@getcompanyperiods")->name('manager.calculate.getcompanyperiods');

    });
    Route::group(['prefix' => 'setting', 'namespace' => 'Setting'], function () {

        Route::get('/', "SettingController@index")->name('manager.setting.index');
        Route::post('/', "SettingController@index")->name('manager.setting.index');
        Route::get('/template_settings', "SettingController@template_settings")->name('manager.template_setting');
        Route::post('/template_settings', "SettingController@template_settings")->name('manager.template_setting');
        Route::get('/update_setting/{id?}/{value?}/{tip?}', "SettingController@updateSetting")->name('manager.update.setting');
        Route::get('/edit/{package_id}', 'SettingController@edit')->name('manager.setting.edit');
        Route::post('/edit/{package_id}', 'SettingController@edit');

        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagController@index')->name('manager.setting.tags');
            Route::get('/create', 'TagController@create')->name('manager.setting.tags.create');
            Route::post('/create', 'TagController@create');

            Route::get('/edit/{tag_id?}', 'TagController@edit')->name('manager.setting.tags.edit');
            Route::post('/edit/{tag_id?}', 'TagController@edit');

            Route::get('/delete/{tag_id?}', 'TagController@delete')->name('manager.setting.tags.delete');
            Route::get('/show/{tag_id?}', 'TagController@show')->name('manager.setting.tags.show');
        });
    });
    Route::group(['prefix' => 'invoice', 'namespace' => 'Invoice'], function () {
        Route::get('/', "InvoiceController@index")->name('manager.invoice.index');
        Route::get('/getbydate', "InvoiceController@getbydate")->name('manager.invoice.getbydate');
        Route::get('/filter', "InvoiceController@filter")->name('manager.invoice.filter');
        Route::get('/invoice/{invoiceid}', "InvoiceController@invoice")->name('manager.invoice.invoice');

        Route::get('/cancel/{invoiceid}', "InvoiceController@cancel")->name('manager.invoice.cancel');

        Route::get('/makepayment', "InvoiceController@makepayment")->name('manager.invoice.makepayment');
        Route::get('/create', "InvoiceController@create")->name('manager.invoice.create');
        Route::post('/create', "InvoiceController@create");
        Route::get('/getforinvoiceselect/{is_company}', "InvoiceController@getforinvoiceselect");
        Route::post('/calculatetax', "InvoiceController@calculatetax");

    });


    Route::group(['prefix' => 'invoicetemplate', 'namespace' => 'Template'], function () {

        Route::get('/', "InvoiceTemplateController@index")->name('manager.invoicetemplate.index');

        Route::get('/test', "InvoiceTemplateController@test");

        Route::get('/create', "InvoiceTemplateController@create")->name('manager.invoicetemplate.create');
        Route::post('/create', "InvoiceTemplateController@create");

        Route::get('/edit/{invoice_template_id}', 'InvoiceTemplateController@edit')->name('manager.invoicetemplate.edit');
        Route::post('/edit/{invoice_template_id}', 'InvoiceTemplateController@edit');

        // Route::get('/delete/{invoice_template_id}', 'InvoiceTemplateController@delete')->name('manager.invoicetemplate.delete');
        Route::post('/delete', 'InvoiceTemplateController@delete')->name('manager.invoicetemplate.delete');
    });
    Route::group(['prefix' => 'mailtemplate', 'namespace' => 'Template'], function () {

        Route::get('/', "MailTemplateController@index")->name('manager.mailtemplate.index');
        // Route::get('/delete/{mail_template_id}', 'MailTemplateController@delete');
        Route::post('/delete', 'MailTemplateController@delete');
        //AJAX
        Route::get('/gettemplate/{id}', 'MailTemplateController@gettemplate');
        Route::post('/savetemplate', 'MailTemplateController@savetemplate');
    });
    Route::group(['prefix' => 'smstemplate', 'namespace' => 'Template'], function () {

        Route::get('/', "SmsTemplateController@index")->name('manager.smstemplate.index');
        //  Route::get('/delete/{mail_template_id}', 'SmsTemplateController@delete');
        Route::post('/delete', 'SmsTemplateController@delete');
        //AJAX
        Route::get('/gettemplate/{id}', 'SmsTemplateController@gettemplate');
        Route::post('/savetemplate', 'SmsTemplateController@savetemplate');
    });
    Route::group(['prefix' => 'notificationtemplate', 'namespace' => 'Template'], function () {

        Route::get('/', "NotificationTemplateController@index")->name('manager.notificationtemplate.index');
        //  Route::get('/delete/{mail_template_id}', 'NotificationTemplateController@delete');
        Route::post('/delete', 'NotificationTemplateController@delete');
        //AJAX
        Route::get('/gettemplate/{id}', 'NotificationTemplateController@gettemplate');
        Route::post('/savetemplate', 'NotificationTemplateController@savetemplate');
    });
    Route::group(['prefix' => 'department', 'namespace' => 'Department'], function () {
////personel crud
        Route::get('/index/{role_id?}/{show?}', "DepartmentController@index")->name('manager.department.index');
        Route::get('/edit/{user_id?}', "DepartmentController@edit")->name('manager.department.edit');
        Route::get('/create/{role_id?}', "DepartmentController@create")->name('manager.department.create');
        Route::post('/process', "DepartmentController@process")->name('manager.department.process');
        Route::get('/share/template/{user_id?}/{role_id?}/{show?}', "DepartmentController@shareTemplate")->name('manager.department.sharetemplate');
        // Route::post('/share/process','DepartmentController@shareprocess')->name('manager.department.shareprocess');
        Route::post('/share/process', 'DepartmentController@shareprocess')->name('manager.department.shareprocess');
////personel crud


        Route::group(['prefix' => 'work', 'namespace' => 'Work'], function () {
            Route::get('/liste/{user_id}', 'PersonelWorkController@departmentwork')->name('manager.department.work');
            Route::get('/create/{user_id?}', 'PersonelWorkController@workcreate')->name('manager.department.work.create');
            Route::post('/workcreate', 'PersonelWorkController@workprocess')->name('manager.department.workcreate');
            Route::get('/workdelete/{work_id?}', 'PersonelWorkController@workdelete')->name('manager.work.delete');
            Route::get('/edit/{work_id?}', 'PersonelWorkController@workupdate')->name('manager.department.work.edit');
            Route::get('/weekly/{user_id?}', 'PersonelWorkController@workweekly')->name('manager.department.workweekly');
            Route::post('/weekly/update', 'PersonelWorkController@workweeklyupdate')->name('manager.department.workcreateprocess');
            Route::get('/timelineprocess', 'PersonelWorkController@weeklyProcess')->name('weeklyProcess');/////ajax


            Route::get('/timelineprocess', 'PersonelWorkController@weeklyProcess')->name('weeklyProcess');/////ajax

            Route::get('/template/{user_id?}', 'PersonelWorkController@workTemplate')->name('department.workTemplate');
            Route::get('/timelinetemplateprocess', 'PersonelWorkController@workTemplateProcess')->name('weeklyTemplateProcess');


            Route::get('/template/assign/{user_id?}', 'PersonelWorkController@workTemplateAssign')->name('department.workTemplate.assign');
            Route::post('/templateassign', 'PersonelWorkController@templateassign')->name('manager.department.templateassign');
        });
        Route::group(['prefix' => 'files', 'namespace' => 'File'], function () {
            Route::get('/userfiles/{user_id?}', 'PersonelFileController@userfiles')->name('manager.department.files');////users files
            Route::get('/create/{user_id?}', 'PersonelFileController@create')->name('manager.department.files.create');
            Route::get('/edit/{user_id?}/{file_id?}', 'PersonelFileController@edit')->name('manager.department.files.update');
            Route::post('/uploadfile', 'PersonelFileController@uploadfile')->name('manager.department.upload');///dosya insert / update
            //    Route::get('/deletefile/{file_id?}', 'PersonelFileController@delete')->name('manager.department.deletefile');
            Route::post('/deletefile', 'PersonelFileController@delete')->name('manager.department.deletefile');

        });

        Route::group(['prefix' => 'vacation', 'namespace' => 'Vacation'], function () {
            Route::get('/{user_id?}', 'PersonelVacationController@vacation')->name('manager.department.vacation');
            Route::get('/create/{user_id?}', 'PersonelVacationController@create')->name('manager.department.vacation.create');
            Route::post('/vacationcreate', 'PersonelVacationController@vacationprocess')->name('manager.department.vacationcreate');
            Route::get('/edit/{vacation_id?}', 'PersonelVacationController@edit')->name('manager.department.vacation.edit');
            //Route::get('/delete/{vacation_id?}', 'PersonelVacationController@delete')->name('manager.department.vacation.delete');
            Route::post('/delete', 'PersonelVacationController@delete')->name('manager.department.vacation.delete');
        });


    });
    Route::group(['prefix' => 'expenses', 'namespace' => 'Expense'], function () {
////personel crud
        Route::get('/', "ExpenseController@index")->name('manager.expenses.index');
        Route::get('/edit/{expense_id?}', "ExpenseController@edit")->name('manager.expenses.edit');
        Route::post('/edit/{expense_id?}', "ExpenseController@edit");
        Route::post('/delete', "ExpenseController@delete")->name('manager.expenses.delete');
        Route::get('/create/', "ExpenseController@create")->name('manager.expenses.create');
        Route::post('/create/', "ExpenseController@create");
        Route::get('/get_tank_cards/{user_id?}', "ExpenseController@getTankCards")->name('manager.expenses.getTankCards');
        Route::get('/get_company_drivers/{company_id?}', "ExpenseController@getCompanyDrivers")->name('manager.expenses.getCompanyDrivers');
        Route::get('/get_company_vehicles/{company_id?}', "ExpenseController@getCompanyVehicles")->name('manager.expenses.getCompanyVehicles');
        //getTankCards
        Route::group(['prefix' => 'types'], function () {
            Route::get('/', "ExpenseTypeController@index")->name('manager.expenses.types.index');
            Route::get('/edit/{expense_type_id?}', "ExpenseTypeController@edit")->name('manager.expenses.types.edit');
            Route::post('/edit/{expense_type_id?}', "ExpenseTypeController@edit");
            //Route::get('/delete/{expense_type_id?}', "ExpenseTypeController@delete")->name('manager.expenses.types.delete');
            Route::post('/delete', "ExpenseTypeController@delete")->name('manager.expenses.types.delete');
            Route::get('/create/', "ExpenseTypeController@create")->name('manager.expenses.types.create');
            Route::post('/create/', "ExpenseTypeController@create")->name('manager.expenses.types.create.post');
        });


    });
    Route::group(['prefix' => 'downloads'], function () {

        Route::get('/driverapk', 'HomeController@driverapk')->name('manager.downloads.driverapk');
        Route::get('/clientapk', 'HomeController@clientapk')->name('manager.downloads.clientapk');
    });
});
Route::group(['namespace' => 'DriverCompany', 'prefix' => 'driver_company', 'middleware' => 'role:driver_company'], function () {
    //   Route::get('/', 'HomeController@index');
    Route::get('/', 'HomeController@index')->name('driver_company');

    Route::group(['prefix' => 'vehicle', 'namespace' => 'Vehicle'], function () {

        Route::get('/', "VehicleController@index")->name('driver_company.vehicle.index');

        Route::get('/edit/{vehicle_id}', 'VehicleController@update')->name('driver_company.vehicle.edit');
        Route::post('/edit/{vehicle_id}', 'VehicleController@update');

        Route::get('/create', 'VehicleController@create')->name('driver_company.vehicle.create');
        Route::post('/create', 'VehicleController@create');

        Route::get('/delete/{vehicle_id}', 'VehicleController@delete')->name('driver_company.vehicle.delete');

        Route::get('/getmodels/{brand_id}', 'VehicleController@getmodels')->name('driver_company.vehicle.getmodels');


    });

    Route::group(['prefix' => 'expenses', 'namespace' => 'Expense'], function () {

        Route::get('/', "ExpenseController@index")->name('driver_company.expenses.index');
        Route::get('/edit/{expense_id?}', "ExpenseController@edit")->name('driver_company.expenses.edit');
        Route::post('/edit/{expense_id?}', "ExpenseController@edit");
        Route::get('/delete/{expense_id?}', "ExpenseController@delete")->name('driver_company.expenses.delete');
        Route::get('/create/', "ExpenseController@create")->name('driver_company.expenses.create');
        Route::post('/create/', "ExpenseController@create");


    });
    Route::group(['prefix' => 'order', 'namespace' => 'Order'], function () {
        Route::get('/orderlist/{driver_id?}', "OrderController@orderlist")->name('driver_company.order.orderlist');
        Route::post('/orderlist', "OrderController@orderlist");
        Route::get('/getorder/{order_id?}', 'OrderController@getorder');

    });
    Route::group(['prefix' => 'driver', 'namespace' => 'Driver'], function () {


        Route::get('/', "DriverController@index")->name('driver_company.driver.index');

        Route::get('/create', 'DriverController@create')->name('driver_company.driver.create');
        Route::post('/create', 'DriverController@create');

        Route::get('/update/{driver_id?}', 'DriverController@edit')->name('driver_company.driver.update');
        Route::post('/update/{driver_id?}', 'DriverController@edit');

        Route::get('/delete/{package_id}', 'DriverController@delete')->name('driver_company.driver.delete');
        Route::get('/profile/{id}', 'DriverController@profile')->name('driver_company.driver.profile');
        Route::get('/getvehicles/{company_id?}', 'DriverController@getvehicles')->name('driver_company.driver.getvehicles');
    });
});
Route::group(['namespace' => 'Driver', 'prefix' => 'driver', 'middleware' => 'role:driver'], function () {

    Route::get('/', 'Profile\ProfileController@index')->name('driver.profile.index');
    Route::post('/updateprofile', 'Profile\ProfileController@updateprofile')->name('driver.profile.updateprofile');
    Route::get('/getmodels/{id?}', 'Profile\ProfileController@getmodels')->name('driver.getmodels');

    Route::group(['prefix' => 'expenses', 'namespace' => 'Expense'], function () {

        Route::get('/', "ExpenseController@index")->name('driver.expenses.index');
        Route::get('/edit/{expense_id?}', "ExpenseController@edit")->name('driver.expenses.edit');
        Route::post('/edit/{expense_id?}', "ExpenseController@edit");
        Route::get('/delete/{expense_id?}', "ExpenseController@delete")->name('driver.expenses.delete');
        Route::get('/create/', "ExpenseController@create")->name('driver.expenses.create');
        Route::post('/create/', "ExpenseController@create");
        Route::get('/get_tank_cards/', "ExpenseController@getTankCards")->name('driver.expenses.getTankCards');

    });

});
Route::group(['namespace' => 'Common', 'prefix' => 'common', "middleware" => "auth"], function () {
    Route::group(['prefix' => 'autocomplate', 'namespace' => 'Autocomplate'], function () {

        Route::get('/select2', "AutocomplateController@select2")->name('common.autocomplate.select2');
        Route::post('/select2', "AutocomplateController@select2");

    });
    Route::group(['prefix' => 'datatable', 'namespace' => 'Datatable'], function () {
        Route::get('/main', "DatatableController@main")->name('common.datatable.main');
        Route::post('/main', "DatatableController@main");
    });
});

?>