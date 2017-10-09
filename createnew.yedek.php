@extends("themes.$tf.layouts.default")

@section('pageTitle', 'Order Create')
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')
    <link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
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

        .toggle.btn {
            min-width: 110px;
        }

    </style>
@stop

@section('content-body')
    <section id="basic-form-layouts">

        <div class="col-xs-12">
            <div class="row" style="margin-top: 10px">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__("orders.create_order")}}</h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <button type="button" title="Add Client" onclick="createClient()" class="btn"><i class="icon-user-plus2"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-block">
                                <form action="/common/order/create" class="number-tab-steps wizard-circle"
                                      id="createOrder">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="extralist" name="extralist" value="[]">
                                    <input type="hidden" id="passengerlist" name="passengerlist" value="[]">
                                    <input type="hidden" id="originlist" name="originlist" value="[]">
                                    <input type="hidden" id="roadmaporderlist" name="roadmaporderlist" value="[]">
                                    <input type="hidden" id="duration" name="duration">
                                    <input type="hidden" id="kilometer" name="kilometer">
                                    <input type="hidden" id="startlocation_geocode" name="startlocation_geocode">
                                    <input type="hidden" id="startlocation" name="startlocation">
                                    <input type="hidden" id="startlocation_placeid" name="startlocation_placeid">
                                    <input type="hidden" id="endlocation_geocode" name="endlocation_geocode">
                                    <input type="hidden" id="endlocation" name="endlocation">
                                    <input type="hidden" id="endlocation_placeid" name="endlocation_placeid">
                                    <input type="hidden" id="calculated_packageid" name="calculated_packageid">

                                    <h6>{{__("orders.step")}} 1</h6>
                                    <fieldset style="min-height: 450px">
                                        <div class="form-group row">


                                            <div class="row">
                                                <div class="col-md-12">

                                                    <label for="client">{{__('orders.select_client')}} </label>


                                                    @role('manager')
                                                    @include("components.select2",
                                                                          [   "id"=>"client","name"=>"client",
                                                                               "autocomplete_url"=>"/common/autocomplate/select2",
                                                                               "modelname"=>\App\Models\Client::class,
                                                                               "functionname"=>'getClientsForOrder',

                                                                            ])
                                                    @endrole

                                                    @role('client')

                                                    @include("components.select2",
                                                                          [   "id"=>"client","name"=>"client",
                                                                               "autocomplete_url"=>"/common/autocomplate/select2",
                                                                               "modelname"=>\App\Models\Client::class,
                                                                               "functionname"=>'getClientsForClientOrder',
                                                                               "value"=>['id'=>$client->id,'text'=>$client->user->fullname()]

                                                                            ])
                                                    @endrole


                                                </div>


                                            </div>
                                            <div class="row">&nbsp;</div>

                                            <div class="row" id="togglePersonal" style="display: none">
                                                <div class="col-md-12">
                                                    <div class="input-group">

@include("components.toggle",["id"=>"personal_order","name"=>"personal_order","dataon"=>__('orders.company_order'),"dataoff"=>__('orders.personal_order')])


                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row" style="display: none" id="selectCompanyDiv">
                                                <div class="col-md-6">
                                                    <label for="client">{{__('orders.select_client_company')}} </label>
                                                    <select id="client_company" name="client_company"
                                                            class="form-control" onchange="getDepartments()">
                                                        <option value="">{{__('orders.please_se')}}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="client">{{__('orders.select_client_company_department')}} </label>
                                                    <select id="client_company_department" name="client_company_department"
                                                            class="form-control">
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div id="loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;display: none">
                                                    <div class="cube1 cube"></div>
                                                    <div class="cube2 cube"></div>
                                                    <div class="cube4 cube"></div>
                                                    <div class="cube3 cube"></div>
                                                </div>
                                                <div class="col-md-12" id="orderHistory" style="display: none">
                                                    <div class="card" style="min-height: 450px;margin-top: 15px">
                                                        <div class="card-header">
                                                            <h4 class="card-title">{{__("orders.order_history")}}</h4>
                                                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                                            <div class="heading-elements">
                                                                <ul class="list-inline mb-0">
                                                                    <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                                                    <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block" id="orderList">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="text" class="search form-control round border-primary mb-1" placeholder="Search">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="sort btn btn-block btn-outline-warning btn-round mb-2" data-sort="package_name">
                                                                            {{__("orders.sort_by_package")}}
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="sort btn btn-block btn-outline-success btn-round mb-2" data-sort="order_date">
                                                                            {{__("orders.sort_by_date")}}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <ul class="list-group list" id="orderHistoryList" style="max-height: 200px;overflow-y:scroll; ">

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </fieldset>

                      <h6>{{__("orders.step")}} 2</h6>
                                    <fieldset style="min-height: 450px">
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <label for="travel_type">{{__('orders.order_time')}}</label>
                                                <div class='input-group date' id='datetimepicker2'>
                                                    <input type='text' class="form-control" id="start_date" name="start_date" value="{{ old('start_date',date('Y/m/d H:i')) }}"
                                                           data-format="dd/MM/yyyy hh:mm"/>
                                                    <span class="input-group-addon">
                                                         <span class="glyphicon glyphicon-calendar"></span></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="number_of_passengers">{{__('orders.passengers')}}</label>
                                                <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger btn-number" disabled="disabled" data-type="minus" data-field="number_of_passengers">
                                                         <span class="glyphicon glyphicon-minus"></span>
                                                     </button>
                                                 </span>
                                                    <input id="number_of_passengers" class="form-control input-number" min="1" max="300" name="number_of_passengers"
                                                           value="{{ old('number_of_passengers',1) }}">
                                                    <span class="input-group-btn">
                                                  <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="number_of_passengers">
                                                      <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="travel_type">{{__("orders.travel_type")}}</label>
                                                <div class="input-group">
                                                    @include("components.toggle",["id"=>"is_trip","name"=>"is_trip","dataon"=>__('orders.trip'),"dataoff"=>__('orders.not_trip')])
                                                </div>
                                            </div>
                                        </div>
                                        <div id="select_direction">

                                            <div class="row">
                                                <div class="col-md-6" id="fromdiv">
                                                    <label for="from_actb">{{__('orders.start_location')}}</label>
                                                    <input id="from_actb" class="form-control" name="from_actb" value="{{ old('from_actb') }}">
                                                    <label for="startaddressnote">{{__('orders.start_address_hint')}}</label>
                                                    <textarea id="startaddressnote" name="startaddressnote" class="form-control"></textarea>
                                                </div>
                                                <div class="col-md-6" id="todiv">
                                                    <label for="to_actb">{{__('orders.finish_location')}}</label>
                                                    <input id="to_actb" class="form-control" name="to_actb" value="{{ old('to_actb') }}">
                                                    <label for="endaddressnote">{{__('orders.end_address_hint')}}</label>
                                                    <textarea id="endaddressnote" name="endaddressnote" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" id="locationsummary">
                                                <div class="col-md-6 start_info">
                                                    <label for="startpostalcode">{{__('orders.start_address_postal_code')}}</label>
                                                    <input id="startpostalcode" name="startpostalcode" class="form-control" style="width:65%; background-color: white;border:none" readonly="readonly">
                                                    <label for="startaddress">{{__('orders.start_address')}}</label>
                                                    <textarea id="startaddress" name="startaddress" class="form-control" readonly="readonly" style="background-color: white;border:none"></textarea>
                                                    <span id="startlocation"></span>
                                                </div>
                                                <div class="col-md-6 end_info">
                                                    <label for="endpostalcode">{{__('orders.end_address_postal_code')}}</label>
                                                    <input id="endpostalcode" name="endpostalcode" class="form-control" style="width:65%;background-color: white;border:none" readonly="readonly">
                                                    <label for="endaddress">{{__('orders.end_address')}}</label>
                                                    <textarea id="endaddress" name="endaddress" class="form-control" readonly="readonly" style="background-color: white;border:none"></textarea>
                                                    <span id="endlocation"></span>
                                                </div>
                                            </div>
                                            <div class="row" id="passengers" style="display: none">
                                                <div class="card collapse-icon accordion-icon-rotate">
                                                    <div id="headingCollapse11" class="card-header">
                                                        <a data-toggle="collapse" href="#collapse11" aria-expanded="false" aria-controls="collapse11" class="card-title lead collapsed">
                                                            {{__("orders.passenger")}}
                                                        </a>
                                                    </div>
                                                    <div id="collapse11" role="tabpanel" aria-labelledby="headingCollapse11" class="card-collapse collapse" aria-expanded="false">
                                                        <div class="card-body">
                                                            <div class="card-block">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label for="is_client">{{__("orders.passenger_is_client")}}</label><br>
@include("components.toggle",["id"=>"passenger_is_client","name"=>"passenger_is_client","dataon"=>__('orders.client'),"dataoff"=>__('orders.not_client')])
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div id="clientsdiv" style="display: none">
                                                                            <label for="clients">{{__("orders.clients")}}</label>


                                                                            @role('manager')
                                                                            @include("components.select2",
                                                                                                  [   "id"=>"clients","name"=>"clients",
                                                                                                       "autocomplete_url"=>"/common/autocomplate/select2",
                                                                                                       "modelname"=>\App\Models\Client::class,
                                                                                                       "functionname"=>'getClientsForOrder',
                                                                                                    ])
                                                                            @endrole

                                                                            @role('client')
                                                                            @include("components.select2",
                                                                                                  [   "id"=>"clients","name"=>"clients",
                                                                                                       "autocomplete_url"=>"/common/autocomplate/select2",
                                                                                                       "modelname"=>\App\Models\Client::class,
                                                                                                       "functionname"=>'getClientsForClientOrder',
                                                                                                    ])
                                                                            @endrole




                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="clientsplaces" class="row">

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label for="start_location">{{__("orders.start_location")}}</label>
                                                                        <input class="form-control" name="start_location" id="start_location" placeholder="{{__("orders.placeholder_start_location")}}">
                                                                        <input type="hidden" class="form-control" name="start_location_placeid" id="start_location_placeid">
                                                                        <input type="hidden" class="form-control" name="start_location_lat" id="start_location_lat">
                                                                        <input type="hidden" class="form-control" name="start_location_lon" id="start_location_lon">
                                                                        <input type="hidden" class="form-control" name="start_location_postalcode" id="start_location_postalcode">
                                                                        <input type="hidden" class="form-control" name="start_location_geocode" id="start_location_geocode">
                                                                        <label for="gsm_phone">{{__("orders.passenger_gsm")}}</label>
                                                                        @include("components.telephone",["id"=>"gsm_phone","name"=>"gsm_phone"])
                                                                        <label for="passenger_name">{{__('orders.passenger_name')}}</label>
                                                                        <input class="form-control" name="passenger_name" id="passenger_name" placeholder="{{__("orders.placeholder_name")}}">
                                                                        <label for="flight_number">{{__('orders.flight_number')}}</label>
                                                                        <input class="form-control" name="flight_number" id="flight_number" placeholder="{{__("orders.placeholder_flight_number")}}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="end_location">Finish Location</label>
                                                                        <input class="form-control" name="end_location" id="end_location" placeholder="{{__("orders.placeholder_end_location")}}">
                                                                        <input type="hidden" class="form-control" name="end_location_placeid" id="end_location_placeid">
                                                                        <input type="hidden" class="form-control" name="end_location_lat" id="end_location_lat">
                                                                        <input type="hidden" class="form-control" name="end_location_lon" id="end_location_lon">
                                                                        <input type="hidden" class="form-control" name="end_location_postalcode" id="end_location_postalcode">
                                                                        <input type="hidden" class="form-control" name="end_location_geocode" id="end_location_geocode">
                                                                        <label for="flight_from">{{__('orders.flight_from')}}</label>
                                                                        <input class="form-control" name="flight_from" id="flight_from" placeholder="{{__("orders.placeholder_flight_from")}}">
                                                                        <label for="flight_company">{{__('orders.flight_company')}}</label>
                                                                        <input class="form-control" name="flight_company" id="flight_company" placeholder="{{__("orders.placeholder_flight_company")}}">
                                                                        <label style="color:#FFFFFF">-</label>
                                                                        <button type="button" class="form-control btn btn-warning" onclick="addPassenger();">
                                                                            {{__('orders.add_passenger')}}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 top-buffer">
                                                                        <table class="table-bordered table-sm" style="width: 100%;">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>{{__("orders.passenger")}}</th>
                                                                                <th>{{__("orders.start_location")}}</th>
                                                                                <th>{{__("orders.end_location")}}</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td id="main_passenger"></td>
                                                                                <td id="main_startlocation"></td>
                                                                                <td id="main_endlocation"></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            </tbody>

                                                                            <tfoot id="passenger_list_body">

                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="select_package" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="package">{{__('orders.select_package')}} </label>
                                                    <select id="package" name="package" class="form-control">
                                                        <option>{{__("orders.select_package")}}</option>
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
                                            </div>
                                        </div>

                                    </fieldset>

                                    <h6>{{__("orders.step")}} 3</h6>
                                    <fieldset style="min-height: 450px">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="title">{{__('orders.payment_type')}}</label>
                                                    <select id="payment_type_id" class="form-control" placeholder="Payment Type ID" name="payment_type_id">
                                                        @foreach($PaymentTypes as $paymentType)
                                                            <option value="{{$paymentType->id}}" {{ old('payment_type_id')==$paymentType->id?'selected=selected':'' }}>
                                                                {{$paymentType->payment_title}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->getBag('validation')->first('payment_type_id', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="title">{{__('orders.payment_status')}}</label>
                                                    <select id="payment_status" name="payment_status"
                                                            class="form-control"
                                                            placeholder="Payment Status">
                                                        <option value="0" {{ old('payment_status')=='npaid'?'selected=selected':'' }}>
                                                            Not Paid
                                                        </option>
                                                        <option value="1" {{ old('payment_status')=='paid'?'selected=selected':'' }}>
                                                            Paid
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="kostenstelle">{{__('orders.cost_center')}}</label>
                                                    <input id="kostenstelle" class="form-control" name="kostenstelle"
                                                           placeholder="{{__("orders.cost_center")}}" value="{{ old('kostenstelle') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="order_method_id">{{__('orders.order_method')}}</label>
                                                    <select class="form-control" name="order_method_id" id="order_method_id">
                                                        <option></option>
                                                        @foreach($OrderMethod as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vehicle_class">{{__('orders.vehicle_class')}}</label>
                                                        <select id="vehicle_class" name="vehicle_class" required
                                                                class="form-control" onchange="getDrivers();">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="driver">{{__('orders.driver')}}</label>
                                                        <select id="driver" name="driver" class="form-control">
                                                            <option value="">{{__("orders.select_driver")}}</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="comment">{{__('orders.comment')}}</label>
                                                    <textarea id="comment" name="comment" class="form-control" placeholder="{{__("orders.placeholder_comment")}}">{{trim(old('comment'))}}</textarea>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top:20px;">
                                                <div class="col-md-12">
                                                    <div class="card collapse-icon accordion-icon-rotate">

                                                        <div id="headingCollapse12" class="card-header">
                                                            <a data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12" class="card-title lead collapsed">
                                                                {{__('orders.extra')}}
                                                            </a>
                                                        </div>
                                                        <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="card-collapse collapse" aria-expanded="false">
                                                            <div class="card-body">
                                                                <div class="card-block">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="extra_type">{{__('orders.extra')}}</label>
                                                                            <select id="extra_type" class="form-control" name="extra_type">
                                                                                <option value="0"></option>
                                                                                @foreach($Extras as $extra)
                                                                                    <option value="{{$extra->id}}"
                                                                                            data-value="{{$extra->price}}">{{$extra->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="extra_price">{{__('orders.price')}}</label>
                                                                            <input type="text" class="form-control" name="extra_price" id="extra_price" value="0" min="0" step="Any">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="extra_price">{{__('orders.add_extra')}}</label>
                                                                            <button type="button" class="form-control btn btn-orange" onclick="addExtra();">
                                                                                <i class="glyphicon glyphicon-plus"></i>
                                                                            </button>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row">
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
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </fieldset>

                                    <h6>{{__("orders.step")}} 4</h6>
                                    <fieldset>
                                        <div id="orderSummary">

                                        </div>
                                    </fieldset>
                                    <h6>{{__("orders.step")}} 5</h6>
                                    <fieldset style="min-height: 450px">
                                        <div id="dropin-card">
                                        </div>
                                        <div id="paymet_loading" class='square-spin loader-success' style="display: none;margin: auto;z-index: 8888;width:80px">
                                            <div>Wait..</div>
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('themes.robust.common.order.partial.createnew_info')
            </div>
        </div>
    </section>

    <div class="modal fade modal-lg" id="reorderModal" role="dialog" style="background-color: #fffffc;margin: auto">
        <div id="loading" class="folding-cube loader-blue-grey"
             style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto; display: none">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <h4 style="color: #fffffc">Reorder From Histroy</h4>
        </div>
        <div id="modalContent">

        </div>

    </div>
    <div class="modal fade modal-xl" id="saveClientModal" role="dialog" style="background-color: #fffffc;margin: auto">
        <div id="loading" class="folding-cube loader-blue-grey"
             style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <h4 style="color: #fffffc">@yield('title',trans(__('clients.create_update_client')))</h4>
        </div>
        <div id="client-modal-body" class="modal-body">

        </div>
    </div>
@stop

@section('scriptParts')
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script src="{{asset('/robust-assets/js/plugins/extensions/jquery.steps.min.js')}}"></script>
    <script src="{{asset('/robust-assets/js/plugins/extensions/listjs/list.min.js')}}"></script>
    <script src="{{asset('/robust-assets/js/plugins/extensions/listjs/list.fuzzysearch.min.js')}}"></script>
    <script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>

    <script src="{{asset('/assets/js/create_new_order/variables.js')}}"></script>
    <script src="{{asset('/assets/js/create_new_order/createnew_functions.js')}}"></script>
    <script src="{{asset('/assets/js/create_new_order/steps.js')}}"></script>
    <script src="{{asset('/assets/js/create_new_order/calculate_passenger.js')}}"></script>
    <script src="{{asset('/assets/js/dropin.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            if ($('#personal_order').val() == 0) {
                $('#client_company').html('');
            }
            $('#client').change(getCompanies).trigger('change');
            $('#personal_order').change(isPersonalOrder);
            $('#client_company').change(getDepartments);
            $('#is_trip').change(isTrip);
            $('#passenger_is_client').change(isClient);
            $('#clients').change(passengerOnChange);
        });

        var extratype = $('#extra_type'), extraprice = $('#extra_price');

        directionsDisplay.set('directions', null);
        endmarker.setVisible(false);
        startmarker.setVisible(false);
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
                draggable: false
            });
            endmarker = new google.maps.Marker({
                position: viyana,
                map: map,
                visible: false,
                icon: '{{asset('image/src/FlagFinish50.png')}}',
                draggable: false
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
            var start_location_input = document.getElementById('start_location');
            var start_autocomplete = new google.maps.places.Autocomplete(start_location_input);
            start_autocomplete.addListener('place_changed', function () {
                var place = start_autocomplete.getPlace();
                $("#start_location_placeid").val(place.place_id);
                $("#start_location_lat").val(place.geometry.location.lat());
                $("#start_location_lon").val(place.geometry.location.lng());
                geocoder.geocode({'latLng': place.geometry.location}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        $("#start_location_postalcode").val(postalCodeFromJson(results));
                        $("#start_location_geocode").val(JSON.stringify(results));
                    }
                });
            });
            var end_location_input = document.getElementById('end_location');
            var end_autocomplete = new google.maps.places.Autocomplete(end_location_input);
            end_autocomplete.addListener('place_changed', function () {
                var place = end_autocomplete.getPlace();
                $("#end_location_placeid").val(place.place_id);
                $("#end_location_lat").val(place.geometry.location.lat());
                $("#end_location_lon").val(place.geometry.location.lng());
                geocoder.geocode({'latLng': place.geometry.location}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        $("#end_location_postalcode").val(postalCodeFromJson(results));
                        $("#end_location_geocode").val(JSON.stringify(results));
                    }
                });
            });
        }

        var fromdiv = $('#fromdiv'), todiv = $('#todiv'), packageselect = $('#package');
        var resultinfo = $('.result_info');

        packageselect.on('change', function () {



            $('#duration').val(null);
            $('#kilometer').val(null);
            $('#startlocation').val(null);
            $('#endlocation').val(null);

            packid = packageselect.val();

            if (packid != null) {

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

        $(document.body).on("change", "#client", function () {
            getOrderHistory(this.value);
            current_clientid = this.value;
        });

        $('#client_company').select2({
            placeholder: ""
        });

        $('#client_company_department').select2({
            placeholder: ""
        });

        $('#client').select2({
            placeholder: "{{__("orders.placeholder_select_client")}}"
        });
        $('#package').select2({
            placeholder: "{{__("orders.placeholder_select_package")}}"
        });
        $('#driver').select2({
            placeholder: "{{__("orders.placeholder_select_driver")}}"
        });


        function isTrip() {
            if ($('#is_trip').val() == 1) {
                $("#select_package").show();
                $("#select_direction").hide();
            } else {
                $("#select_package").hide();
                $("#select_direction").show();
            }

        }

        /*     $('#is_trip-switch').change(function () {
                 if ($(this).prop('checked')) {

                 }
                 else {

                 }
             });*/
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent > 1) {
                $("#passengers").show();
                $("#locationsummary").hide();
            }
            else {
                $("#passengers").hide();
                $("#locationsummary").show();
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $(function () {
            $('#datetimepicker2').datetimepicker({
                locale: 'de',
                minDate: moment(),

            });
            document.getElementById('extra_type').onchange = function () {
                var value = this.selectedOptions[0].getAttribute('data-value');
                $('#extra_price').val(value);
            };


        });


        var markersArray = [];

        function addMarker(lat, lng, icon) {
            // Add the marker at the clicked location, and add the next-available label
            // from the array of alphabetical characters.
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
                map: map,
                icon: icon
            });
            markersArray.push(marker);
        }

        function clearMarkers() {
            startmarker.setVisible(false);
            endmarker.setVisible(false);
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray.length = 0;
        }



    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnaAC0y26o6z7SeXcmAwoDhSeGpdK4vAw&libraries=places&callback=initMap"
            async defer></script>

@stop