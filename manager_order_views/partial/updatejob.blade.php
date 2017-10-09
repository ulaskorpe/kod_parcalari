<form id="formJobUpdate" name="formJobUpdate" method="post" action="{{route('manager.order.jobupdate')}}">
    {{csrf_field()}}
    <input type="text" id="jobid" name="jobid" style="display: none">
    <div class="row">
        <div class="col-md-6">
            <label for="orderid" class="control-label"> {{__('orders.order_id')}}</label>

            <input type="text" id="orderid" name="orderid" class="form-control" value="{{old('orderid',$model->id)}}"
                   disabled>
        </div>
        <div class="col-md-6">
            <label for="name" class="control-label"> {{__('orders.client_name')}} {{$model->client->id}}</label> <input
                    type="text" id="name" name="name" class="form-control"
                    value="{{old('name',$model->client->user->name.' '.$model->client->user->last_name)}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="orderdate" class="control-label"> {{__('orders.order_date')}}</label>
            <input type="text" id="orderdate" name="orderdate" class="form-control" value="{{$model->start_time}}">
        </div>
        <div class="col-md-6">
            <label for="phone" class="control-label"> {{__('orders.client_phone')}} </label>
            <input type="text" id="phone" name="phone" value="{{$model->client->user->gsm_phone}}" class="form-control"
                   readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="driver" class="control-label"> {{__('orders.driver')}} </label>
            <select id="driver" name="driver" class="form-control">
                <option title="Unassigned" value="2147483647"></option>

                @foreach($drivers as $d)
                    <option title="{{ $d->id }}" value="{{ $d->id }}"
                            @if($d->id == $model->jobs[0]->driver_id) selected @endif>
                        {{ $d->user->name }}   {{ $d->user->last_name }}
                    </option>
                @endforeach

            </select>
        </div>
        <div class="col-md-6">


            <label for="company" class="control-label"> {{__('orders.client_company')}}</label>
            @if($model->client->client_company_id)
                <input type="text" id="company" name="company" class="form-control"
                       value="{{$model->client->company->company_name}}" readonly>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="ordermethod" class="control-label"> {{__('orders.other_method')}}</label>
            <select id="ordermethod" name="ordermethod" class="form-control">
                @foreach( $order_methods as $order_method)
                    <option value="{{$order_method->id}}" title="{{$order_method->name}}"
                            @if($order_method->id == $model->order_method_id) selected @endif>{{$order_method->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"><label for="passengertitle"
                                             class="control-label">{{__('orders.passenger_title')}} </label> <input
                            type="text" id="passengertitle" name="passengertitle"
                            class="form-control" value="{{old('passengertitle',$model->passenger_title)}}"></div>
                <div class="col-md-8"><label for="passengername"
                                             class="control-label"> {{__('orders.passenger_name')}} </label> <input
                            type="text" id="passengername" name="passengername" value="{{old('passengername',$model->passenger_name)}}"
                            class="form-control"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="package" class="control-label"> {{__('orders.package')}} </label>
            <input type="text" id="package" name="package" value="{{$model->package->name}}"   class="form-control" readonly>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3">
                    <label for="flightnumber" class="control-label"> {{__('orders.flight_no')}} </label>
                    <input type="text" id="flightnumber"  name="flightnumber" class="form-control" value="{{old('flight_no',$model->flight_number)}}">
                </div>
                <div class="col-md-4">
                    <label for="flightfrom" class="control-label"> {{__('orders.flight_from')}} </label>
                    <input type="text"  id="flightfrom"  name="flightfrom" value="{{old('flightfrom',$model->flight_from)}}" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="flightcompany" class="control-label">  {{__('orders.flight_company')}} </label>

                    <input type="text"  id="flightcompany"   name="flightcompany" value="{{old('flightcompany',$model->flight_company)}}"     class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-8">
                    <label for="paymenttype" class="control-label">  {{__('orders.payment_type')}} </label>
                    <select id="paymenttype" name="paymenttype" class="form-control">
                        @foreach( $payment_types as $payment_type)
                            <option value="{{$payment_type->id}}" @if($model->payment_type_id == $payment_type->id) selected @endif>{{$payment_type->payment_title}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-4">
                    <label for="price" class="control-label">  {{__('orders.price')}} </label> <input type="text" id="price" name="price"
                                                                                    class="form-control" value="{{$model->price}}" readonly>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="vehicleclass" class="control-label">  {{__('orders.vehicle_class')}} </label>
            <input type="text" id="vehicleclass"   name="vehicleclass"    class="form-control" value="{{$model->jobs[0]->vehicleclass->name}}"  readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="startadress" class="control-label"> {{__('orders.start_address')}}</label>
            <input type="text" id="startadress"   name="startadress" value="{{$model->start_address}}"    class="form-control" readonly>
        </div>
        <div class="col-md-6">
            <label for="kostenstelle" class="control-label"> {{__('orders.kostenstelle')}}</label>
            <input type="text" id="kostenstelle"  name="kostenstelle" value="{{$model->kostenstelle}}"  class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="note" class="control-label"> {{__('orders.start_address')}} </label>
            <textarea id="note" name="note" class="form-control">{{$model->note}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="drivernote" class="control-label">{{__('orders.note_for_driver')}}</label>
            <textarea id="drivernote"  name="drivernote" class="form-control">{{$model->drivernote}}</textarea>
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">
        <div class="col-md-12">
        <button class="btn btn-danger pull-md-5" type="submit">
            <i class="icon-check"></i> {{__('orders.update_order')}}
        </button>
        </div>
    </div>
</form>

<script>

    $('#formJobUpdate').submit(function(e){
        e.preventDefault();

        save({{$model->id}});
    });


    function save(Id) {
        $("#loading").show();
        $.post('/manager/order/jobupdate/{{$model->id}}', $('#formJobUpdate').serialize(), function (data) {
            $("#loading").hide();
            // swal("Created!", "Vehicle is created !", "success");
            swal("{{__('orders.order_updated')}}",  "{{__('orders.order_updated')}}", "success");
            location.reload();
        }).fail(function (data) {
            if (data.status === 422) {
                var errors = data.responseJSON;
                var errosHtml = "";
                $.each(errors, function (key, value) {
                    var id = "#".concat(key);
                    $("#" + key).css("border", '1px solid red');
                    $("#" + key).effect("shake")
                    toastr.options.positionClass = "toast-container toast-bottom-full-width";
                    toastr["error"](value[0]);

                });

            }
        });
    }
</script>