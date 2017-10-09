<br/>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__('orders.passengers')}}</h4>
    </div>
    <div class="card-body">
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <label for="gsm_phone_modal">{{__('orders.passenger')}}{{__('orders.phone')}}</label>
                    @include("components.telephone",["id"=>"gsm_phone_modal","name"=>"gsm_phone_modal"])
                    <label for="passenger_name_modal">{{__('orders.passenger_name')}}</label>
                    <input class="form-control" name="passenger_name_modal" id="passenger_name_modal" placeholder="{{__('orders.name')}}">
                    <label for="flight_number">{{__('orders.flight_number')}}</label>
                    <input class="form-control" name="flight_number_modal" id="flight_number_modal" placeholder="{{__('orders.flight_number')}}">

                </div>
                <div class="col-md-6">

                    <label for="flight_from">{{__('orders.flight_from')}}</label>
                    <input class="form-control" name="flight_from_modal" id="flight_from_modal" placeholder="{{__('orders.flight_from')}}">
                    <label for="flight_company">{{__('orders.flight_company')}}</label>
                    <input class="form-control" name="flight_company_modal" id="flight_company_modal" placeholder="{{__('orders.flight_company')}}">
                    <label style="color:#FFFFFF">-</label>
                    <button type="button" class="form-control btn btn-warning" onclick="addPassengerModal();"> {{__('orders.add_passenger')}}</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 top-buffer">
                    <table class="table-bordered table-sm" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>{{__('orders.passenger')}}</th>
                            <th>{{__('orders.start_address')}}</th>
                            <th>{{__('orders.end_address')}}</th>
                            <th>{{__('orders.flight_number')}}</th>
                            <th>{{__('orders.flight_from')}}</th>
                            <th>{{__('orders.flight_from')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($OrderLocations as $orderLocation)
                            @if($orderLocation->client_id>0)
                            <tr>
                                <td>{{$orderLocation->client->user->name}} {{$orderLocation->client->user->last_name}}</td>
                                <td>{{$orderLocation->startlocation->address}}</td>
                                <td>{{$orderLocation->endlocation->address}}</td>
                                <td>{{$orderLocation->order->flight_number}}</td>
                                <td>{{$orderLocation->order->flight_from}}</td>
                                <td>{{$orderLocation->order->flight_company}}</td>
                                <td><button type="button" onclick="removePassengerModal2({{$orderLocation->id}})" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td>
                            </tr>
                            @endif
                            @if($orderLocation->passenger_id>0)
                                <td>{{$orderLocation->passenger->passenger_name}}</td>
                                <td>{{$orderLocation->startlocation->address}}</td>
                                <td>{{$orderLocation->endlocation->address}}</td>
                                <td>{{$orderLocation->order->flight_number}}</td>
                                <td>{{$orderLocation->order->flight_from}}</td>
                                <td>{{$orderLocation->order->flight_company}}</td>
                                <td><button type="button" onclick="removePassengerModal2({{$orderLocation->id}})" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot id="passenger_list_body_modal">

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var passengerList_modal = []


    function addPassengerModal() {
        if ($("#passenger_name_modal").val() != "") {
            passengerList_modal.push(
                {
                    gsm_phone: $("#gsm_phone_modal").val(),
                    passenger_name: $("#passenger_name_modal").val(),
                    flight_number: $("#flight_number_modal").val(),
                    flight_from: $("#flight_from_modal").val(),
                    flight_company: $("#flight_company_modal").val(),
                }
            );
            fillPassengerListModal();
            $("#gsm_phone_modal").val("");
            $("#passenger_name_modal").val("");
            $("#flight_number_modal").val("");
            $("#flight_from_modal").val("");
            $("#flight_company_modal").val("");
        }
        else {
            toastr.options.positionClass = "toast-container toast-bottom-full-width";
            toastr["error"]("Please enter a passenger name");
            return false;
        }

    }

    function removePassengerModal(key) {
        passengerList_modal.splice(key, 1);
        fillPassengerListModal();
    }
    function removePassengerModal2(locationid) {
        swal({
                title: "Are you sure?",
                text: "This passenger will be deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "{{__('drivers_companies.yes_delete')}}",
                cancelButtonText: "{{__('drivers_companies.no_cancel')}}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.get('/manager/order/deletepassenger/'.concat(locationid), function (mdata) {
                        swal("Deleted!", "Passenger deleted", "success");
                        location.reload();
                    }).fail(function () {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"]("{{__('drivers_companies.error_occured')}}");
                    });
                } else {
                    swal("Cancelled", "{{__('drivers_companies.no_change')}}", "error");
                }
            });
    }


    function fillPassengerListModal() {
        var content = "";
        var submitvalues = [];
        for (var key in passengerList_modal) {
            if (typeof passengerList_modal[key] !== 'undefined' && passengerList_modal[key] != null) {
                content += '<tr><td>'  + passengerList_modal[key].passenger_name + '</td>';
                content +='<td></td><td></td>'
                content += '<td>' + passengerList_modal[key].flight_number + '</td>';
                content += '<td>' + passengerList_modal[key].flight_from + '</td>';
                content += '<td>' + passengerList_modal[key].flight_company + '</td>';
                content += '<td><button onclick="removePassengerModal(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
            }
        }
        $('#passengerlist_modal').val(JSON.stringify(passengerList_modal));
        $('#passenger_list_body_modal').html(content);


    }


</script>
@yield("scripts")