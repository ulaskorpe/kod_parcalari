<div class="col-xs-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="icon-coin-dollar"></i> {{__('expenses.create_expense')}}</h4>
            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        </div>
        <div class="card-body collapse in">
            <div class="card-block">


                <form class="form" id="create-expense" action="{{route('driver.expenses.create')}}"
                      method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.amount')}}</label>
                                    @include("components.money",[
                                   "id"=>"amount",
                                   "name"=>"amount",
                                   "value"=>"0"
                                   ])

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                    <label for="name">{{__('expenses.expense_type')}}</label>
                                    <select name="expense_type" id="expense_type" class="form-control" onchange="typeControl(this.value)" required>
                                        <option value="">{{__('expenses.select_type')}}</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" @if(old('expense_type')==$type->id)selected @endif>     {{$type->type_name}}  </option>
                                        @endforeach
                                    </select>
                            </div>
                                <div class="col-md-6"  id="tank_card_div" style="display: none">
                                    <div class="form-group">
                                        <label for="name">{{__('expenses.tank_card')}}</label>
                                        <select class="form-control" name="tank_card_id" id="tank_card_id"></select>
                                    </div>
                                </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.expense_title')}}</label>
                                    <input class="form-control" required type="text" name="expense_title"
                                           value="{{old('expense_title')}}" id="expense_title"
                                           placeholder="{{__('expenses.expense_title')}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.expense_vehicle')}}</label>

                                    <select name="vehicle_id" id="vehicle_id" class="vehicle_id" required>
                                        <option value=""></option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{$vehicle->id}}"
                                                    @if(old('vehicle_id')==$vehicle->id)selected @endif> {{$vehicle->plate }}
                                                ,

                                                {{ $vehicle->vehiclemodel->vehiclebrand->name }}
                                                {{ $vehicle->vehiclemodel->name }} -
                                                {{ $vehicle->vehiclemodel->vehicleclass->name }}
                                            </option>

                                        @endforeach


                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.expense_description')}}</label>
                                    <input class="form-control" type="text" name="expense_description"
                                           id="expense_description" value="{{old('expense_description')}}"
                                           placeholder="{{__('expenses.expense_description')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.expense_document')}}</label>
                                    <input class="form-control" type="file" name="expense_document"
                                           value="{{old('expense_document')}}"
                                           id="expense_document" placeholder="{{__('expenses.expense_document')}}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{__('expenses.expense_date')}}</label>
                                    <input type="date" class="form-control font-size-small" required name="expense_date"
                                           id="expense_date"
                                           value="{{ old('expense_date') }}"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-actions">
                            <button class="btn btn-danger pull-right" type="submit">
                                <i class="icon-check"></i> {{__('expenses.create_expense')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function typeControl(type){
        if(type==1){

                $('#tank_card_div').show(500);
                $.get('expenses/get_tank_cards/', function (data) {
                  ////////  console.log(data);
                    var html = "<option value=''> {{__('expenses.select_tank_card')}} </option>";

                    for (var i = 0; i < data.length; i++) {

                        html += '<option value="' + data[i].id + '">'+ data[i]['company']['company_name'] +'-'+ data[i].card_no +
                            '</option>';
                    }

                    $('#tank_card_id').html(html);

                });
        }else{
            $('#tank_card_div').hide(500);
            $('#tank_card_id').html();
        }
    }
    $(".expense_user").select2({
        //  templateResult: formatState,
//           /templateSelection: formatState,
    });
    $(".vehicle_id").select2({
        //  templateResult: formatState,
//           /templateSelection: formatState,
    });


    $('#create-expense').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        save(formData);
    });

    function save(formData) {
        $("#loading").show();
        $.ajax({
            type: 'POST',
            url: '/driver/expenses/create',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                swal("{{__('expenses.expense_is_created')}}", "{{__('expenses.expense_is_created')}}", "success");
                location.reload();
            },
            error: {!! config("view.ajax_error") !!}
        });

    }

    /*
        function save() {
            $("#loading").show();
            $.post('/manager/expenses/create', $('#add-vehiclemodel').serialize(), function (data) {
                $("#loading").hide();
                swal("Created!", "New expense type is created !", "success");
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
        }*/
</script>