<br/>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__('orders.extras')}}</h4>
    </div>
    <div class="card-body">
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <label for="extra_type_modal">{{__('orders.extra')}}</label>
                    <select id="extra_type_modal" class="form-control" name="extra_type_modal">
                        <option value="0"></option>
                        @foreach($Extras as $extra)
                            <option value="{{$extra->id}}" data-value="{{$extra->price}}">{{$extra->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="extra_price_modal">{{__('orders.price')}}</label>
                    <input type="text" class="form-control" name="extra_price_modal" id="extra_price_modal" value="0" min="0" step="Any">
                </div>
                <div class="col-md-3">
                    <label for="extra_price_modal">{{__('orders.add_extra')}}</label>
                    <button type="button" class="form-control btn btn-orange" onclick="addExtraModal();"><i class="glyphicon glyphicon-plus"></i></button>
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
                        <tbody>
                        @foreach($extras as $extra)
                            <tr>
                                <td>{{$extra->extra->name}}</td>
                                <td>{{$extra->extra->price}}</td>
                                <td><button type="button" onclick="removeExtraModal2({{$extra->id}})" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button> </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot id="extra_list_body_modal">

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    var extraList_modal = [];


    function addExtraModal() {
        if (document.getElementById('extra_type_modal').selectedOptions[0].innerHTML != "") {
            var value = document.getElementById('extra_type_modal').selectedOptions[0].innerHTML;
            extraList_modal.push({
                extraid: $('#extra_type_modal').val(),
                extraname: value,
                extraprice: $('#extra_price_modal').val()
            });
            fillExtraListModal();
            getPriceSummary();
        }
        else {
            toastr.options.positionClass = "toast-container toast-bottom-full-width";
            toastr["error"]("Please select an extra type");
            return false;
        }

    }

    function removeExtraModal(key) {
        extraList_modal.splice(key, 1);
        fillExtraListModal();
    }
    function removeExtraModal2(orderextraid) {
        swal({
                title: "{{__('orders.are_you_sure')}}",
                text: "{{__('orders.extra_will_be_deleted')}}",
                type: "{{__('orders.warning')}}",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "{{__('drivers_companies.yes_delete')}}",
                cancelButtonText: "{{__('drivers_companies.no_cancel')}}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.get('/manager/order/deleteorderextra/'.concat(orderextraid), function (mdata) {
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

    function fillExtraListModal() {
        var content = "";
        for (var key in extraList_modal) {
            if (typeof extraList_modal[key] !== 'undefined' && extraList_modal[key] != null) {
                content += '<tr><td>' + extraList_modal[key].extraname + '</td>';
                content += '<td>' + extraList_modal[key].extraprice + '</td>';
                content += '<td><button type="button" onclick="removeExtraModal(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
            }
        }
        $('#extralist_modal').val(JSON.stringify(extraList_modal));
        $('#extra_list_body_modal').html(content);

    }

    document.getElementById('extra_type_modal').onchange = function () {
        var value = this.selectedOptions[0].getAttribute('data-value');
        $('#extra_price_modal').val(value);
    };

    fillExtraListModal();

</script>