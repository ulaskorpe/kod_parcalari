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
                                        <!--
                                        <button type="button" title="Add Client" onclick="createClient()" class="btn"><i class="icon-user-plus2"></i></button>
                                        -->
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
                                    sl-geo<input type="text" id="startlocation_geocode" name="startlocation_geocode">
                                    startlocation<input type="text" id="startlocation" name="startlocation">
                                    placeid<input type="text" id="startlocation_placeid" name="startlocation_placeid">
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
                                                        <option value="">{{__('orders.please_select')}}</option>
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
    <script src="{{asset('/assets/js/dropin.min.js')}}"></script>
    <script src="{{asset('/assets/js/createnew_functions.js')}}"></script>
    <script type="text/javascript">
        function getCompanies() {
            $.get('/common/client_company/get_companies/' + $('#client').val(), function (data) {
                if (data) {
                    $('#togglePersonal').show(500);
                    if ($('#personal_order').val() == 1) {
                        $('#selectCompanyDiv').show(500);
                        $('#client_company').html('');
                        $('#client_company_department').html('');
                        $('#personal_order').val(1);
                    }
                    $('#client_company').html(data);

                } else {
                    $('#togglePersonal').hide(500);
                    $('#selectCompanyDiv').hide(500);
                }
            });


        }
        function getDepartments() {
            $.get('/common/client_company/get_departments/' + $('#client').val() + '/' + $('#client_company').val(), function (data) {
                $('#client_company_department').html(data);
                $('#goster').html(data);
            });
        }
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
        var userid = 0;
        var grad_total_amount = 0;
        var start_locations = [];
        var end_locations = [];
        var origins = [];
        var destinations = [];
        var distance_elements = [];
        var start_to_end = [];
        var start_to_start = [];
        var remained_start_locations = [];
        var roadmap_order = [];
        var taked_off = [];

        var current_clientid = 0;

        function fillParams() {
            var client_id = $("#client").val();

            var department_id = ($('#client_company_department').val()) ? $('#client_company_department').val() : 0;
            var client = ($('#client').val()) ? $('#client').val() : 0;
            var company_id = ($('#client_company').val()) ? $('#client_company').val() : 0;
            var jsonData = {
                //  client_id:client_id,
                company_id: company_id,
                department_id: department_id,
                client: client,
            };

            $("#params-clients").val(JSON.stringify(jsonData))
            //console.log(jsonData);
        }

        function isPersonalOrder() {
            if ($('#personal_order').val() == 1) {
                getCompanies();
                $('#selectCompanyDiv').show(500);
            } else {
                $('#selectCompanyDiv').hide(500);
                $('#client_company').html('');
                $('#client_company_department').html('');
            }


        }

        function isClient() {
            //  if ($('#is_client-switch').prop('checked')) {
            if ($('#passenger_is_client').val() == 1) {
                // $('#passenger_is_client').val(1);
                $("#clientsdiv").show();
            } else {
                ///$('#passenger_is_client').val(0);
                $("#clientsdiv").hide();
                $('#start_location').prop('readonly', false);
                $('#end_location').prop('readonly', false);
                $("#clientsplaces").html("");
            }


        }

        function getDrivers() {


            var duration = $('#duration').val() ? $('#duration').val() : 0;
            var vehicle_class = $('#vehicle_class').val() ? $('#vehicle_class').val() : 0;
            var package = $('#package').val() ? $('#package').val() : 0;
            var client_id = $('#client').val() ? $('#client').val() : 0;
            var is_trip = $("#is_trip").val();

            ///     console.log('[V:' + vehicle_class +' Cl:'+client_id+' Pa'+package+']');

            /*
            * Route::get('/find_drivers/{is_trip}/{package?}/{duration?}/{startDate?}/{client_id?}/{vehicle_class?}/{driver_id?}', 'OrderController@findDrivers');
            */

            $.get('/common/order/find_drivers/' + is_trip + '/' + package + '/' + duration + '/' + $('#start_date').val() + '/' + client_id + '/' + vehicle_class + '/0', function (data) {
                $('#driver').html(data);
                ///      console.log(data);
            });
        }



        function addPassenger() {


            if ($("#passenger_name").val() == "") {
                $("#passenger_name").val("Passenger-" + parseInt(passengerList.length + 1));
            }

            passengerList.push(
                {
                    start_location: $("#start_location").val(),
                    start_location_placeid: $("#start_location_placeid").val(),
                    start_location_lat: $("#start_location_lat").val(),
                    start_location_lon: $("#start_location_lon").val(),
                    start_location_postalcode: $("#start_location_postalcode").val(),
                    start_location_geocode: $("#start_location_geocode").val(),
                    end_location: $("#end_location").val(),
                    end_location_placeid: $("#end_location_placeid").val(),
                    end_location_lat: $("#end_location_lat").val(),
                    end_location_lon: $("#end_location_lon").val(),
                    end_location_postalcode: $("#end_location_postalcode").val(),
                    end_location_geocode: $("#end_location_geocode").val(),
                    passenger_is_client: $("#passenger_is_client").val(),
                    passenger_client_id: $("#clients").val(),
                    gsm_phone: $("#gsm_phone").val(),
                    passenger_name: $("#passenger_name").val(),
                    flight_number: $("#flight_number").val(),
                    flight_from: $("#flight_from").val(),
                    flight_company: $("#flight_company").val(),
                }
            );
            fillPassengerList();
            $("#start_location").val("");
            $("#start_location_placeid").val("");
            $("#start_location_lat").val("");
            $("#start_location_lon").val("");
            $("#start_location_postalcode").val("");
            $("#start_location_geocode").val("")
            $("#end_location").val("");
            $("#end_location_placeid").val("");
            $("#end_location_lat").val("");
            $("#end_location_lon").val("");
            $("#end_location_postalcode").val("");
            $("#end_location_geocode").val("")
            $("#gsm_phone").val("");
            $("#passenger_name").val("");
            $("#flight_number").val("");
            $("#flight_from").val("");
            $("#flight_company").val("");
            $("#clients").val("0");
            //$("#number_of_passengers").val( int($("#number_of_passengers").val())+1);


        }


        var extratype = $('#extra_type'), extraprice = $('#extra_price');
        var extraList = [];
        var passengerList = [];
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
                //frominput.on('change',fromTextChanged);

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


        var frommarkerplace, tomarkerplace;

        function fromTextChanged() {
            $("#main_passenger").html($("#client option:selected").text());
            $("#main_startlocation").html($("#from_actb").val());
            $("#main_endlocation").html($("#to_actb").val());

            frommarkerplace = fromautocomplete.getPlace();
            console.log(frommarkerplace);

        //    map.panTo(48.1604766,16.381990900000005);
          //  startmarker.setPosition(48.1604766,16.381990900000005);
            var pos = $("#startlocation").val();
            map.panTo(pos);
          //  startmarker.setPosition(frommarkerplace.geometry.location);
            startmarker.setPosition(pos);
            startmarker.setVisible(true);
            $("#startlocation_placeid").val(frommarkerplace.place_id);
            writeStartInfo(calcRoute);


        }

        function toTextChanged() {
            $("#main_passenger").html($("#client option:selected").text());
            $("#main_startlocation").html($("#from_actb").val());
            $("#main_endlocation").html($("#to_actb").val());

            tomarkerplace = toautocomplete.getPlace();
            map.panTo(tomarkerplace.geometry.location);
            endmarker.setPosition(tomarkerplace.geometry.location);
            endmarker.setVisible(true);
            $("#endlocation_placeid").val(tomarkerplace.place_id);
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


            $('#startlocation').val(JSON.stringify({
                'lat': startmarker.getPosition().lat(),
                'lon': startmarker.getPosition().lng()
            }));

            $('#startaddress').val("");

            geocoder.geocode({'latLng': startmarker.getPosition()}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    $('#startpostalcode').val(postalCodeFromJson(results));
                    startgeocode = results;
                    $("#startlocation_geocode").val(JSON.stringify(startgeocode));
                    $('#startaddress').val(results[0].formatted_address);
                    if (callback) callback();
                } else {
                    alert("Start Point's Information is NOT recieved!\n\n Error Code:\n" + status);
                }

            });
        }

        function writeEndInfo(callback) {

            endgeocode = null;

            $('#endlocation').val(JSON.stringify({
                'lat': endmarker.getPosition().lat(),
                'lon': endmarker.getPosition().lng()
            }));

            $('#endaddress').val("");

            geocoder.geocode({'latLng': endmarker.getPosition()}, function (results, status) {

                if (status === google.maps.GeocoderStatus.OK) {

                    $('#endpostalcode').val(postalCodeFromJson(results));

                    endgeocode = results;
                    $("#endlocation_geocode").val(JSON.stringify(endgeocode));
                    $('#endaddress').val(results[0].formatted_address);
                    if (callback) callback();
                } else {
                    alert("Finish Point's Information is NOT recieved!\n\n Error Code:\n" + status);
                }
            });
        }

        var packid;
        var totalcapacity;
        var totalprice = 0;

        function calculate_Price() {

            $.ajax({
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}'
                    , 'client': $('#client').val()
                    , 'vehicle_class': $('#vehicle_class').val()
                    , 'is_trip': $("#is_trip").val()
                    , 'package': $("#package").val()
                    , 'startgeocode': JSON.stringify(startgeocode)
                    , 'endgeocode': JSON.stringify(endgeocode)
                    , 'extras': extraList
                    , 'passengers': passengerList
                    , 'kilometer': $("#kilometer").val()
                    , 'passanger_count': $("#number_of_passengers").val()

                },
                url: '/common/order/getprices',
                success: function (result) {
                    $('#orderSummary').html(result);
                    $('#priceSummary').html($('#summaryPrice').html());
                }
            });


        }


        function calcRoute() {

            if (startmarker.getVisible() && endmarker.getVisible()) {

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

            totalkm = myleg.distance.value / 1000;
            $('#kilometer').val(totalkm);

            var totalmin = myleg.duration.value / 60;
            $('#duration').val(totalmin);

            var content = "";
            content += 'Distance: ' + myleg.distance.text + '<br>';
            content += 'Duration: ' + myleg.duration.text + '<br>';
            $('#result_info_div').html(content);
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


        function addExtra() {
            if (document.getElementById('extra_type').selectedOptions[0].innerHTML != "") {
                var value = document.getElementById('extra_type').selectedOptions[0].innerHTML;
                extraList.push({
                    extraid: $('#extra_type').val(),
                    extraname: value,
                    extraprice: $('#extra_price').val()
                });
                fillExtraList();
            }
            else {
                toastr.options.positionClass = "toast-container toast-bottom-full-width";
                toastr["error"]("Please select an extra type");
                return false;
            }

        }




        function removeExtra(key) {
            extraList.splice(key, 1);
            fillExtraList();
        }

        function removePassenger(key) {
            passengerList.splice(key, 1);
            fillPassengerList();
        }

        function getPassengerToUpdate(key) {
            $('#start_location').prop('readonly', false);
            $('#end_location').prop('readonly', false);
            var passenger = passengerList[key];
            $('#start_location').val(passenger.start_location);
            $('#end_location').val(passenger.end_location);
            $("#passenger_name").val(passenger.passenger_name);
            $("#gsm_phone").val(passenger.gsm_phone);
            $("#flight_from").val(passenger.flight_from);
            $("#flight_company").val(passenger.flight_company);
            $("#flight_number").val(passenger.flight_number);
            $("#passenger_is_client").val(passenger.passenger_is_client);
            $("#passenger_client_id").val(passenger.passenger_client_id);
            passengerList.splice(key, 1);
        }

        function fillExtraList() {
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

        function fillPassengerList() {
            var content = "";
            var submitvalues = [];
            for (var key in passengerList) {
                if (typeof passengerList[key] !== 'undefined' && passengerList[key] != null) {
                    content += '<tr><td>' + passengerList[key].passenger_name + '</td>';
                    content += '<td>' + passengerList[key].start_location + '</td>';
                    content += '<td>' + passengerList[key].end_location + '</td>';
                    content += '<td><button type="button" onclick="getPassengerToUpdate(' + key + ')" class="btn btn-float btn-sm btn-warning delete"><i class="icon-pencil"></i></button> <button type="button" onclick="removePassenger(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
                }
            }
            $('#passengerlist').val(JSON.stringify(passengerList));
            $('#passenger_list_body').html(content);
        }


        $(".number-tab-steps").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: 'Submit'
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                // Always allow previous action even if the current form is not valid!


                if (currentIndex == 0 && newIndex == 1) { ///// 0->1
                    fillParams();
                    if ($("#client").val() > 0) {
                        getSpecialPackages();

                        return true;
                    }
                    else {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"]("Please select a client...");
                        return false;
                    }
                }
                if (currentIndex == 1 && newIndex == 2) {///1->2

                    var passengerCount = $("#number_of_passengers").val();
                    getVehicles(passengerCount);
                    getDrivers();

                    //  if ($('#travel_type').prop('checked')) {
                    if ($("#is_trip").val() == 1) {

                        if ($('#package').val() > 0) {

                            return true;
                        }
                        else {
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"]("Please select a package...");
                            return false;
                        }
                    }
                    else {
                        //$("#is_trip").val(0);
                        if ($('#from_actb').val() != "" && $('#to_actb').val() != "") {
                            clearRouteInfos();
                            if (passengerList.length > 0) {
                                origins.push($('#from_actb').val());
                                for (var key in passengerList) {
                                    origins.push(passengerList[key].start_location);
                                }
                                origins.push($('#to_actb').val());
                                for (var key in passengerList) {
                                    origins.push(passengerList[key].end_location);
                                }
                                destinations.push($('#from_actb').val());
                                for (var key in passengerList) {
                                    destinations.push(passengerList[key].start_location);
                                }
                                destinations.push($('#to_actb').val());
                                for (var key in passengerList) {
                                    destinations.push(passengerList[key].end_location);
                                }

                                getDistances(origins, destinations);

                            } else {

                                return true;
                            }

                        } else {
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"]("Please enter a start and finish location");
                            return false;
                        }
                    }


                }

                if (currentIndex == 2 && newIndex == 3) { ///2->3

                    if ($("#vehicle_class").val() > 0) {
                        calculate_Price();

                        return true;
                    }
                    else {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"]("Please select a vehicle type");
                        return false;
                    }


                }
                if (currentIndex == 3 && newIndex == 4) {

                    getCreditCard();
                    return true;
                }
                else {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                /* if (currentIndex < newIndex) {
                     // To remove error styles

                 }*/

            },
            onFinished: function (event, currentIndex) {

                //event listener is on click a href=#finish...
                //creditcard.blade

            }
        });


        function getOrderHistory(clientId) {

            if(clientId){
            $('#loading').show();
            $.get('/common/order/getorderhistory/'.concat(clientId)).done(function (data) {
                if (data === "") {
                    $('#orderHistory').hide();
                    $('#loading').hide();
                } else {
                    $('#orderHistoryList').html(data);
                    $('#loading').hide();
                    $('#orderHistory').show();
                    var options = {
                        valueNames: ['package_name', 'order_date']
                    };

                    var userList = new List('orderList', options);
                }
            }).fail(function (data) {
                if (data.status === 422) {
                    var errors = data.responseJSON;
                    var errosHtml = "";
                    $.each(errors, function (key, value) {
                        var id = "#".concat(key);
                        $("#" + key).css("border", '1px solid red');
                        $("#" + key).effect("shake");
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"](value[0]);
                    });
                }
            });

            }
        }

        function getVehicles(passengerCount) {
            $.get('/common/order/getvehicles/'.concat(passengerCount)).done(function (data) {
                $('#vehicle_class').html(data);
            }).fail(function (data) {
                if (data.status === 422) {
                    var errors = data.responseJSON;
                    var errosHtml = "";
                    $.each(errors, function (key, value) {
                        var id = "#".concat(key);
                        $("#" + key).css("border", '1px solid red');
                        $("#" + key).effect("shake");
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"](value[0]);
                    });
                }
            });
        }

        function getReorder(orderid) {
            $('#loading').show();
            //   $.get('/manager/order/createreorder/'.concat(orderid)).done(function (data) {
            $.get('/common/order/createreorder/'.concat(orderid)).done(function (data) {
                $('#loading').hide();
                $('#modalContent').html(data);
                $('#reorderModal').modal();

            }).fail(function (data) {
                if (data.status === 422) {
                    var errors = data.responseJSON;
                    var errosHtml = "";
                    $.each(errors, function (key, value) {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"](value[0]);
                    });
                }
            });


        }


        function getSpecialPackages() {

            var client_id = ($('#client').val()) ? $('#client').val() : 0;
            var company_id = ($('#client_company').val()) ? $('#client_company').val() : 0;

            $.get('/common/order/get_special_packages/' + client_id, function (data) {
                $('#package').html(data);

                if (data) {
                    $('#togglePersonal').show();
                }

            });

            getDepartments();

        }

        function getCreditCard() {
            var client_id = ($('#client').val()) ? $('#client').val() : 0;

         //   console.log('/common/order/getcreditcard' + '/' + client_id);

            $.get('/common/order/getcreditcard' + '/' + client_id, function (data) {
                $("#dropin-card").html(data);
            }).fail(function (data) {
                console.log(data);
            });
        }

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

        function passengerOnChange() {
            $('#start_location').prop('readonly', false);
            $('#end_location').prop('readonly', false);

            var val = $("#clients option:selected").val();
            if (current_clientid == val) {
                toastr.options.positionClass = "toast-container toast-bottom-full-width";
                toastr["error"]("This client currently selected, please select another client.");
                return;
            } else {
                for (var i = 0; i < passengerList.length; i++) {
                    if (passengerList[i]["passenger_client_id"] == val) {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"]("This client is added as passanger, please select another client.");
                        return;
                    }
                }

                var data = $("#clients option:selected").text();
                $("#passenger_name").val(data.trim());
                var client_id = $("#clients option:selected").val();
                getClientDirections(client_id);
            }
        }

        function getClientDirections(client_id) {
            $.get('/common/order/getclientdirections/' + client_id, function (data) {
                $("#clientsplaces").html(data);
            });
        }

        function createClient() {
       /*     $("#loading").show();
            $.get('/manager/client/create', function (mdata) {
                $("#loading").hide();
                $("#client-modal-body").html(mdata);
            });
            $('#saveClientModal').modal();*/
        }

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

        ////-----------------------START---PASSENGERS ROUTE ORDER CALCULATE -----------------------------------------------///////////

        function getDistances(origins, destinations) {
            var service = new google.maps.DistanceMatrixService;
            service.getDistanceMatrix({
                origins: origins,
                destinations: destinations,
                travelMode: 'DRIVING',
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, function (response, status) {
                if (status !== 'OK') {
                    alert('Error was: ' + status);
                } else {
                    var rows = response.rows;
                    for (var i = 0; i < rows.length; i++) {
                        var elements = rows[i].elements;
                        for (var j = 0; j < elements.length; j++) {
                            var element = new Object();
                            element.start_location_id = i;
                            element.end_location_id = j;
                            element.distance = elements[j].distance.value;
                            element.duration = elements[j].duration.value;


                            if (element.distance > 0) {
                                distance_elements.push(element);
                            }


                            distance_elements.sort(function (a, b) {
                                if (a.distance < b.distance)
                                    return -1;
                                if (a.distance > b.distance)
                                    return 1;
                                return 0;
                            });
                        }
                    }
                }
                rearrangeDistanceElements();
                calculateDistance();

                calcRouteWithPassengers();
                $("#roadmaporderlist").val(JSON.stringify(roadmap_order));
                $("#originlist").val(JSON.stringify(origins));
                //   console.log("roadmap_order", roadmap_order);
                //  console.log("taked_off", taked_off);
                // console.log("remained_start_locations", remained_start_locations);
            });


        }

        function rearrangeDistanceElements() {
            //Define start/end locations and order distance_elements by distance asc
            for (var i = 0; i < destinations.length; i++) {
                if (i < origins.length / 2)
                    start_locations.push({id: i, location: destinations[i]});
                else
                    end_locations.push({id: i, location: destinations[i]});
            }


            for (var i = 0; i < distance_elements.length; i++) {
                if (distance_elements[i].start_location_id < start_locations.length) {
                    if (distance_elements[i].end_location_id >= start_locations.length)
                        start_to_end.push(distance_elements[i]);


                }
                if (distance_elements[i].start_location_id < start_locations.length) {
                    if (distance_elements[i].end_location_id <= start_locations.length)
                        start_to_start.push(distance_elements[i])

                }

            }
            /*       console.log("start_locations:", start_locations);
                   console.log("end_locations:", end_locations);
                   console.log("distance_elements:", distance_elements);
                   console.log("start_to_end:", start_to_end);
                   console.log("start_to_start:", start_to_start);*/
        }

        function calculateDistance() {
            //This is the first calculate of know start location. The first location can be start->to->end or start->to->start point.
            //roadmap_order.length < origins.length is true that means loop is finished and roadmap order is ready.
            if (roadmap_order.length < origins.length) {
                var start = new Object();
                var min_start_to_start = start_to_start[0];
                var min_start_to_end = $.grep(start_to_end, function (e) {
                    return e.end_location_id == e.start_location_id + start_locations.length;
                })[0];

                if (min_start_to_start.distance < min_start_to_end.distance) {
                    start.status = "start_to_start";
                    start.direction = min_start_to_start;
                }
                else {
                    start.status = "start_to_end";
                    start.direction = min_start_to_end;
                }

                roadmap_order.indexOf(start.direction.start_location_id) === -1 ? roadmap_order.push(start.direction.start_location_id) : console.log("This item already exists", start.direction.start_location_id);
                roadmap_order.indexOf(start.direction.end_location_id) === -1 ? roadmap_order.push(start.direction.end_location_id) : console.log("This item already exists", start.direction.end_location_id);

                ///    console.log("start", start);
                var second_stop;
                if (start.status == "start_to_start") {
                    var start1 = start.direction.start_location_id;
                    var end1 = parseInt(start1 + origins.length / 2);

                    var start2 = start.direction.end_location_id;
                    var end2 = parseInt(start2 + origins.length / 2);

                    remained_start_locations = $.grep(start_locations, function (e) {
                        return e.id != start.direction.start_location_id && e.id != start.direction.end_location_id;

                    });

                    var remained_directons = [];
                    if (remained_start_locations.length > 0) {
                        for (var i = 0; i < remained_start_locations.length; i++) {
                            var id = remained_start_locations[i].id;
                            remained_directons.push($.grep(distance_elements, function (e) {
                                return e.start_location_id != start.direction.start_location_id
                                    && e.end_location_id != start.direction.end_location_id
                                    && e.end_location_id != start.direction.start_location_id
                                    && e.start_location_id == start.direction.end_location_id
                                    && e.end_location_id == id;
                            })[0]);
                        }
                    }

                    var direction1 = $.grep(start_to_end, function (e) {
                        return e.start_location_id == start1 && e.end_location_id == end1;
                    })[0];
                    var direction2 = $.grep(start_to_end, function (e) {
                        return e.start_location_id == start2 && e.end_location_id == end2;
                    })[0];


                    remained_directons.push(direction1);
                    remained_directons.push(direction2);

                    remained_directons.sort(function (a, b) {
                        if (a.distance < b.distance)
                            return -1;
                        if (a.distance > b.distance)
                            return 1;
                        return 0;
                    });

                    var newStart = new Object();
                    if (remained_directons[0].end_location_id - remained_directons[0].start_location_id == start_locations.length) {
                        newStart.status = "start_to_end";
                        newStart.direction = remained_directons[0];
                    }
                    if (remained_directons[0].start_location_id < start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                        newStart.status = "start_to_start";
                        newStart.direction = remained_directons[0];
                    }


                    /*      console.log("remained_start_locations", remained_start_locations);
                          console.log("remained_directons", remained_directons);
                          console.log("newStart--", newStart);*/

                    // calculateStart_To_Start_Directions(newStart);

                    if (newStart.status == "start_to_start") {
                        calculateStart_To_Start_Directions(newStart)
                    }
                    if (newStart.status == "start_to_end") {
                        calculateStart_To_End_Directions(newStart)
                    }
                    if (newStart.status == "end_to_start") {
                        calculateEnd_To_Start_Directions(newStart);
                    }


                }
                if (start.status == "start_to_end") {
                    var start1 = start.direction.start_location_id;
                    var end1 = parseInt(start1 + origins.length / 2);

                    var start2 = start.direction.end_location_id;
                    var end2 = parseInt(start2 + origins.length / 2);

                    remained_start_locations = $.grep(start_locations, function (e) {
                        return e.id != start.direction.start_location_id && e.id != start.direction.end_location_id;

                    });
                    calculateStart_To_End_Directions(start)
                }

            }
            else {
                return;
            }


        }

        function calculateStart_To_Start_Directions(start) {
            //This function calculate start->to->start direction and arrange after direction.
            if (roadmap_order.length < origins.length) {
                var start1 = start.direction.start_location_id;
                var end1 = parseInt(start1 + origins.length / 2);

                var start2 = start.direction.end_location_id;
                var end2 = parseInt(start2 + origins.length / 2);

                remained_start_locations = $.grep(remained_start_locations, function (e) {
                    return e.id != start.start_location_id && e.id != start.end_location_id;
                });
                var remained_directons = [];

                if (remained_start_locations.length > 0) {
                    for (var i = 0; i < remained_start_locations.length; i++) {
                        var id = remained_start_locations[i].id;
                        remained_directons.push($.grep(distance_elements, function (e) {
                            return e.start_location_id != start.direction.start_location_id
                                && e.end_location_id != start.direction.end_location_id
                                && e.end_location_id != start.direction.start_location_id
                                && e.start_location_id == start.direction.end_location_id
                                && e.end_location_id == id;
                        })[0]);
                    }
                }

                var direction1 = $.grep(start_to_end, function (e) {
                    return e.start_location_id == start1 && e.end_location_id == end1;
                })[0];
                var direction2 = $.grep(start_to_end, function (e) {
                    return e.start_location_id == start2 && e.end_location_id == end2;
                })[0];

                remained_directons.push(direction1);
                remained_directons.push(direction2);
                remained_directons.sort(function (a, b) {
                    if (a.distance < b.distance)
                        return -1;
                    if (a.distance > b.distance)
                        return 1;
                    return 0;
                });
                var newStart = new Object();
                if (Math.abs(remained_directons[0].end_location_id - remained_directons[0].start_location_id) == start_locations.length) {
                    newStart.status = "start_to_end";
                    newStart.direction = remained_directons[0];
                }
                if (remained_directons[0].start_location_id < start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                    newStart.status = "start_to_start";
                    newStart.direction = remained_directons[0];
                }

                roadmap_order.indexOf(newStart.direction.start_location_id) === -1 ? roadmap_order.push(newStart.direction.start_location_id) : "Nothing to do";
                roadmap_order.indexOf(newStart.direction.end_location_id) === -1 ? roadmap_order.push(newStart.direction.end_location_id) : "Nothing to do";

                //console.log("calculateDirections-remained_directons", remained_directons);
                //console.log("calculateDirections-newStart", newStart);

                if (newStart.status == "start_to_start") {
                    calculateStart_To_Start_Directions(newStart)
                }
                if (newStart.status == "start_to_end") {
                    calculateStart_To_End_Directions(newStart)
                }
                if (newStart.status == "end_to_start") {
                    calculateEnd_To_Start_Directions(newStart);
                }
            }
            else {
                return;
            }


        }

        function calculateStart_To_End_Directions(start) {
            //This function calculate start->to->end direction and arrange after direction.
            //This function keeps departures which is finished.
            var start1 = start.direction.start_location_id;
            var end1 = start.direction.end_location_id;
            taked_off.push(start1);

            if (roadmap_order.length < origins.length) {


                start_to_end = $.grep(start_to_end, function (e) {
                    return e.start_location_id != start1 && e.end_location_id != end1
                });


                // console.log("A1:",start1,end1)
                remained_start_locations = $.grep(remained_start_locations, function (e) {
                    return e.id != start.direction.start_location_id && e.id != start.direction.end_location_id;
                });

                //console.log("calculateStart_To_End_Directions-remained_start_locations", remained_start_locations);


                var remained_directons = [];
                if (remained_start_locations.length > 0) {
                    for (var i = 0; i < remained_start_locations.length; i++) {
                        var id = remained_start_locations[i].id;
                        remained_directons.push($.grep(distance_elements, function (e) {
                            return e.start_location_id != start.direction.start_location_id
                                && e.end_location_id != start.direction.end_location_id
                                && e.end_location_id != start.direction.start_location_id
                                && e.start_location_id == start.direction.end_location_id
                                && e.end_location_id == id;
                        })[0]);
                    }
                }

                for (var i = 0; i < roadmap_order.length; i++) {
                    var direction = $.grep(start_to_end, function (e) {
                        if (roadmap_order[i] < origins.length / 2) {
                            for (var j = 0; j < taked_off.length; j++) {
                                return e.start_location_id == roadmap_order[i]
                                    && e.start_location_id != taked_off[j]
                                    && e.end_location_id == roadmap_order[i] + origins.length / 2;
                            }
                        }
                    })[0];
                    if (direction !== undefined)
                        remained_directons.push(direction);
                }

                remained_directons.sort(function (a, b) {
                    if (a.distance < b.distance)
                        return -1;
                    if (a.distance > b.distance)
                        return 1;
                    return 0;
                });
                //console.log("remained_directons-calculateStart_To_End_Directions", remained_directons);

                var newStart = new Object();
                if (Math.abs(remained_directons[0].end_location_id - remained_directons[0].start_location_id) == start_locations.length) {
                    newStart.status = "start_to_end";
                    newStart.direction = remained_directons[0];
                }

                if (remained_directons[0].start_location_id >= start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                    newStart.status = "end_to_start";
                    newStart.direction = remained_directons[0];

                }
                if (remained_directons[0].start_location_id < start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                    newStart.status = "start_to_start";
                    newStart.direction = remained_directons[0];
                }
                //console.log("This item already exists", newStart.direction.start_location_id)
                //console.log("This item already exists", newStart.direction.end_location_id)
                roadmap_order.indexOf(newStart.direction.start_location_id) === -1 ? roadmap_order.push(newStart.direction.start_location_id) : "Nothing to do";
                roadmap_order.indexOf(newStart.direction.end_location_id) === -1 ? roadmap_order.push(newStart.direction.end_location_id) : "Nothing to do";


                if (newStart.status == "start_to_start") {
                    calculateStart_To_Start_Directions(newStart)
                }
                if (newStart.status == "start_to_end") {
                    calculateStart_To_End_Directions(newStart)
                }
                if (newStart.status == "end_to_start") {
                    calculateEnd_To_Start_Directions(newStart);
                }


                //console.log("newStart-calculateStart_To_End_Directions", newStart);


            }
            else {
                return;
            }


        }

        function calculateEnd_To_Start_Directions(start) {
            if (roadmap_order.length < origins.length) {
                var start1 = start.direction.start_location_id;
                var end1 = start.direction.end_location_id;

                remained_start_locations = $.grep(remained_start_locations, function (e) {
                    return e.id != start.direction.start_location_id && e.id != start.direction.end_location_id;
                });

                var remained_directons = [];

                for (var i = 0; i < remained_start_locations.length; i++) {
                    var id = remained_start_locations[i].id;
                    remained_directons.push($.grep(distance_elements, function (e) {
                        return e.start_location_id != start.direction.start_location_id
                            && e.end_location_id != start.direction.end_location_id
                            && e.end_location_id != start.direction.start_location_id
                            && e.start_location_id == start.direction.end_location_id
                            && e.end_location_id == id;
                    })[0]);
                }
                for (var i = 0; i < roadmap_order.length; i++) {
                    var direction = $.grep(start_to_end, function (e) {
                        if (roadmap_order[i] < origins.length / 2) {
                            for (var j = 0; j < taked_off.length; j++) {
                                return e.start_location_id == roadmap_order[i] && e.start_location_id != taked_off[j] && e.end_location_id == roadmap_order[i] + origins.length / 2;
                            }
                        }
                    })[0];
                    if (direction !== undefined)
                        remained_directons.push(direction);
                }

                remained_directons.sort(function (a, b) {
                    if (a.distance < b.distance)
                        return -1;
                    if (a.distance > b.distance)
                        return 1;
                    return 0;
                });

                var newStart = new Object();
                if (Math.abs(remained_directons[0].end_location_id - remained_directons[0].start_location_id) == start_locations.length) {
                    newStart.status = "start_to_end";
                    newStart.direction = remained_directons[0];
                }
                if (remained_directons[0].start_location_id < start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                    newStart.status = "start_to_start";
                    newStart.direction = remained_directons[0];
                }
                if (remained_directons[0].start_location_id >= start_locations.length && remained_directons[0].end_location_id < start_locations.length) {
                    newStart.status = "end_to_start";
                    newStart.direction = remained_directons[0];

                }
                // console.log("newStart-calculateEnd_To_Start_Directions", newStart);
                // console.log("Xremained_directons-calculateEnd_To_Start_Directions", remained_directons);
                roadmap_order.indexOf(newStart.direction.start_location_id) === -1 ? roadmap_order.push(newStart.direction.start_location_id) : "Nothing to do";
                roadmap_order.indexOf(newStart.direction.end_location_id) === -1 ? roadmap_order.push(newStart.direction.end_location_id) : "Nothing to do";

                if (newStart.status == "start_to_start") {
                    calculateStart_To_Start_Directions(newStart)
                }
                if (newStart.status == "start_to_end") {
                    calculateStart_To_End_Directions(newStart)
                }
                if (newStart.status == "end_to_start") {
                    calculateEnd_To_Start_Directions(newStart);
                }


            } else {
                return;
            }


        }


        function calcRouteWithPassengers(waypoints_arr) {
            var waypoints_arr = [];
            for (var i = 1; i < roadmap_order.length - 1; i++) {
                var waypoint = new Object();
                waypoint.location = origins[roadmap_order[i]];
                waypoint.stopover = true;
                waypoints_arr.push(waypoint);
            }
            var request = {
                origin: origins[roadmap_order[0]],
                destination: destinations[roadmap_order[roadmap_order.length - 1]],
                waypoints: waypoints_arr,
                optimizeWaypoints: false,
                provideRouteAlternatives: false,
                travelMode: 'DRIVING',

                unitSystem: google.maps.UnitSystem.METRIC
            };

            directionsService.route(request, function (response, status) {
                directionsDisplay.set('directions', null);
                directionsDisplay = new google.maps.DirectionsRenderer();
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);

                computeTotalDistanceWithPassengers(directionsDisplay.getDirections());
            });
        }

        function computeTotalDistanceWithPassengers(result) {
            clearMarkers();
            var myleg = result.routes[0].legs;
            var totalkm = 0;
            var totalmin = 0;
            for (var i = 0; i < myleg.length; i++) {
                totalkm += (myleg[i].distance.value / 1000);
                totalmin += (myleg[i].duration.value / 60);
                if (i == 0)
                    addMarker(myleg[i].start_location.lat(), myleg[i].start_location.lng(), "");
                if (i == myleg.length - 1)
                    addMarker(myleg[i].end_location.lat(), myleg[i].end_location.lng(), "");
                else
                    addMarker(myleg[i].end_location.lat(), myleg[i].end_location.lng(), "");

            }


            $('#kilometer').val(Math.round(totalkm));
            $('#duration').val(totalmin);

            var h = totalmin / 60 | 0,
                m = totalmin % 60 | 0;
            var content = "";
            content += 'Distance: ' + Math.round(totalkm) + ' km<br>';
            content += 'Duration: ' + h + ' hours ' + m + ' minutes' + '<br>';
            $('#result_info_div').html(content);
        }

        function clearRouteInfos() {

            origins = [];
            destinations = [];
            start_locations = [];
            end_locations = [];
            taked_off = [];
            remained_start_locations = [];
            roadmap_order = [];

        }

        ////-----------------------END---PASSENGERS ROUTE ORDER CALCULATE -----------------------------------------------///////////


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_API_KEY")}}&libraries=places&callback=initMap"
            async defer></script>

@stop