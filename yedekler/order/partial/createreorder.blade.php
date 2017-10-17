<form id="formReOrder" name="formReOrder">
    {{csrf_field()}}
    <input type="hidden" id="orderid" name="orderid" value="{{old("orderid",$model->id)}}">
    <input type="hidden" id="isopposite" name="isopposite" value="0">
    <input type="hidden" id="passengerlist_modal" name="passengerlist_modal" value="[]">
    <input type="hidden" id="extralist_modal" name="extralist_modal" value="[]">
    <input type="hidden" id="duration2" name="duration2" value="{{$duration}}">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for="orderdate" class="control-label">{{__('orders.order_date')}}</label>
                        <div class='input-group date' id='reorderDateTime'>
                            <input type="text" id="orderdate" name="orderdate" class="form-control"  data-format="dd/MM/yyyy hh:mm"  onfocusout="getDrivers();">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="driver" class="control-label">{{__('orders.driver')}}</label>
                        <select id="driver_id" name="driver_id" class="form-control">
                            <option title="Unassigned" value=""></option>
                            @foreach($drivers as $driver)
                                <option title="{{ $driver->id }}" value="{{ $driver->id }}" @if($driver->id == old("driver",$driver_id) ) selected @endif>
                                    {{ $driver->user->name }}   {{ $driver->user->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label for="ordermethod" class="control-label">{{__('orders.order_method')}}</label>
                        <select id="ordermethod" name="ordermethod" class="form-control">
                            @foreach( $ordermethods as $ordermethod)
                                <option value="{{$ordermethod->id}}" title="{{$ordermethod->name}}" @if($ordermethod->id == old("ordermethod",$model->order_method_id)) selected @endif>
                                    {{$ordermethod->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="package" class="control-label">{{__('orders.package')}}</label>
                        <input type="text" id="package" name="package" class="form-control" value="{{old("package",$model->package->name)}}" readonly>
                        <input type="hidden" id="packageid" name="packageid" class="form-control" value="{{$model->package_id}}" >
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="paymenttype" class="control-label">{{__('orders.payment_type')}}</label>
                                <select id="paymenttype" name="paymenttype" class="form-control" >
                                    @foreach( $paymenttypes as $paymenttype)
                                        <option value="{{$paymenttype->id}}" @if(old("paymenttype",$model->payment_type_id) == $paymenttype->id) selected @endif>
                                            {{$paymenttype->payment_title}}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-4">
                                <label for="title">{{__('orders.payment_status')}}</label>
                                <select id="payment_status" name="payment_status" class="form-control" placeholder="{{__('orders.payment_status')}}">
                                    <option value="0" {{ old('payment_status',$model->payment_status)==0?'selected=selected':'' }}>
                                        Not Paid
                                    </option>
                                    <option value="1" {{ old('payment_status',$model->payment_status)==1?'selected=selected':'' }}>
                                        Paid
                                    </option>
                                </select>
                            </div>


                            <div class="col-md-4">
                                <label for="price" class="control-label"> {{__('orders.price')}} </label>
                                <input type="text" id="price" name="price" class="form-control" value="{{old("price",$model->price)}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label for="startadress" class="control-label">{{__('orders.start_address')}} </label>
                        <input type="text" id="startadress" name="startadress" class="form-control" value="{{old("startadress",$model->locations->first()->startlocation->address)}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="endadress" class="control-label">{{__('orders.end_address')}} </label>
                        <input type="text" id="endadress" name="endadress" class="form-control" value="{{old("endadress",$model->locations->first()->endlocation->address)}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="note" class="control-label">{{__('orders.note')}} </label>
                        <textarea id="note" name="note" class="form-control">{{old("note",$model->note)}}</textarea>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for="name" class="control-label"> {{__('orders.client_name')}} </label>
                        <input type="text" id="name" name="name" class="form-control" value="{{old('name',$model->client->user->name.' '.$model->client->user->last_name)}}" readonly>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <label for="phone" class="control-label"> {{__('orders.client_phone')}} </label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{old("phone",$model->client->user->gsm_phone)}}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        @php
                        $clientCompany = ($model->clientcompany)?$model->clientcompany->company_name:'';
                        @endphp
                        <label for="company" class="control-label"> {{__('orders.client_company')}}</label>
                        <input type="text" id="company" name="company" class="form-control" value="{{old("company",$clientCompany)}}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="vehicleclass" class="control-label"> {{__('orders.vehicle_class')}}</label>
                        <select id="vehicleclass" name="vehicleclass" class="form-control">
                            @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle->id}}" @if(old("vehicleclass",$model->jobs[0]->vehicle_class_id) == $vehicle->id) selected @endif>
                                    {{$vehicle->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="number_of_passengers" class="control-label">{{__('orders.passenger_count')}} </label>
                                <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-danger btn-number2" disabled="disabled" data-type="minus" data-field="number_of_passengers">
                                                         <span class="glyphicon glyphicon-minus"></span>
                                                     </button>
                                                 </span>
                                    <input id="number_of_passengers" class="form-control input-number" min="1" max="300" name="number_of_passengers" value="{{ old('number_of_passengers',$model->number_of_passengers) }}">
                                    <span class="input-group-btn">
                                                  <button type="button" class="btn btn-success btn-number2" data-type="plus" data-field="number_of_passengers">
                                                      <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="passengers" class="control-label" style="color:white"> - </label>
                                <button type="button" onclick="getPassengers({{$model->id}})" class="form-control btn btn-outline-blue">{{__('orders.passengers')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="extras_price" class="control-label">{{__('orders.extra_price')}} </label>
                                <input type="text" id="extras_price" name="extras_price" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="extras" class="control-label" style="color:white"> - </label>
                                <button type="button" onclick="getExtras({{$model->id}})" class="form-control btn-outline-blue">{{__('orders.extras')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="kostenstelle" class="control-label"> {{__('orders.cost_center')}}</label>
                        <input type="text" id="kostenstelle" name="kostenstelle" class="form-control" value="{{old("kostenstelle",$model->kostenstelle)}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="drivernote" class="control-label">{{__('orders.note_for_driver')}}</label>
                        <textarea id="drivernote" name="drivernote" class="form-control">{{old("drivernote",$model->drivernote)}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="passenger_content">

        </div>
        <div class="row" id="extra_content">

        </div>
    </div>
    <div class="modal-footer">
        @if(isset($model->package->opposite_id))
        <a href="javascript:oppositeOrder();" class="btn btn-danger">{{__('orders.recorder_with_opposite_direction')}}</a>
        @endif
        <a href="javascript:createOrder()" class="btn btn-info">{{__('orders.create_order')}}</a>
        <a href="javascript:" data-dismiss="modal" class="btn btn-grey">{{__('orders.close')}}</a>
    </div>
</form>


<script type="text/javascript">


    $(document).ready(function () {
        $("#driver_id").select2({});
        getDrivers();
    });

    function getDrivers() {


        var duration = $('#duration2').val() ? $('#duration2').val() : 0;
        var package = $("#packageid").val()? Math.round($('#packageid').val()) : 0;
        var driver_id=$('#driver').val()?$('#driver').val():0;
        var dateTime = ($('#orderdate').val())?$('#orderdate').val():'{{date('Y-m-d H:i')}}';
      //  console.log(duration);


    }

    $('#reorderDateTime').datetimepicker({
        locale: 'de',
        minDate: moment(),
    });

    function oppositeOrder() {
        $("#isopposite").val(1);
        save();
    }
    function createOrder() {
        $("#isopposite").val(0);
        save();
    }


    function getPassengers(orderId) {
        $.get('/common/order/getpassengers/'.concat(orderId)).done(function (data) {
            $("#passenger_content").html(data);
            $("#passenger_content").show();
            $("#extra_content").hide();
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

    function getExtras(orderId) {
        $.get('/common/order/getextras/'.concat(orderId)).done(function (data) {
            $("#extra_content").html(data);
            $("#passenger_content").hide();
            $("#extra_content").show();
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


    function getVehiclesForReorder(passengerCount) {
        $.get('/common/order/getvehicles/'.concat(passengerCount)).done(function (data) {
            $('#vehicleclass').html(data);
            calculatePriceForReOrder();
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

    function calculatePriceForReOrder() {
        $.ajax({
            type: "GET",
            data: {
                'client': $('#client').val()
                , 'vehicle_class': $('#vehicleclass').val()
                , 'package': $("#packageid").val()
            },
            url: '/common/order/getprices',
            success: function (result) {
                $('#price').val(result);

            }
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
    $( "#vehicleclass" ).change(function() {
        calculatePriceForReOrder();
    });



    function save() {
        $.post('/common/order/createreorder/', $('#formReOrder').serialize(), function (data) {
             swal("Reorder Created!", "Order is created !", "success");
                window.location='/manager/order/timetable';
            // window.location='common/order/create';
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



    $('.btn-number2').click(function (e) {
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
        $("#vehicleclass").html("");
        getVehiclesForReorder(currentVal);


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
            $(".btn-number2[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number2[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
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
</script>
