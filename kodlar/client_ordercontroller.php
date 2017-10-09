<?php


<?php

namespace App\Http\Controllers\Client\Order;

use App\Helpers\OrderHelper\PriceHelper;
use App\Helpers\InvoiceHelper\InvoiceService;
use App\Http\Controllers\Controller;

use App\Models\Client;
use App\Models\ClientCompany;
use App\Models\ClientCompanyPivot;
use App\Models\Extra;
use App\Models\FavoriteDriver;
use App\Models\Job;
use App\Models\JobRating;
use App\Models\Order;
use App\Models\OrderExtra;
use App\Models\OrderMethod;
use App\Models\Package;
use App\Models\Driver;
use App\Models\Payment\PaymentType;
use App\Models\VehicleClass;
use App\Models\VehicleClassPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //OrderHistory
    public function index()
    {
     /*   $client = Client::where('user_id', Auth::id())->first();
        $clientsCompanies=ClientCompanyPivot::where('client_id','=',$client->id)->where('authorized','=',1)->get();
        $clientArray=array();

        foreach ($clientsCompanies as $clientsCompany){
            if($client->isManager($clientsCompany->client_company_id,$client->id)){//////admin to company
                $clients=ClientCompanyPivot::where('client_company_id','=',$clientsCompany->client_company_id)->pluck('client_id')->toArray();
            }else{////admin to dep
                $clients=ClientCompanyPivot::where('client_company_id','=',$clientsCompany->client_company_id)
                    ->where('client_company_department_id','=',$clientsCompany->client_company_department_id)->pluck('client_id')->toArray();
            }
            $clientArray=array_merge($clients,$clientArray);
        }



        $model = Order::with('client.favoritedrivers', 'package', 'jobs')
            ->whereIn('client_id', $clientArray)
            ->orderBy('orders.id', 'desc')
            ->get();

      /*  foreach ($model as $m){
            dd($m->client->companies[1]->client_company_department->department_name);
        }*/


        //return view('themes.' . static::$tf . '.client.order.index', ['model' => $model]);
        return "ok";

    }

    //Orders

    public function orderlist(Request $request)
    {
        $client = Client::where('user_id', Auth::id())->first();
        $clientsCompanies=ClientCompanyPivot::where('client_id','=',$client->id)->where('authorized','=',1)->get();
        $clientArray=array();

        foreach ($clientsCompanies as $clientsCompany){
            if($client->isManager($clientsCompany->client_company_id,$client->id)){//////admin to company
                $clients=ClientCompanyPivot::where('client_company_id','=',$clientsCompany->client_company_id)->pluck('client_id')->toArray();
            }else{////admin to dep
                $clients=ClientCompanyPivot::where('client_company_id','=',$clientsCompany->client_company_id)
                    ->where('client_company_department_id','=',$clientsCompany->client_company_department_id)->pluck('client_id')->toArray();
            }
            $clientArray=array_merge($clients,$clientArray);
        }


        $filterstartdate = $request->has('filterstartdate') ?
            $request->input('filterstartdate') :
            Carbon::now()->format('Y-m-d');

        $filterenddate = $request->has('filterenddate') ?
            $request->input('filterenddate') :
            Carbon::now()->format('Y-m-d');

        $model = Order::with('client.favoritedrivers', 'package', 'jobs', 'client.user')
            ->whereIn('client_id', $clientArray)
            ->whereBetween('start_time', [$filterstartdate . ' 00:00:00', $filterenddate . ' 23:59:59'])
            ->orderBy('id', 'desc')
            ->get();

        return view('themes.' . static::$tf . '.client.order.list', [
            'model' => $model,
            'startdate' => $filterstartdate,
            'enddate' => $filterenddate
        ]);
    }

    public function getorder(Request $request, $id = NULL)
    {
        return view('themes.' . static::$tf . '.client.order.profile', [
            'order' => Order:: with([
                'jobs.driver.user',
                'jobs.vehicleclass',
                'client.user'
                , 'clientcompany'
                , 'paymenttype'
                , 'locations.startlocation'
                , 'locations.endlocation'
            ])->find($id)
        ]);
    }

    public function rate(Request $request)
    {
        $jobsRating = new JobRating();
        $jobsRating->client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;
        $jobsRating->job_id = $request->input('job_id');
        $jobsRating->driver_id = Job::find($request->input('job_id'))->driver_id;
        $jobsRating->score = $request->input('rate-star');
        $jobsRating->comment = $request->input('comment');
        $jobsRating->save();
        return redirect('client/order');
    }

    public function getrate(Request $request, $id = null)
    {
        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;
        $model = JobRating::where('client_id', $client_id)->where('job_id', $id)->get()->first();
        if (isset($model)) {
            return $model;
        }
    }

    public function removefavorite(Request $request, $id = null)
    {
        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;
        $model = FavoriteDriver::where('client_id', $client_id)
            ->where('driver_id', $id)
            ->where('status', 1)
            ->get()->first();
        $model->status = 0;
        $model->save();
        return "ok";
    }

    public function addtofavorite(Request $request, $id = null)
    {
        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;
        $favorite = FavoriteDriver::where('client_id', $client_id)
            ->where('driver_id', $id)
            ->where('status', 0)
            ->get()->first();

        if (isset($favorite)) {
            $favorite->status = 1;
            $favorite->save();
        } else {
            $model = new FavoriteDriver();
            $model->driver_id = $id;
            $model->client_id = $client_id;
            $model->status = 1;
            $model->save();
        }

        return "ok";
    }


    public function updateform(Request $request, $id = NULL)
    {


        if ($request->isMethod('post')) {

            $Job = Job::with('order')->find($request['jobid']);
            $model = Order:: with(['jobs.driver.user', 'jobs.vehicleclass', 'client.user', 'clientcompany', 'paymenttype', 'package'])->find($Job->order_id);
            \DB::transaction(function () use ($request, $Job) {
                if ($request['driver'] == 0) $request['driver'] = null;
                $Job->driver_id = $request['driver'];
                $Job->order->start_time = Carbon::parse($request['orderdate'])->toDateTimeString();
                $Job->order->note = $request['note'];
                $Job->vehicle_class_id = $request->input('vehicleclass');
                $Job->order->drivernote = $request['drivernote'];
                $Job->order->kostenstelle = $request['kostenstelle'];
                $Job->order->payment_type_id = $request->input('paymenttype');
                $Job->order->number_of_passengers = $request->input('number_of_passengers');
                $Job->order->payment_status = $request->input('payment_status');
                $Job->order->order_method_id = $request->input('ordermethod') ? $request->input('ordermethod') : 0;
                $Job->order->save();
                $Job->save();


                $PriceHelper = new PriceHelper();

                $res = $PriceHelper->GetPrice($Job->order->client_id, $request->input('vehicleclass'), $Job->order->package_id, $Job->order->kilometer);
                $_price = $res->DefaultPrice;
                $_specialprice = $res->SpecialPrice;

                $Job->order->price = $_price;
                $Job->order->discount = $_specialprice != 0 ? $_price - $_specialprice : $_specialprice;
                $Job->order->save();
                //todo how to add extras into invoice ??


                $extralist = json_decode($request->input('extralist_modal'));
                $passengerlist = json_decode($request->input('passengerlist_modal'));

                $Extras = array();
                if (is_array($extralist)) {
                    foreach ($extralist as $extra) {
                        $NewOrderExtra = new  OrderExtra();
                        $NewOrderExtra->order_id = $Job->order_id;
                        $NewOrderExtra->extra_id = $extra->extraid;
                        $NewOrderExtra->price = $extra->extraprice;
                        $NewOrderExtra->save();

                        $Item = new \stdClass();
                        $Item->id = $NewOrderExtra->id;
                        $Item->name = Extra::where('id', '=', $extra->extraid)->get()->first()->name;
                        $Item->price = $extra->extraprice;
                        array_push($Extras, $Item);

                    }
                }
                if (is_array($passengerlist)) {
                    foreach ($passengerlist as $passenger) {
                        $NewOrderPassenger = new Passenger();
                        $NewOrderPassenger->gsm_phone = $passenger->gsm_phone;
                        $NewOrderPassenger->passenger_name = $passenger->passenger_name;
                        $NewOrderPassenger->save();

                        $OrderLocation = new OrderLocation();
                        $OrderLocation->order_id = $Job->order->id;
                        $OrderLocation->start_location_id = $Job->order->locations->first() != null ? $Job->order->locations->first()->start_location_id : 0;
                        $OrderLocation->end_location_id = $Job->order->locations->first() != null ? $Job->order->locations->first()->end_location_id : 0;
                        $OrderLocation->passenger_id = $NewOrderPassenger->id;
                        $OrderLocation->save();
                        if ($passenger->flight_number != "" || $passenger->flight_from != "" || $passenger->flight_company != "") {
                            $Job->order->flight_number = $passenger->flight_number;
                            $Job->order->flight_from = $passenger->flight_from;
                            $Job->order->flight_company = $passenger->flight_company;
                            $Job->order->save();
                        }
                    }
                }
                InvoiceService::updateInvoiceInstant($Job->order, $Extras);
            });
            return response()->json('ok');
        }

        $job = Job::where("id", '=', $id)->get();
        $model = Order:: with(['jobs.driver.user', 'jobs.vehicleclass', 'client.user', 'clientcompany', 'paymenttype', 'package', 'locations.startlocation', 'locations.endlocation'])->find($job[0]->order_id);
        $vehicles = VehicleClass::all();
        // $drivers = Driver::with('user')->get();
        $start_time = Carbon::parse($model->start_time)->format('Y-m-d H:i');


        //$duration=($model->package()->duration)

        $driver_id = isset($model->jobs[0]->driver) ? $model->jobs[0]->driver->user->id : 0;

        $drivers = Driver::with('user')->NotWorkAt($start_time, $model->duration, $driver_id)
            ->get();
        $ordermethods = OrderMethod::all();
        $paymenttypes = PaymentType::all();


        $driver_id = (isset($model->jobs[0]->driver)) ? $model->jobs[0]->driver->id : 0;




     return view('themes.' . static::$tf . '.client.order.updateorder', [
            'model' => $model,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'driver_id' => $driver_id,
            'ordermethods' => $ordermethods,
            'paymenttypes' => $paymenttypes,
        ]);


    }

    public function getorderhistory(Request $request, $client_id)
    {
        $model = Order::with('client', 'package', 'jobs', 'jobs.driver.user')
            ->where('client_id', $client_id)
            ->where('is_complated', 1)
            ->get();
        $html = "";
        if (isset($model)) {
            foreach ($model as $m) {
                if ($m->package->is_trip == 1) {
                    $html .= "<a href='javascript:getReorder(" . $m->id . ");'><li class='list-group-item'><h3 class='package_name'>" . $m->package->name . "</h3><p class='order_date'>" . Carbon::parse($m->created_at)->format('d.m.Y H:i:s') . "</p></li></a>";
                } else {
                    $html .= "<a href='javascript:getReorder(" . $m->id . ");'><li class='list-group-item'><h3 class='package_name'>" . $m->start_address . " to " . $m->end_address . "</h3><p class='order_date'>" . Carbon::parse($m->created_at)->format('d.m.Y H:i:s') . "</p></li></a>";

                }
            }
        }
        return response($html, 200);
    }

    public function update(Request $request, $id = null)
    {

        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;
        $Order = Order::with('jobs')->where('orders.id', $id)
            ->where('client_id', $client_id)
            ->get()->first();
        $Jobs = Job::where('order_id', $id)
            ->join('vehicle_classes', 'vehicle_classes.id', '=', 'jobs.vehicle_class_id')
            ->groupBy('vehicle_class_id')
            ->get(['vehicle_class_id as id', 'name', \DB::raw('count(*) as quantity')]);


        if ($request->isMethod('post')) {
            //TODO: Jobs status unkonwn....
            dd($request);

            $carlist = json_decode($request->input('carlist'));
            $packageID = $request->input('package');
            $clientID = Client::where('user_id', Auth::user()->id)->get()->first()->id;
            $startDate = $request->input('start_date');
            $price = $request->input('price');
            $paymentTypeID = $request->input('payment_type_id');
            $comment = $request->input('comment');
            $duration = $request->input('duration');
            $kiloMeter = $request->input('kilometer');
            $startLocation = json_decode($request->input('startlocation'));
            $endLocation = json_decode($request->input('endlocation'));
            $startAddress = $request->input('startaddress');
            $endAddress = $request->input('endaddress');
            $paymentStatus = $request->input('payment_status');
            $numberOfPassengers = $request->input('number_of_passengers');
            $vehicleClassID = $request->input('vehicle_class');
            $Order = Order::where('orders.id', $id)
                ->where('client_id', $client_id)
                ->get()->first();
            $Order->start_time = $startDate;
            $Order->duration = $duration;
            $Order->start_address = $startAddress;
            $Order->kilometer = $kiloMeter;
            $Order->end_address = $endAddress;
            $Order->number_of_passengers = $numberOfPassengers;
            $Order->payment_type_id = $paymentTypeID;
            $Order->comment = $comment;
            $Order->payment_status = $paymentStatus;
            $Order->client_id = $clientID;
            $Order->package_id = $packageID;

            if (isset($startLocation->lat)) {
                $Order->start_location_lat = $startLocation->lat;
                $Order->start_location_lon = $startLocation->lon;
            }
            if (isset($endLocation->lat)) {
                $Order->end_location_lat = $endLocation->lat;
                $Order->end_location_lon = $endLocation->lon;
            }

            $Order->price = $price;//todo recalculate and check correct price

            $Order->save();

            if (count($carlist) > 0) {
                foreach ($carlist as $car) {
                    for ($i = 0; $i < $car->quantity; $i++) {
                        $Job = new Job();
                        $Job->order_id = $Order->id;
                        $Job->vehicle_class_id = $car->id;
                        $Job->save();
                    }
                }
            } else {
                $Job = new Job();
                $Job->order_id = $Order->id;
                $Job->vehicle_class_id = $vehicleClassID;
                $Job->save();
            }
            return redirect()->route('client.order.index');
        }


        $StartLocation = new \stdClass();
        $StartLocation->lat = $Order->start_location_lat;
        $StartLocation->lon = $Order->start_location_lon;

        $EndLocation = new \stdClass();
        $EndLocation->lat = $Order->end_location_lat;
        $EndLocation->lon = $Order->end_location_lon;

        $Model = new \stdClass();
        $Model->Order = $Order;
        $Model->Jobs = $Jobs;
        $Model->CarList = json_encode($Jobs);
        $Model->StartLocation = json_encode($StartLocation);
        $Model->EndLocation = json_encode($EndLocation);
        $VehicleClasses = VehicleClass::all();
        $Packages = Package::all();
        $PaymentTypes = PaymentType::all();
        $Drivers = Driver::with('company', 'user')
            ->join('users', 'users.id', '=', 'drivers.user_id')
            ->get();


        return view('themes.' . static::$tf . '.client.order.update', [
            'Packages' => $Packages,
            'Drivers' => $Drivers,
            'PaymentTypes' => $PaymentTypes,
            'VehicleClasses' => $VehicleClasses,
            'Model' => $Model
        ]);

    }

    public function copy(Request $request, $id = null)
    {

        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;

        if ($request->isMethod('post')) {

            $carlist = json_decode($request->input('carlist'));
            $packageID = $request->input('package');
            $clientID = Client::where('user_id', Auth::user()->id)->get()->first()->id;
            $startDate = $request->input('start_date');
            $price = $request->input('price');
            $paymentTypeID = $request->input('payment_type_id');
            $comment = $request->input('comment');
            $duration = $request->input('duration');
            $kiloMeter = $request->input('kilometer');
            $startLocation = json_decode($request->input('startlocation'));
            $endLocation = json_decode($request->input('endlocation'));
            $startAddress = $request->input('startaddress');
            $endAddress = $request->input('endaddress');
            $paymentStatus = $request->input('payment_status');
            $numberOfPassengers = $request->input('number_of_passengers');
            $vehicleClassID = $request->input('vehicle_class');
            $Order = new Order();
            $Order->start_time = $startDate;
            $Order->duration = $duration;
            $Order->start_address = $startAddress;
            $Order->kilometer = $kiloMeter;
            $Order->end_address = $endAddress;
            $Order->number_of_passengers = $numberOfPassengers;
            $Order->payment_type_id = $paymentTypeID;
            $Order->comment = $comment;
            $Order->payment_status = $paymentStatus;
            $Order->client_id = $clientID;
            $Order->package_id = $packageID;

            if (isset($startLocation->lat)) {
                $Order->start_location_lat = $startLocation->lat;
                $Order->start_location_lon = $startLocation->lon;
            }
            if (isset($endLocation->lat)) {
                $Order->end_location_lat = $endLocation->lat;
                $Order->end_location_lon = $endLocation->lon;
            }

            $Order->price = $price;//todo recalculate and check correct price

            $Order->save();
            ///dd($Order->id);
            if (count($carlist) > 0) {
                foreach ($carlist as $car) {
                    for ($i = 0; $i < $car->quantity; $i++) {
                        $Job = new Job();
                        $Job->order_id = $Order->id;
                        $Job->vehicle_class_id = $car->id;
                        $Job->save();
                    }
                }
            } else {
                $Job = new Job();
                $Job->order_id = $Order->id;
                $Job->vehicle_class_id = $vehicleClassID;
                $Job->save();
            }
            return redirect()->route('client.order.orders');
        }

        $Order = Order::where('orders.id', $id)
            ->where('client_id', $client_id)
            ->get()->first();
        $Jobs = Job::where('order_id', $id)
            ->join('vehicle_classes', 'vehicle_classes.id', '=', 'jobs.vehicle_class_id')
            ->groupBy('vehicle_class_id')
            ->get(['vehicle_class_id as id', 'name', \DB::raw('count(*) as quantity')]);

        $StartLocation = new \stdClass();
        $StartLocation->lat = $Order->start_location_lat;
        $StartLocation->lon = $Order->start_location_lon;

        $EndLocation = new \stdClass();
        $EndLocation->lat = $Order->end_location_lat;
        $EndLocation->lon = $Order->end_location_lon;

        $Model = new \stdClass();
        $Model->Order = $Order;
        $Model->Jobs = $Jobs;
        $Model->CarList = json_encode($Jobs);
        $Model->StartLocation = json_encode($StartLocation);
        $Model->EndLocation = json_encode($EndLocation);

        $VehicleClasses = VehicleClass::all();
        $Packages = Package::all();
        $PaymentTypes = PaymentType::all();
        $Drivers = Driver::with('company', 'user')
            ->join('users', 'users.id', '=', 'drivers.user_id')
            ->get();


        return view('themes.' . static::$tf . '.client.order.copy', [
            'Packages' => $Packages,
            'Drivers' => $Drivers,
            'PaymentTypes' => $PaymentTypes,
            'VehicleClasses' => $VehicleClasses,
            'Model' => $Model
        ]);

    }

    public function opposite(Request $request, $id = null)
    {

        $client_id = Client::where('user_id', Auth::user()->id)->get()->first()->id;

        if ($request->isMethod('post')) {

            $carlist = json_decode($request->input('carlist'));
            $packageID = $request->input('package');
            $clientID = Client::where('user_id', Auth::user()->id)->get()->first()->id;
            $startDate = $request->input('start_date');
            $price = $request->input('price');
            $paymentTypeID = $request->input('payment_type_id');
            $comment = $request->input('comment');
            $duration = $request->input('duration');
            $kiloMeter = $request->input('kilometer');
            $startLocation = json_decode($request->input('startlocation'));
            $endLocation = json_decode($request->input('endlocation'));
            $startAddress = $request->input('startaddress');
            $endAddress = $request->input('endaddress');
            $paymentStatus = $request->input('payment_status');
            $numberOfPassengers = $request->input('number_of_passengers');
            $vehicleClassID = $request->input('vehicle_class');
            $Order = new Order();
            $Order->start_time = $startDate;
            $Order->duration = $duration;
            $Order->start_address = $startAddress;
            $Order->kilometer = $kiloMeter;
            $Order->end_address = $endAddress;
            $Order->number_of_passengers = $numberOfPassengers;
            $Order->payment_type_id = $paymentTypeID;
            $Order->comment = $comment;
            $Order->payment_status = $paymentStatus;
            $Order->client_id = $clientID;
            $Order->package_id = $packageID;

            if (isset($startLocation->lat)) {
                $Order->start_location_lat = $startLocation->lat;
                $Order->start_location_lon = $startLocation->lon;
            }
            if (isset($endLocation->lat)) {
                $Order->end_location_lat = $endLocation->lat;
                $Order->end_location_lon = $endLocation->lon;
            }

            $Order->price = $price;//todo recalculate and check correct price

            $Order->save();
            ///dd($Order->id);
            if (count($carlist) > 0) {
                foreach ($carlist as $car) {
                    for ($i = 0; $i < $car->quantity; $i++) {
                        $Job = new Job();
                        $Job->order_id = $Order->id;
                        $Job->vehicle_class_id = $car->id;
                        $Job->save();
                    }
                }
            } else {
                $Job = new Job();
                $Job->order_id = $Order->id;
                $Job->vehicle_class_id = $vehicleClassID;
                $Job->save();
            }
            return redirect()->route('client.order.index');
        }

        $Order = Order::where('orders.id', $id)
            ->where('client_id', $client_id)
            ->get()->first();
        $Jobs = Job::where('order_id', $id)
            ->join('vehicle_classes', 'vehicle_classes.id', '=', 'jobs.vehicle_class_id')
            ->groupBy('vehicle_class_id')
            ->get(['vehicle_class_id as id', 'name', \DB::raw('count(*) as quantity')]);

        $StartLocation = new \stdClass();
        $StartLocation->lat = $Order->start_location_lat;
        $StartLocation->lon = $Order->start_location_lon;

        $EndLocation = new \stdClass();
        $EndLocation->lat = $Order->end_location_lat;
        $EndLocation->lon = $Order->end_location_lon;

        $Model = new \stdClass();
        $Model->Order = $Order;
        $Model->Jobs = $Jobs;
        $Model->CarList = json_encode($Jobs);
        $Model->StartLocation = json_encode($StartLocation);
        $Model->EndLocation = json_encode($EndLocation);

        $VehicleClasses = VehicleClass::all();
        $Packages = Package::all();
        $PaymentTypes = PaymentType::all();
        $Drivers = Driver::with('company', 'user')
            ->join('users', 'users.id', '=', 'drivers.user_id')
            ->get();


        return view('themes.' . static::$tf . '.client.order.opposite', [
            'Packages' => $Packages,
            'Drivers' => $Drivers,
            'PaymentTypes' => $PaymentTypes,
            'VehicleClasses' => $VehicleClasses,
            'Model' => $Model
        ]);

    }



    public function create(Request $request)
    {



        if ($request->isMethod('post')) {

            $data["message"] = DB::transaction(function () use ($request) {
                $paymentMethodNonce = $request->input("payload_nonce");
                $is_trip = $request->input('is_trip');
                $packageid = $request->input('package');
                $extralist = json_decode($request->input('extralist'));
                $passengerlist = json_decode($request->input('passengerlist'));
                $origins = $request->input('originlist');
                $roadmap_order = $request->input('roadmaporderlist');


                if ($is_trip == 0) {
                    $packageid = $request->input('calculated_packageid');
                }
                $Package = Package::find($packageid);

                $Order = new Order();
                $Order->start_time = Carbon::parse($request->input('start_date'))->toDateTimeString();
                $Order->duration = $request->input('duration') ? $request->input('duration') : ($Package->duration ? $Package->duration : 90);
                $Order->kilometer = $request->input('kilometer');;
                $Order->number_of_passengers = $request->input('number_of_passengers');
                $Order->payment_type_id = $request->input('payment_type_id');
                $Order->comment = $request->input('comment');
                $Order->payment_status = $request->input('payment_status');
                $Order->client_id = $request->input('client');

                if ($request->input('personal_order') == 1) {

                    $Order->client_company_id = $request->input('client_company');
                    $Order->client_company_department_id = $request->input('client_company_department');

                } else {
                    $Order->client_company_id = 0;
                    $Order->client_company_department_id = 0;
                }

                $Order->package_id = $Package->id;
                $Order->kostenstelle = $request->input('kostenstelle');


                $Order->order_method_id = $request->input('order_method_id') ? $request->input('order_method_id') : 0;


                $PriceHelper = new PriceHelper();

                $res = $PriceHelper->GetPrice($Order->client_id, $request->input('vehicle_class'), $Order->package_id, $Order->kilometer);
                $_price = $res->DefaultPrice;
                $_specialprice = $res->SpecialPrice;

                $passenger_count=count($passengerlist);
                $passengerprice = $passenger_count * $Package->per_passenger_price;
                $Order->extra_passenger_price=$passengerprice;
                $Order->price = $_price;
                $Order->discount = $_specialprice != 0 ? $_price - $_specialprice : $_specialprice;
                $Order->save();


                if (count($passengerlist) > 0) {
                    //There is passangers so we must find roadmaporders...
                    $RoadMapLocations = [];


                    $roadmap_order = str_replace("[", "", $roadmap_order);
                    $roadmap_order = str_replace("]", "", $roadmap_order);
                    $origins = str_replace('["', "", $origins);
                    $origins = str_replace('"]', "", $origins);


                    if ($roadmap_order != "") {
                        // If passenger has start location and end location

                        $roadmap_order = explode(",", $roadmap_order);
                        $origins = explode('","', $origins);
                        for ($i = 0; $i < count($roadmap_order); $i++) {

                            $index = $roadmap_order[$i];

                            $roadmap = new \stdClass();
                            $roadmap->address = $origins[$index];
                            $roadmap->order = $i + 1;

                            array_push($RoadMapLocations, $roadmap);

                        }

                        $startorder = 0;
                        $endorder = 0;


                        foreach ($RoadMapLocations as $roadMapLocation) {
                            if ($roadMapLocation->address == $request->input('from_actb')) {
                                $startorder = $roadMapLocation->order;
                                break;
                            }
                        }
                        foreach ($RoadMapLocations as $roadMapLocation) {
                            if ($roadMapLocation->address == $request->input('to_actb')) {
                                $endorder = $roadMapLocation->order;
                                break;
                            }
                        }

                    } else {
                        $startorder = 1;
                        $endorder = 2;
                    }

                    if ($is_trip == 0) {
                        $Location = new Location();
                        $Location->address = $request->input('from_actb');
                        $startLocation = json_decode($request->input('startlocation'));
                        if (isset($startLocation->lat)) {
                            $Location->lat = $startLocation->lat;
                            $Location->lon = $startLocation->lon;
                        }
                        $Location->geocode = $request->input('startlocation_geocode');
                        $Location->place_id = $request->input('startlocation_placeid');
                        $Location->address_note = $request->input('startaddressnote');
                        $Location->roadmap_order = $startorder;
                        $Location->save();

                        $StartLocationID = $Location->id;

                        $Location = new Location();
                        $Location->address = $request->input('to_actb');
                        $endLocation = json_decode($request->input('endlocation'));
                        if (isset($endLocation->lat)) {
                            $Location->lat = $endLocation->lat;
                            $Location->lon = $endLocation->lon;
                        }
                        $Location->geocode = $request->input('endlocation_geocode');
                        $Location->place_id = $request->input('endlocation_placeid');
                        $Location->address_note = $request->input('endaddressnote');
                        $Location->roadmap_order = $endorder;
                        $Location->save();

                        $EndLocationID = $Location->id;

                        $OrderLocation = new OrderLocation();
                        $OrderLocation->client_id = $Order->client_id;
                        $OrderLocation->order_id = $Order->id;
                        $OrderLocation->start_location_id = $StartLocationID;
                        $OrderLocation->end_location_id = $EndLocationID;
                        $OrderLocation->save();
                        if (is_array($passengerlist)) {
                            foreach ($passengerlist as $passenger) {
                                $flightNumber = $passenger->flight_number;
                                $flightFrom = $passenger->flight_from;
                                $flightCompany = $passenger->flight_company;

                                if ($flightNumber != "" || $flightFrom != "" || $flightCompany != "") {
                                    $Order->flight_number = $flightNumber;
                                    $Order->flight_from = $flightFrom;
                                    $Order->flight_company = $flightCompany;
                                    $Order->save();
                                }


                                $passenger_is_client = $passenger->passenger_is_client;


                                if ($roadmap_order != "") {
                                    // If passenger has start location and end location
                                    $start_order = 0;
                                    $end_order = 0;
                                    foreach ($RoadMapLocations as $roadMapLocation) {
                                        if ($roadMapLocation->address == $passenger->start_location) {
                                            $start_order = $roadMapLocation->order;
                                            break;
                                        }
                                    }

                                    foreach ($RoadMapLocations as $roadMapLocation) {
                                        if ($roadMapLocation->address == $passenger->end_location) {
                                            $end_order = $roadMapLocation->order;
                                            break;
                                        }
                                    }

                                    $Location = new Location();
                                    $Location->address = $passenger->start_location;
                                    $Location->lat = $passenger->start_location_lat;
                                    $Location->lon = $passenger->start_location_lon;
                                    $Location->geocode = $passenger->start_location_geocode;
                                    $Location->place_id = $passenger->start_location_placeid;
                                    $Location->roadmap_order = $start_order;
                                    $Location->save();

                                    $StartLocationID = $Location->id;

                                    $Location = new Location();
                                    $Location->address = $passenger->end_location;
                                    $Location->lat = $passenger->end_location_lat;
                                    $Location->lon = $passenger->end_location_lon;
                                    $Location->geocode = $passenger->end_location_geocode;
                                    $Location->place_id = $passenger->end_location_placeid;
                                    $Location->roadmap_order = $end_order;
                                    $Location->save();

                                    $EndLocationID = $Location->id;


                                    if ($passenger_is_client != 1) {
                                        $NewPassenger = new Passenger();
                                        $NewPassenger->gsm_phone = $passenger->gsm_phone;
                                        $NewPassenger->passenger_name = $passenger->passenger_name;
                                        $NewPassenger->save();

                                        $OrderLocation = new OrderLocation();
                                        $OrderLocation->order_id = $Order->id;
                                        $OrderLocation->passenger_id = $NewPassenger->id;
                                        $OrderLocation->start_location_id = $StartLocationID;
                                        $OrderLocation->end_location_id = $EndLocationID;
                                        $OrderLocation->save();

                                    } else {
                                        $OrderLocation = new OrderLocation();
                                        $OrderLocation->order_id = $Order->id;
                                        $OrderLocation->client_id = $passenger->passenger_client_id;
                                        $OrderLocation->start_location_id = $StartLocationID;
                                        $OrderLocation->end_location_id = $EndLocationID;
                                        $OrderLocation->save();

                                    }
                                } else {
                                    //If passenger has no locations...
                                    if ($passenger_is_client != 1) {
                                        $NewPassenger = new Passenger();
                                        $NewPassenger->gsm_phone = $passenger->gsm_phone;
                                        $NewPassenger->passenger_name = $passenger->passenger_name;
                                        $NewPassenger->save();


                                        $OrderLocation = new OrderLocation();
                                        $OrderLocation->order_id = $Order->id;
                                        $OrderLocation->passenger_id = $NewPassenger->id;
                                        $OrderLocation->start_location_id = $StartLocationID;
                                        $OrderLocation->end_location_id = $EndLocationID;
                                        $OrderLocation->save();

                                    } else {
                                        $OrderLocation = new OrderLocation();
                                        $OrderLocation->order_id = $Order->id;
                                        $OrderLocation->client_id = $passenger->passenger_client_id;
                                        $OrderLocation->start_location_id = $StartLocationID;
                                        $OrderLocation->end_location_id = $EndLocationID;
                                        $OrderLocation->save();
                                    }

                                }


                            }
                        }
                    }


                } else {
                    //There is no extra passengers.
                    if ($is_trip == 0) {
                        $Location = new Location();
                        $Location->address = $request->input('from_actb');
                        $startLocation = json_decode($request->input('startlocation'));
                        if (isset($startLocation->lat)) {
                            $Location->lat = $startLocation->lat;
                            $Location->lon = $startLocation->lon;
                        }
                        $Location->geocode = $request->input('startlocation_geocode');
                        $Location->place_id = $request->input('startlocation_placeid');
                        $Location->address_note = $request->input('startaddressnote');
                        $Location->roadmap_order = 1;
                        $Location->save();

                        $StartLocationID = $Location->id;

                        $Location = new Location();
                        $Location->address = $request->input('to_actb');
                        $endLocation = json_decode($request->input('endlocation'));
                        if (isset($endLocation->lat)) {
                            $Location->lat = $endLocation->lat;
                            $Location->lon = $endLocation->lon;
                        }
                        $Location->geocode = $request->input('endlocation_geocode');
                        $Location->place_id = $request->input('endlocation_placeid');
                        $Location->address_note = $request->input('endaddressnote');
                        $Location->roadmap_order = 2;
                        $Location->save();

                        $EndLocationID = $Location->id;

                        $OrderLocation = new OrderLocation();
                        $OrderLocation->client_id = $Order->client_id;
                        $OrderLocation->order_id = $Order->id;
                        $OrderLocation->start_location_id = $StartLocationID;
                        $OrderLocation->end_location_id = $EndLocationID;
                        $OrderLocation->save();
                    }

                }


                $Extras = array();
                if (is_array($extralist)) {
                    foreach ($extralist as $extra) {
                        $NewOrderExtra = new  OrderExtra();
                        $NewOrderExtra->order_id = $Order->id;
                        $NewOrderExtra->extra_id = $extra->extraid;
                        $NewOrderExtra->price = $extra->extraprice;
                        $NewOrderExtra->save();

                        $Item = new \stdClass();
                        $Item->id = $NewOrderExtra->id;
                        $Item->name = Extra::where('id', '=', $extra->extraid)->get()->first()->name;
                        $Item->price = $extra->extraprice;
                        array_push($Extras, $Item);
                    }
                }


                $Invoice = InvoiceService::createInvoice($Order, $Extras,$passenger_count);
                $Job = new Job();
                $Job->order_id = $Order->id;
                $Job->vehicle_class_id = $request->input('vehicle_class');
                $Job->driver_id = $request->input('driver') ? $request->input('driver') : 0;
                $Job->save();
                //PAYMENT SECTION START

                $client = Client::with("user")->find($Order->client_id);
                if (!isset($client->user->braintree_customer_id)) {
                    $Vault = $this->saveBrainTreeCustomer($client, $paymentMethodNonce);
                    if ($Vault->status == "success") {
                        $result = Braintree_Transaction::sale([
                            'amount' => number_format($Invoice->invoice_amount, 2),
                            'paymentMethodToken' => $Vault->payment_method_token,

                        ]);

                        $User = User::find($client->user_id);
                        $User->braintree_customer_id = $Vault->customer_id;
                        $User->save();

                    } else {
                        $TransactionErrorLog = new TransactionErrorLog();
                        $TransactionErrorLog->invoice_id = $Invoice->id;
                        $TransactionErrorLog->error_type = "Vault Error";
                        $TransactionErrorLog->error = $Vault->errors;
                        $TransactionErrorLog->save();
                        $message = "";
                        foreach ($Vault->errors as $error) {
                            $message .= " " . $error->code . " - " . $error->message;
                        }
                        return $message;

                    }

                } else {
                    $result = Braintree_Transaction::sale([
                        'amount' => number_format($Invoice->invoice_amount, 2),
                        'paymentMethodNonce' => $paymentMethodNonce,
                        'options' => [
                            'submitForSettlement' => True
                        ]

                    ]);

                }
                //--->...<---//
                if ($result->success == "true") {
                    $BrainTree = new BraintreeSubscription();
                    $BrainTree->invoice_id = $Invoice->id;
                    $BrainTree->braintree_id = $result->transaction->id;
                    $BrainTree->amount = $result->transaction->amount;
                    $BrainTree->save();

                    $TransactionLog = new TransactionLog();
                    $TransactionLog->invoice_id = $Invoice->id;
                    $TransactionLog->braintree_subscription_id = $BrainTree->id;
                    $TransactionLog->result = $result;
                    $TransactionLog->save();

                } else {
                    $TransactionErrorLog = new TransactionErrorLog();
                    $TransactionErrorLog->invoice_id = $Invoice->id;
                    $TransactionErrorLog->error_type = "Payment Error";
                    $TransactionErrorLog->error = $result;
                    $TransactionErrorLog->save();
                    return $result;
                }
                //--->PAYMENT SECTION END

                return "success";
            });
            if ($data["message"] != "success")
                return response($data, 422);
            else
                return response("ok", 200);


        }

        $VehicleClasses = VehicleClass::all();
        $Packages = Package::CommonPackages()->where('is_trip', '=', '1')->get();

        $PaymentTypes = PaymentType::all();

        $ClientCompanies = ClientCompany::all();
        $Extras = Extra::all();
        $OrderMethod = OrderMethod::all();
        return view('themes.' . static::$tf . '.common.order.createnew', [
            'Packages' => $Packages,
            'PaymentTypes' => $PaymentTypes,
            'VehicleClasses' => $VehicleClasses,
            'Extras' => $Extras,
            'OrderMethod' => $OrderMethod,
            'ClientCompanies' => $ClientCompanies]);
    }

    //**AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX****AJAX**

    public function delete(Request $request, $id = NULL)
    {

        Job::find($id)->delete();

        return response()->json('ok');
    }

    public function getprices(Request $request)
    {
        $clientid = $request->client;
        $vehicleclassid = $request->vehicle_class;
        $packageid = $request->package;

        if ($clientid == NULL || $vehicleclassid == NULL || $packageid == NULL) {

            return 'missingdata';
        }

        $Client = Client::find($clientid);

        if (is_array($vehicleclassid)) {

            $VehicleClassPrice = VehicleClassPrice::whereIn('vehicle_class_id', $vehicleclassid)
                ->where('package_id', '=', $packageid)->get();

            $retresult = array();
            if ($VehicleClassPrice->count()) {

                foreach ($VehicleClassPrice as $ClassPrice) {

                    $specialPrice = $this->findcompanyprice($Client, $ClassPrice->vehicle_class_id, $packageid);
                    $retresult[$ClassPrice->id] =
                        [
                            'defaultprice' => $ClassPrice ? $ClassPrice->price : 0,
                            'specialprice' => $specialPrice
                        ];
                }
            } else {

                foreach ($vehicleclassid as $item) {

                    $specialPrice = $this->findcompanyprice($Client, $item, $packageid);
                    $retresult[$item] =
                        [
                            'defaultprice' => 0,
                            'specialprice' => $specialPrice
                        ];
                }
            }

            return $retresult;

        } else {

            $VehicleClassPrice = VehicleClassPrice::where([
                ['vehicle_class_id', '=', $vehicleclassid],
                ['package_id', '=', $packageid]
            ])->first();

            $specialPrice = $this->findcompanyprice($Client, $vehicleclassid, $packageid);

            return [
                $vehicleclassid => [
                    'defaultprice' => $VehicleClassPrice ? $VehicleClassPrice->price : 0,
                    'specialprice' => $specialPrice
                ]
            ];
        }
    }

    public function checkgeocodes(Request $request)
    {
        $startplaces = $request->startplaces;

        $endplaces = $request->endplaces;

        $Package = Package::find($request->packid);

        if ($startplaces != null && $Package->start_location && $Package->start_map_place && !in_array($Package->start_map_place, $startplaces))
            return 'wrongloc';
        if ($endplaces != null && $Package->end_location && $Package->end_map_place && !in_array($Package->end_map_place, $endplaces))
            return 'wrongloc';

        if ($startplaces != null && $endplaces != null) {
            return Package::whereIn('start_map_place', $startplaces)
                ->whereIn('end_map_place', $endplaces)
                ->where('id', '!=', $Package->id)
                ->where('is_fixed_price', '=', 1)
                ->first();
        } else {
            return '';
        }
    }

    private function findcompanyprice(Client $Client, int $vehicleclassid, int $packageid)
    {
        $ClientSpecialPrice = ClientSpecialPrice::where([
            ['package_id', '=', $packageid],
            ['vehicle_class_id', '=', $vehicleclassid],
            ['client_id', '=', $Client->id]
        ])->first();

        if ($ClientSpecialPrice != NULL && $ClientSpecialPrice->price > 0) {

            return $ClientSpecialPrice->price;

        } else {

            $CompanyClient = Client::find($Client->company_client_id);

            if ($CompanyClient == NULL) {

                return 0;

            } else {

                $CompanyClientSpecialPrice = ClientSpecialPrice::where([
                    ['package_id', '=', $packageid],
                    ['vehicle_class_id', '=', $vehicleclassid],
                    ['client_id', '=', $CompanyClient->id]
                ])->first();

                if ($CompanyClientSpecialPrice != NULL && $CompanyClientSpecialPrice->price > 0) {

                    return $CompanyClientSpecialPrice->price;

                } else {

                    return $this->findcompanyprice($CompanyClient, $vehicleclassid, $packageid);
                }
            }
        }
    }

    function getpricesummary(Request $request)
    {


        $clientid = $request->client;
        $vehicleclassid = $request->vehicle_class;
        $packageid = $request->package;
        $orderid = $request->orderid;

        $Client = Client::find($clientid);
        $OrderExtras = OrderExtra::with('extra')->whereOrderId($orderid)->get();
        $Order = Order::whereId($orderid)->first();
        $extras = array();
        if ($request->extras) {
            foreach ($request->extras as $ex) {
                $extra = new \stdClass();
                $extra->id = $ex["extraid"];
                $extra->name = $ex["extraname"];
                $extra->price = $ex["extraprice"];
                $extraVat = InvoiceService::calculateVAT($extra->price, $Client->residential_id);
                $extra->TaxRate = $extraVat->TaxRate;
                $extra->TaxValue = $extraVat->TaxValue;
                $extra->GrossPrice = $extraVat->GrossPrice;
                array_push($extras, $extra);
            }
        }
        if (isset($OrderExtras)) {
            foreach ($OrderExtras as $ex) {
                $extra = new \stdClass();
                $extra->id = $ex->extra->id;
                $extra->name = $ex->extra->name;
                $extra->price = $ex->extra->price;
                $extraVat = InvoiceService::calculateVAT($extra->price, $Client->residential_id);
                $extra->TaxRate = $extraVat->TaxRate;
                $extra->TaxValue = $extraVat->TaxValue;
                $extra->GrossPrice = $extraVat->GrossPrice;
                array_push($extras, $extra);
            }
        }


        $Package = Package::find($packageid);


        $PriceHelper = new PriceHelper();

        $res = $PriceHelper->GetPrice($clientid, $vehicleclassid, $packageid, $Order->kilometer);
        $defaultPrice = $res->DefaultPrice;
        $specialPrice = $res->SpecialPrice;
        $specialPriceVAT = InvoiceService::calculateVAT($specialPrice, $Client->residential_id);
        $defaultpriceVAT = InvoiceService::calculateVAT($defaultPrice, $Client->residential_id);


        $model = new \stdClass();
        $model->package_id = $Package->id;
        $model->packagename = $Package->name;
        $model->defaultprice = $defaultPrice;
        $model->defaultpriceTaxRate = $defaultpriceVAT->TaxRate;
        $model->defaultpriceTax = $defaultpriceVAT->TaxValue;
        $model->defaultpriceGrossPrice = $defaultpriceVAT->GrossPrice;

        $model->specialprice = $specialPrice;
        $model->specialpriceTaxRate = $specialPriceVAT->TaxRate;
        $model->specialpriceTax = $specialPriceVAT->TaxValue;
        $model->specialpriceGrossPrice = $specialPriceVAT->GrossPrice;

        $model->extras = $extras;
        return $model;
        return view('themes.' . static::$tf . '.client.order.pricesummary', ['model' => $model]);
    }



}
