<input type="hidden" id="last_package_id" name="last_package_id" value="{{$model->package_id}}">


<div class="card">
    <div class="card-header">
        <div class="card-title"><h3>{{__('orders.order_summary')}}</h3></div>
        <hr>
        <div class="card-body">
            <div class="row">
                <div class="card-title">{{__('orders.title_general_info')}}
                    <hr>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.client')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="clientSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.package')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="packageSummary">{{$model->packagename}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.start_location')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="startlocationSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.start_address')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="startaddresSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.postal_code')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="startaddrespostalcodeSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.address_hint')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="startaddresshintSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> {{__('orders.order_method')}} :</div>
                        <div class="col-md-6">
                            <label id="ordermethodSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.payment_type')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="paymenttypeSummary"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.vehicle_class')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="vehicleclassSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">{{__('orders.cost_center')}}:</div>
                        <div class="col-md-6">
                            <label id="costcenterSummary"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.order_date')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="orderdateSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.passenger')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="passengercountSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.end_location')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="endlocationSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.end_address')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="endaddresSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.postal_code')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="endaddrespostalcodeSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.address_hint')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="endaddresshintSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.payment_status')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="paymentstatuSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {{__('orders.driver')}}:
                        </div>
                        <div class="col-md-8">
                            <label id="driverSummary"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">{{__('orders.comment')}} :</div>
                        <div class="col-md-6">
                            <label id="commentSummary"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 20px">
                <div class="card-title">{{__('orders.passengers')}}
                    <hr>
                </div>
                <div class="col-md-12">
                    <table class="table-bordered table-sm" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>{{__('orders.passenger')}}</th>
                            <th>{{__('orders.start_location')}}</th>
                            <th>{{__('orders.end_location')}}</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td id="first_passanger_name"></td>
                            <td id="first_start_location"></td>
                            <td id="first_end_location"></td>
                            <td></td>
                        </tr>
                        @foreach($model->passengers as $passsenger)
                            <tr>
                                <td>{{$passsenger->passenger_name}}</td>
                                <td>{{$passsenger->start_location}}</td>
                                <td>{{$passsenger->end_location}}</td>
                                <td>{{$passsenger->passenger_price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="summaryPrice" style="display: none">
    <div class="media">
        <div class="media-left media-middle bg-info callout-arrow-left position-relative px-2">
            <i class="icon-money white font-medium-5"></i>
        </div>
        <div class="media-body p-1">
            <strong>{{__('orders.total_price')}}</strong>
            <div class="row" style="max-width: 600px">
                <div class="col-md-6">
                    <table class="table" style="max-width: 250px">
                        <tr>
                            <td>{{__('orders.package_price')}}</td>
                            <td>:</td>
                            <td>{{number_format($model->defaultprice >0 ? $model->defaultprice : $model->specialprice,2)}}</td>
                        </tr>
                        <tr>
                            <td>{{__('orders.tax')}}</td>
                            <td>:</td>
                            <td>{{number_format($model->defaultpriceTax >0 ? $model->defaultpriceTax : $model->specialpriceTax,2)}}</td>
                        </tr>
                        <tr class="success">
                            <td><b>{{__('orders.total')}}</b></td>
                            <td>:</td>
                            <td>{{number_format($model->defaultpriceGrossPrice >0 ? $model->defaultpriceGrossPrice : $model->specialpriceGrossPrice,2)}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">

                    <table class="table" style="max-width: 250px">
                        <tr>
                            <th>{{__('orders.extra_name')}}</th>
                            <th>{{__('orders.price')}}</th>
                            <th>{{__('orders.tax')}}</th>
                            <th>{{__('orders.total')}}</th>
                        </tr>
                        <?php $grandTotal = 0; ?>

                        @if(isset($model->extras))
                            @foreach($model->extras as $extra)
                                <tr>
                                    <td>{{$extra->name}}</td>
                                    <td>{{number_format($extra->price,2)}}</td>
                                    <td>{{number_format($extra->TaxValue,2)}}</td>
                                    <td>{{number_format($extra->GrossPrice,2)}}</td>
                                </tr>
                                <?php $grandTotal += number_format($extra->GrossPrice, 2); ?>

                            @endforeach
                        @endif

                        <tr>
                            <td colspan="3"><b>{{__('orders.total')}}</b></td>
                            <td>{{$grandTotal}}</td>
                        </tr>
                        <tr><td><b>Passengers Total({{$model->passangercount}})</b></td><td>{{number_format($model->passengerprice,2)}}</td><td>{{number_format($model->passengerpriceTax,2)}}</td><td>{{number_format($model->passengerGrossPrice,2)}}</td></tr>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <br>
    <div class="alert alert-success round alert-icon-left alert-arrow-left alert-dismissible fade in mb-2" role="alert">
        <strong> {{__('orders.grand_total')}}:</strong> {{number_format($model->defaultpriceGrossPrice >0 ? $grandTotal+$model->defaultpriceGrossPrice+$model->passengerGrossPrice : $grandTotal+$model->specialpriceGrossPrice+$model->passengerGrossPrice ,2)}}
</div>
</div>


<script type="application/javascript">
    $("#clientSummary").text($("#client option:selected").text());
    $("#startlocationSummary").text($("#from_actb").val());
    $("#startaddresSummary").text($("#startaddress").val());
    $("#startaddrespostalcodeSummary").text($("#startpostalcode").val());
    $("#startaddresshintSummary").text($("#startaddressnote").val());
    $("#paymenttypeSummary").text($("#payment_type_id option:selected").text());
    $("#vehicleclassSummary").text($("#vehicle_class option:selected").text());

    $("#orderdateSummary").text($("#start_date").val());
    $("#passengercountSummary").text($("#number_of_passengers").val());
    $("#endlocationSummary").text($("#to_actb").val());
    $("#endaddresSummary").text($("#endaddress").val());
    $("#endaddrespostalcodeSummary").text($("#endpostalcode").val());
    $("#endaddresshintSummary").text($("#endaddressnote").val());
    $("#paymentstatuSummary").text($("#payment_status option:selected").text());
    $("#driverSummary").text($("#driver option:selected").text());


    $("#costcenterSummary").text($('#kostenstelle').val());
    $("#commentSummary").text($('#comment').val());


    $("#ordermethodSummary").text($("#order_method_id option:selected").text());
    $("#calculated_packageid").val({{$model->package_id}});

    $("#first_passanger_name").html($("#client option:selected").text());
    $("#first_start_location").html($("#from_actb").val());
    $("#first_end_location").html($("#to_actb").val());
</script>