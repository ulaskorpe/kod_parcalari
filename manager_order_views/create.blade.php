@extends("themes.$tf.layouts.default")

@section('pageTitle', 'Order Create')
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')
    <script type="text/javascript">
        var packageData = [],
            vehicleData = [],
            extraData = [];
    </script>
    <style type="text/css">
        .multimode {
            display: none;
        }

        #result_info {
            display: none;
        }

        .sc_circle {
            width: 30px;
            height: 30px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            border-radius: 15px;
        }

    </style>
@stop

@section('content-body')
    <section id="basic-form-layouts">
        <div class="col-xs-12">
            <div class="row match-height" style="padding-top: 10px">
                     <div class="col-xs-12">
                        <div class="card">
                <div style="padding-top: 14px;padding-bottom: 14px;">
                   <form class="form" id="add-vehicle" action="{{route('manager.order.create')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" id="carlist" name="carlist" value="[]">
            <input type="hidden" id="extralist" name="extralist" value="[]">
            <input type="hidden" id="duration" name="duration">
            <input type="hidden" id="kilometer" name="kilometer">
            <input type="hidden" id="startlocation" name="startlocation">
            <input type="hidden" id="endlocation" name="endlocation">
            <div class="form-body">
                <div class="row">
                    <div class="col-lg-7  col-md-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">{{__('orders.order_info')}}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div class="card-text">
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-8">
                                            <label for="client">{{__('orders.select_client')}} </label>
                                            <select id="client" name="client" class="form-control select2" required>
                                                <option value="">Select Client</option>
                                                @foreach($Clients as $client)
                                                    <option value="{{$client->id}}" {{ old('client_id')==$client->id?'selected=selected':'' }}>
                                                        {{$client->user->name}} {{$client->user->last_name}} ({{$client->user->email}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-2">
                                            <label for="number_of_passengers">{{__('orders.passengers')}}</label>
                                            <input type="number" id="number_of_passengers" class="form-control" min="1" max="300"
                                                   name="number_of_passengers" value="{{ old('number_of_passengers',1) }}">
                                            {!! $errors->getBag('validation')->first('number_of_passengers', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                        <div class="col-md-2">
                                            <label for="price">{{__('orders.price')}}(â‚¬)</label>
                                            <input readonly type="number" class="form-control" name="price" id="price" style="width: 100%; display: none;" step="0.1" min="0" max="1" value="0">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="package">{{__('orders.select_package')}} </label>
                                                <select id="package" name="package" class="form-control select2" required>
                                                    <option value="">Select Package</option>
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach($Packages as $package)
                                                        <script type="text/javascript">
                                                            packageData[{{$package->id}}] = [];
                                                            packageData[{{$package->id}}]['start_location'] = "{{$package->start_location}}";
                                                            packageData[{{$package->id}}]['end_location'] = "{{$package->end_location}}";
                                                            packageData[{{$package->id}}]['start_map_place'] = "{{$package->start_map_place}}";
                                                            packageData[{{$package->id}}]['end_map_place'] = "{{$package->end_map_place}}";
                                                            packageData[{{$package->id}}]['is_fixed_price'] = "{{$package->is_fixed_price}}";
                                                        </script>
                                                        <option value="{{$package->id}}" {{ old('package_id')==$package->id?'selected=selected':'' }} >
                                                            {{$package->name}}
                                                        </option>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">{{__('orders.payment_type')}}</label>
                                                        <fieldset class="form-group position-relative">
                                                            <select id="payment_type_id" class="form-control" placeholder="Payment Type ID" name="payment_type_id">
                                                                @foreach($PaymentTypes as $paymentType)
                                                                    <option value="{{$paymentType->id}}" {{ old('payment_type_id')==$paymentType->id?'selected=selected':'' }}>
                                                                        {{$paymentType->payment_title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            {!! $errors->getBag('validation')->first('payment_type_id', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">{{__('orders.payment_status')}}</label>
                                                        <fieldset class="form-group position-relative">
                                                            <select id="payment_status" name="payment_status" class="form-control" placeholder="Payment Status">
                                                                <option value="0" {{ old('payment_status')=='npaid'?'selected=selected':'' }}>
                                                                    Not Paid
                                                                </option>
                                                                <option value="1" {{ old('payment_status')=='paid'?'selected=selected':'' }}>
                                                                    Paid
                                                                </option>
                                                            </select>
                                                            {!! $errors->getBag('validation')->first('payment_type_id', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:18px;">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary btn-lg form-control" onclick="additionalInfo();">{{__('orders.additional_info')}}</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary btn-lg form-control" onclick="extraInfo();">{{__('orders.extra')}}</button>
                                                </div>
                                            </div>

                                        </div>
                                        <label for="start_date">{{__('orders.order_time')}}</label>
                                        <div class="col-md-5" style="border: 1px solid #d4d4d4; padding-top:15px;">

                                            <input type="hidden" id="start_date" class="form-control datepicker-default"
                                                   name="start_date" value="{{ old('start_date',date('Y/m/d H:i')) }}">
                                            {!! $errors->getBag('validation')->first('start_date', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                    <div class="row top-buffer">
                                        <div class="col-md-6">
                                            <h5 class="cd-titlear" id="basic-layout-form"><i class="icon-car"></i> {{__('orders.vehicle_class_selection')}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="pull-right">
                                                <tr>
                                                    <td>
                                                        <div id="capacity_note" style="font-size: 10px;"></div>
                                                    </td>
                                                    <td>
                                                        <div class="sc_circle" style="background-color: #F44336;"></div>
                                                    </td>
                                                    <td>
                                                        <h6>{{__('orders.total_capacity')}}: <span id="capacity_info"></span></h6>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <label for="vehicle_class">{{__('orders.vehicle_class')}}</label>
                                                        <select id="vehicle_class" name="vehicle_class" required class="form-control">
                                                            <option></option>
                                                            @foreach($VehicleClasses as $VehicleClass)
                                                                <script type="text/javascript">
                                                                    vehicleData[{{$VehicleClass->id}}] = [];
                                                                    vehicleData[{{$VehicleClass->id}}]['name'] = "{{$VehicleClass->name}}";
                                                                    vehicleData[{{$VehicleClass->id}}]['max_capacity'] = "{{$VehicleClass->max_capacity}}";
                                                                </script>
                                                                <option value="{{$VehicleClass->id}}"
                                                                        {{ old('vehicle_class')==$VehicleClass->id?'selected=selected':'' }} >
                                                                    {{$VehicleClass->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <label for="driver">{{__('orders.driver')}}</label>
                                                        <select id="driver" name="driver" class="form-control select2">
                                                            <option value="">Select Driver</option>
                                                            @foreach($Drivers as $driver)
                                                                <option value="{{$driver->id}}"
                                                                        {{ old('driver')==$driver->id?'selected=selected':'' }} >
                                                                    {{$driver->user->fullname()}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="multimode" style="height: 100%;">
                                                        <label for="button">&nbsp;</label>
                                                        <input type="button" class="btn btn-success" onclick="addVehicleClass()" value="Add">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row multimode">
                                        <div class="col-md-12">
                                            <h5>{{__('orders.vehicle_list')}}</h5>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <th>
                                                    {{__('orders.vehicle_class')}}
                                                </th>
                                                <th style="width: 100%;">
                                                    {{__('orders.Driver')}}
                                                </th>
                                                <th>
                                                    {{__('orders.actions')}}
                                                </th>
                                                </thead>
                                                <tbody id="class_list">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5  col-md-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md-6">
                                    <h4 class="card-title" id="basic-layout-form">{{__('orders.route_info')}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <button id="submitbtn" class="btn btn-danger btn-sm pull-right" disabled>
                                        <i class="icon-check"></i> {{__('orders.create_order')}}
                                    </button>
                                </div>
                                <a class="heading-elements-toggle">
                                    <i class="icon-ellipsis font-medium-3"></i>
                                </a>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div class="card-text">
                                    </div>
                                    <div class="row" style="padding-bottom: 3px;">
                                        <div class="col-md-6" id="fromdiv" style="display: none;">
                                            <label for="from_actb">{{__('orders.start_location')}}</label>
                                            <input id="from_actb" class="form-control" name="from_actb" value="{{ old('from_actb') }}">
                                        </div>
                                        <div class="col-md-6" id="todiv" style="display: none;">
                                            <label for="to_actb">{{__('orders.finish_location')}}</label>
                                            <input id="to_actb" class="form-control" name="to_actb" value="{{ old('to_actb') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="mapdiv" style="height: 350px; ">
                                                <div id="googlemap" style="width: 100%; height: 100%;border: 3px inset;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 start_info">
                                            <label for="startpostalcode">{{__('orders.start_address_postal_code')}}</label>
                                            <input id="startpostalcode" name="startpostalcode" class="form-control" style="width:65%;">
                                            <label for="startaddress">{{__('orders.start_address')}}</label>
                                            <textarea id="startaddress" name="startaddress" class="form-control"></textarea>
                                            <label for="startaddressnote">{{__('orders.start_address_hint')}}</label>
                                            <textarea id="startaddressnote" name="startaddressnote" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6 end_info">
                                            <label for="endpostalcode">{{__('orders.end_address_postal_code')}}</label>
                                            <input id="endpostalcode" name="endpostalcode" class="form-control" style="width:65%;">
                                            <label for="endaddress">{{__('orders.end_address')}}</label>
                                            <textarea id="endaddress" name="endaddress" class="form-control"></textarea>
                                            <label for="endaddressnote">{{__('orders.end_address_hint')}}</label>
                                            <textarea id="endaddressnote" name="endaddressnote" class="form-control"></textarea>
                                            <span id="endlocation"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row top-buffer">
                                        <div id="result_info_div" class="col-md-12 result_info ">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade " id="saveModal" role="dialog" style="background-color: #fffffc;margin: auto; width:600px; height:500px;">
                <div id="loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
                    <div class="cube1 cube"></div>
                    <div class="cube2 cube"></div>
                    <div class="cube4 cube"></div>
                    <div class="cube3 cube"></div>
                </div>
                <div class="modal-header bg-info">
                    <a class="close" data-dismiss="modal" style="color: #fffffc">x</a>
                    <!--//TODO: Translate docs must be edited...-->
                    <h4 style="color: #fffffc">{{__('orders.additional_order_infromation')}}</h4>
                </div>
                <div id="modal-body" class="modal-body">
                    <div class="col-md-6"><label for="passenger_title">{{__('orders.passenger_title')}}</label>
                        <input class="form-control" name="passenger_title" id="passenger_title" placeholder="Title">
                        <label for="passenger_name">{{__('orders.passenger_name')}}</label>
                        <input class="form-control" name="passenger_name" id="passenger_name" placeholder="Name">
                        <label for="kostenstelle">{{__('orders.cost_center')}}</label>
                        <input id="kostenstelle" class="form-control" name="kostenstelle" placeholder="Kostenstelle" value="{{ old('kostenstelle') }}">
                        <label for="comment">{{__('orders.comment')}}</label>
                        <textarea id="comment" name="comment" class="form-control" placeholder="Comment" value="{{ old('comment') }}"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="flight_number">{{__('orders.flight_number')}}</label>
                        <input class="form-control" name="flight_number" id="flight_number" placeholder="Flight Number">
                        <label for="flight_from">{{__('orders.flight_from')}}</label>
                        <input class="form-control" name="flight_from" id="flight_from" placeholder="Flight From">
                        <label for="flight_company">{{__('orders.flight_company')}}</label>
                        <input class="form-control" name="flight_company" id="flight_company" placeholder="Flight Company">
                        <label for="order_method_id">{{__('orders.order_method')}}</label>
                        <select class="form-control" name="order_method_id" id="order_method_id">
                            <option></option>
                            @foreach($OrderMethod as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-md-12 top-buffer">
                        <button type="button" class="btn btn-success pull-right" data-dismiss="modal" style="color: #fffffc; ">{{__('orders.close')}}</button>
                    </div>
                </div>
            </div>
            <div class="modal fade " id="extramodal" role="dialog" style="background-color: #fffffc;margin: auto; height: 500px; width: 500px;">
                <div id="extra-loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
                    <div class="cube1 cube"></div>
                    <div class="cube2 cube"></div>
                    <div class="cube4 cube"></div>
                    <div class="cube3 cube"></div>
                </div>
                <div class="modal-header bg-info">
                    <a class="close" data-dismiss="modal" style="color: #fffffc">x</a>
                    <!--//TODO: Translate docs must be edited...-->
                    <h4 style="color: #fffffc">{{__('orders.extras')}}</h4>
                </div>
                <div id="extra-modal-body" class="modal-body">
                    <div class="col-md-6">
                        <label for="extra_type">{{__('orders.extra')}}</label>
                        <select id="extra_type" class="form-control" name="extra_type">
                            @foreach($Extras as $extra)
                                <script type="text/javascript">
                                    extraData[{{$extra->id}}] = [];
                                    extraData[{{$extra->id}}]['name'] = "{{$extra->name}}";
                                    extraData[{{$extra->id}}]['price'] = "{{$extra->price}}";
                                </script>
                                <option value="{{$extra->id}}">{{$extra->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="extra_price">{{__('orders.price')}}</label>
                        <input type="number" class="form-control" name="extra_price" id="extra_price" value="0" min="0" step="Any">
                    </div>
                    <div class="col-md-3">
                        <label for="extra_price">&nbsp;</label>
                        <button type="button" class=" btn btn-info" onclick="addExtra();">{{__('orders.add_extra')}}</button>
                    </div>
                    <div class="col-md-12 top-buffer">
                        <table class="table-bordered table-sm" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>{{__('orders.extra_name')}}</th>
                                <th>{{__('orders.extra_price')}}</th>
                                <th>{{__('orders.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="extra_list_body">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 top-buffer">
                        <button type="button" class="btn btn-success pull-right" data-dismiss="modal" style="color: #fffffc; ">{{__('orders.close')}}</button>
                    </div>
                </div>
            </div>
        </form>
                </div>
            </div>
                        </div>
            </div>

        </div>
    </section>
@stop

@section('scriptParts')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">

        var extratype = $('#extra_type'),
            extraprice = $('#extra_price');
        extratype.change(function () {
            extraprice.val(extraData[extratype.val()]['price']);
        }).change();


        $("#start_date").datetimepicker({
            minDate: moment(),
            format: 'YYYY/MM/DD HH:mm',
            inline: true,
            sideBySide: true
        });

        var numberofpaseengers = $('#number_of_passengers');
        var multimode = $('.multimode');
        var vehicleclass = $('#vehicle_class');
        var driver = $('#driver');
        var price = $('#price'), client = $('#client');
        var submitbtn = $('#submitbtn');
        var myList = [], extraList = [];

        numberofpaseengers.on('change', function (e) {
            myList = [];
            $('#carlist').val('{}');
            var mval = numberofpaseengers.val();
            if (mval > 3) {
                multimode.show();
                fillList();
            } else {
                multimode.hide();
            }
        });


        function addVehicleClass() {

            var mval = vehicleclass.val();
            var drvid = driver.val();
            if (mval == null)
                return;
            myList.push({
                vehicleclassid: mval,
                vehicleclassname: vehicleclass.children("option").filter(":selected").text().trim(),
                driverid: drvid,
                drivername: driver.children("option").filter(":selected").text().trim()
            });
            fillList();
        }

        function removeVehicleClass(key) {

            myList.splice(key, 1);

            fillList();
        }

        var classlist = $('#class_list');

        function fillList() {
            calculatePrice();
            var content = "";
            var submitvalues = [];
            for (var key in myList) {
                if (typeof myList[key] !== 'undefined' && myList[key] != null) {
                    content += '<tr><td>' + myList[key].vehicleclassname + '</td>';
                    content += '<td>' + myList[key].drivername + '</td>';
                    content += '<td><button onclick="removeVehicleClass(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
                    submitvalues.push({
                        'vehicleclassid': myList[key].vehicleclassid,
                        'vehicleclassname': myList[key].vehicleclassname,
                        'driverid': myList[key].driverid,
                        'drivername': myList[key].drivername
                    });
                }
            }
            $('#carlist').val(JSON.stringify(submitvalues));
            classlist.html(content);
        }

        var map, startmarker, endmarker, directionsDisplay, directionsService;
        var fromautocomplete, toautocomplete;
        var geocoder;

        function initMap() {
            var viyana = {lat: 48.210033, lng: 16.363587999999936};
            map = new google.maps.Map(document.getElementById('googlemap'), {
                zoom: 12,
                center: viyana
            });
            directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.setMap(map);
            directionsDisplay.setOptions({suppressMarkers: true});
            startmarker = new google.maps.Marker({
                position: viyana,
                map: map,
                visible: false,
                icon: '{{asset('image/src/FlagStart50.png')}}',
                draggable: true
            });
            endmarker = new google.maps.Marker({
                position: viyana,
                map: map,
                visible: false,
                icon: '{{asset('image/src/FlagFinish50.png')}}',
                draggable: true
            });
            geocoder = new google.maps.Geocoder();
            startmarker.addListener('dragend', function () {
                startMarkerMoved();
            });
            endmarker.addListener('dragend', function () {
                endMarkerMoved();
            });

            var frominput = document.getElementById('from_actb');
            fromautocomplete = new google.maps.places.Autocomplete(frominput);
            fromautocomplete.addListener('place_changed', function () {
                fromTextChanged();
            });
            var toinput = document.getElementById('to_actb');
            toautocomplete = new google.maps.places.Autocomplete(toinput);
            toautocomplete.addListener('place_changed', function () {
                toTextChanged();
            });
        }

        var fromdiv = $('#fromdiv'), todiv = $('#todiv'), packageselect = $('#package');
        var resultinfo = $('.result_info');
        var fromlimit = "", tolimit = "";
        packageselect.on('change', function () {

            submitbtn.attr("disabled", true);
            totalkm = 1;
            directionsDisplay.set('directions', null);
            endmarker.setVisible(false);
            startmarker.setVisible(false);
            startgeocode = null;
            endgeocode = null;

            $('#duration').val(null);
            $('#kilometer').val(null);
            $('#startlocation').val(null);
            $('#endlocation').val(null);

            packid = packageselect.val();

            if (packid != null) {

                calculatePrice();
                var askstart = packageData[packid].start_location === "1";
                var askend = packageData[packid].end_location === "1";

                if (askstart) {
                    fromdiv.show();
                    startmarker.setVisible(true);
                } else {
                    fromdiv.hide();
                    startmarker.setVisible(false);
                    startgeocode = null;
                }

                if (askend) {
                    todiv.show();
                    endmarker.setVisible(true);
                }
                else {
                    todiv.hide();
                    endmarker.setVisible(false);
                    endgeocode = null;
                }

                (askstart && askend) ? resultinfo.show() : resultinfo.hide();

                fromlimit = packageData[packid].start_map_place;
                tolimit = packageData[packid].end_map_place;

            } else {
                submitbtn.attr("disabled", true);
            }
        });
        client.on('change', function () {
            calculatePrice();
        });
        vehicleclass.on('change', function () {
            calculatePrice();
        });

        var frommarkerplace, tomarkerplace;

        function fromTextChanged() {
            frommarkerplace = fromautocomplete.getPlace();
            map.panTo(frommarkerplace.geometry.location);
            startmarker.setPosition(frommarkerplace.geometry.location);
            startmarker.setVisible(true);
            writeStartInfo(calcRoute);
        }

        function toTextChanged() {
            tomarkerplace = toautocomplete.getPlace();
            map.panTo(tomarkerplace.geometry.location);
            endmarker.setPosition(tomarkerplace.geometry.location);
            endmarker.setVisible(true);
            writeEndInfo(calcRoute);
        }

        function startMarkerMoved() {
            writeStartInfo(calcRoute);
        }

        function endMarkerMoved() {
            writeEndInfo(calcRoute);
        }

        var startgeocode = null, endgeocode = null;

        function writeStartInfo(callback) {

            startgeocode = null;

            $('#startlocation').val(JSON.stringify({'lat': startmarker.getPosition().lat(), 'lon': startmarker.getPosition().lng()}));

            $('#startaddress').val("");

            geocoder.geocode({'latLng': startmarker.getPosition()}, function (results, status) {

                if (status === google.maps.GeocoderStatus.OK) {

                    $('#startpostalcode').val(postalCodeFromJson(results));
                    startgeocode = results;
                    if (packageData[packid]['start_map_place'] != "") {
                        checkMarkersOk();
                    }
                    else if (packageData[packid]['end_map_place'] == "") {
                        submitbtn.attr("disabled", false);
                    }
                    $('#startaddress').val(results[0].formatted_address);
                    if (callback) callback();
                } else {
                    alert("{{__('orders.start_point_error')}}" + status);
                }

            });
        }

        function writeEndInfo(callback) {

            endgeocode = null;

            $('#endlocation').val(JSON.stringify({'lat': endmarker.getPosition().lat(), 'lon': endmarker.getPosition().lng()}));

            $('#endaddress').val("");

            geocoder.geocode({'latLng': endmarker.getPosition()}, function (results, status) {

                if (status === google.maps.GeocoderStatus.OK) {

                    $('#endpostalcode').val(postalCodeFromJson(results));

                    endgeocode = results;
                    if (packageData[packid]['end_map_place'] != "") {
                        checkMarkersOk();
                    } else if (packageData[packid]['start_map_place'] == "") {
                        submitbtn.attr("disabled", false);
                    }
                    $('#endaddress').val(results[0].formatted_address);
                    if (callback) callback();
                } else {
                    alert("{{__('orders.finish_point_error')}}" + status);
                }
            });
        }

        var packid;
        var totalcapacity;

        function calculatePrice() {//mylist['VEHICLECLASSID'] [0]=adet, [1]=text
            price.hide();
            var getpricesarray = [];

            for (var key in myList)
                if (myList.hasOwnProperty(key))
                    if (typeof myList[key] !== 'undefined' && myList[key] != null)
                        getpricesarray.push(myList[key].vehicleclassid);

            if (getpricesarray.length === 1)
                getpricesarray = getpricesarray[0];
            else if (getpricesarray.length < 1)
                getpricesarray = vehicleclass.val();

            totalcapacity = 0;
            for (var key in getpricesarray) {
                if (getpricesarray.hasOwnProperty(key)) {
                    totalcapacity += parseInt(vehicleData[getpricesarray[key]]['max_capacity']);
                }
            }

            $('#capacity_info').html(totalcapacity);

            if (totalcapacity >= numberofpaseengers.val()) {
                $('.sc_circle').css('background-color', '#32CD32');
                $('#capacity_note').html("");
            } else {
                $('.sc_circle').css('background-color', '#F44336');
                $('#capacity_note').html("Add More Vehicles");
            }

            $.get(
                '{{url('manager/order/getprices')}}',
                {
                    'client': client.val(),
                    'vehicle_class': getpricesarray,
                    'package': packid
                },
                function (result) {

                    if (result === 'missingdata')
                        return;
                    price.show();
                    var totalprice = 0.0;

                    for (var ekey in extraList)
                        if (extraList.hasOwnProperty(ekey))
                            if (typeof extraList[ekey] !== 'undefined' && extraList[ekey] != null)
                                totalprice += parseFloat(extraList[ekey].extraprice);


                    for (var key in result) {
                        if (result.hasOwnProperty(key)) {

                            var minprice = Math.min(result[key]['defaultprice'],
                                result[key]['specialprice'] == 0 ? result[key]['defaultprice'] : result[key]['specialprice']);
                            var mvehicleclassid = key;
                            if (myList.length > 0) {
                                for (var index in myList) {
                                    if (myList.hasOwnProperty(index)) {
                                        if (typeof myList[index] !== 'undefined' && myList[index] != null) {
                                            if (myList[index].vehicleclassid == mvehicleclassid) {
                                                totalprice += minprice * totalkm;
                                            }
                                        }
                                    }
                                }
                            } else {
                                totalprice += minprice;
                            }
                        }
                    }
                    price.val(totalprice.toFixed(2).toString());
                }
            );
        }

        function calcRoute() {

            if (startmarker.getVisible() && endmarker.getVisible() && packageData[packid]['is_fixed_price'] != 1) {

                var start = startmarker.getPosition();
                var end = endmarker.getPosition();

                var request = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, function (response, status) {

                        if (status === google.maps.DirectionsStatus.OK) {

                            directionsDisplay.setDirections(response);
                            directionsDisplay.setMap(map);
                            var startstring = $('#startaddress').html().trim();
                            var endstring = $('#endaddress').html().trim();
                            if (startstring == '') {
                                writeStartInfo(function () {
                                    if (endstring == '') {
                                        writeEndInfo(function () {
                                            computeTotalDistance(directionsDisplay.getDirections());
                                        });
                                    } else {
                                        computeTotalDistance(directionsDisplay.getDirections());
                                    }
                                });
                            }
                            else if (endstring == '') {
                                writeEndInfo(function () {
                                    computeTotalDistance(directionsDisplay.getDirections());
                                });
                            } else {
                                computeTotalDistance(directionsDisplay.getDirections());
                            }
                        } else {
                            alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
                        }
                    }
                );
            }
        }

        var totalkm = 1;
        var startplaces = [], endplaces = [];

        function computeTotalDistance(result) {
            var myleg = result.routes[0].legs[0];
            checkMarkersOk();

            totalkm = myleg.distance.value / 1000;
            $('#kilometer').val(totalkm);

            calculatePrice();
            var totalmin = myleg.duration.value / 60;
            $('#duration').val(totalmin);

            var content = "";
            content += 'Distance: ' + myleg.distance.text + '<br>';
            content += 'Duration: ' + myleg.duration.text + '<br>';
            $('#result_info_div').html(content);
        }

        function checkMarkersOk() {

            startplaces = [];
            endplaces = [];
            for (var key in startgeocode)
                if (startgeocode.hasOwnProperty(key))
                    startplaces.push(startgeocode[key].place_id);
            for (var mkey in endgeocode)
                if (endgeocode.hasOwnProperty(mkey))
                    endplaces.push(endgeocode[mkey].place_id);

            var counter = 0;

            $.post('{{url('manager/order/checkgeocodes')}}', {
                "_token": "{{ csrf_token() }}",
                startplaces: startplaces,
                endplaces: endplaces,
                packid: packid

            }, function (result) {

                if (result == '') {
                    submitbtn.attr("disabled", false);
                } else if (result === 'wrongloc') {
                    submitbtn.attr("disabled", true);
                    //__('messages.welcome', ['name' => 'dayle']);
                    alert('{{__('orders.warning_provided_locations')}}');

                } else {
                    submitbtn.attr("disabled", true);
                    alert('WARNING!!!\n\n' + "Select " + result.name + " Package");

                }
            }).always(function () {

            });
        }

        function postalCodeFromJson(mdata) {
            for (var key in mdata) {
                var addresscomps = mdata[key]['address_components'];
                for (var key2 in addresscomps) {
                    var types = addresscomps[key2]['types'];
                    for (var key3 in types)
                        if (types[key3] === "postal_code")
                            return addresscomps[key2]['long_name'];
                }
            }
        }

        function additionalInfo() {
            $('#saveModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#loading').hide();
        }

        function extraInfo() {
            $('#extramodal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#extra-loading').hide();
        }

        function addExtra() {
            extraList.push({
                extraid: extratype.val(),
                extraname: extratype.children("option").filter(":selected").text().trim(),
                extraprice: extraprice.val()
            });
            fillExtraList();
        }

        function removeExtra(key) {
            extraList.splice(key, 1);
            fillExtraList();
        }

        function fillExtraList() {
            calculatePrice();
            var content = "";
            var submitvalues = [];
            for (var key in extraList) {
                if (typeof extraList[key] !== 'undefined' && extraList[key] != null) {
                    content += '<tr><td>' + extraList[key].extraname + '</td>';
                    content += '<td>' + extraList[key].extraprice + '</td>';
                    content += '<td><button onclick="removeExtra(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
                }
            }
            $('#extralist').val(JSON.stringify(extraList));
            $('#extra_list_body').html(content);
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjjzQwdb46PHUyVHu_SaM1NDQMSIXRUsE&libraries=places&callback=initMap" async defer></script>

@stop