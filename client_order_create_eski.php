<?php

public function create(Request $request)
    {


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


        $VehicleClasses = VehicleClass::all();
        $Packages = Package::all();
        $PaymentTypes = PaymentType::all();
        $Drivers = Driver::with('company', 'user')
            ->join('users', 'users.id', '=', 'drivers.user_id')
            ->get();

        return view('themes.' . static::$tf . '.common.order.createnew', [
            'Packages' => $Packages,
            'Drivers' => $Drivers,
            'PaymentTypes' => $PaymentTypes,
            'VehicleClasses' => $VehicleClasses
        ]);
    }
?>