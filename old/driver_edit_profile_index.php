@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opRecover'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')
    <link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
@stop

@section('content-body')
    <section id="basic-form-layouts">


        <div class="row match-height" style="padding-top: 10px">

            <div class="col-md-6">

                <div class="card" style="height: 1070px;">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">User Profile</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            </ul>
                        </div>

                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">


                            <form id="update-personal-contact" action="#"
                                  class="form" method="post">
                                <div class="form-body">
                                    {{csrf_field()}}
                                    <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">First Name</label>
                                                <input type="text" id="name" class="form-control  border-primary"
                                                       value="{{old('name')==null?$driver->user->name:old('name')}}"
                                                       placeholder="First Name"
                                                       name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" id="last_name" class="form-control  border-primary"
                                                       value="{{old('last_name')==null?$driver->user->last_name:old('last_name')}}"
                                                       placeholder="Last Name" name="last_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="text" id="email" class="form-control  border-primary"
                                                       value="{{old('email')==null?$driver->user->email:old('email')}}"
                                                       placeholder="E-mail"
                                                       name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="birthdate">Birthdate</label>
                                                <input type="date" id="birth_date" class="form-control  border-primary"
                                                       value="{{old('birth_date')==null?$driver->user->birth_date:old('birth_date')}}"
                                                       placeholder="Birthdate" name="birth_date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control  border-primary">
                                                    <option></option>
                                                    <option value="male"
                                                            @if(old('gender')=='male' || $driver->user->gender=='male') selected @endif>
                                                        Male
                                                    </option>
                                                    <option value="female"
                                                            @if(old('gender')=='female'|| $driver->user->gender=='female') selected @endif>
                                                        Female
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <h4 class="form-section"><i class="icon-mail6"></i> Contact Info</h4>
                                    <div class="row">


                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}}  </label>
                                                    @include("components.phone_number",["id"=>"gsm_phone" ,"name"=>"gsm_phone","class"=>"form-control input-lg","obj"=>"telInput1",
                                                    "required"=>false,"value"=>$driver->user->gsm_phone])
                                                </div>
                                            </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="postal_code">{{__('drivers_companies.address')}}</label>
                                            @if($driver->address_id>0)
                                                @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                                 "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                                 ,"value"=>['id'=>$driver->address_id,'text'=>$driver->address->address,'hint'=>$driver->address->address_note]
                                                   ])
                                            @else
                                                @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                   "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'])
                                            @endif


                                            <input type="hidden" name="posta_code" id="postal_code" value="{{$driver->postal_code}}">
                                            <input type="hidden" name="place" id="place" value="{{$driver->place}}">
                                            <input type="hidden" name="country_id" id="country_id" value="{{$driver->country_id}}">
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icon-check2"></i> Update Info
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card" style="height: 1070px;">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-colored-form-control">Account Details</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                <!--  <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                  <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                  <li><a data-action="close"><i class="icon-cross2"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">

                            <div class="card-text">


                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{__('drivers_companies.company_info')}}
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group" id="companySelectBox">
                                            <select class="form-control" name="company_id" id="company_id">
                                                <option value="0">{{__('drivers_companies.select_company')}}</option>
                                                @foreach($drivercompanies as $company)
                                                    <option value="{{ $company->id }}"
                                                            @if($company->id==old('company',$driver->driver_company_id)) selected @endif>
                                                        {{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{__('drivers_companies.assign_vehicle')}}
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group" id="companySelectBox">
                                            <select class="form-control" name="vehicles" id="vehicles">
                                                <option value="0">{{__('drivers_companies.select_company')}}</option>
                                                @foreach($vehicles as $vehicle)


                                                    <option value="{{ $vehicle->id }}"
                                                            @if($vehicle->id==old('company')) selected @endif>
    {{$vehicle->plate}} , {{ $vehicle->VehicleModel->vehiclebrand->name }}  {{ $vehicle->VehicleModel->name }}, {{ $vehicle->VehicleModel->vehicleclass->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </section>
@endsection
@section('scriptParts')
    <script type="text/javascript">


        $('#address_id').on('change',function(){
            $.get('/find_country_code/'+$('#address_id').val(),function(data){
               $('#postal_code').val(data['postal_code']);
               $('#country_id').val(data['country_code']);
               $('#place').val(data['city']);
            }).fail(<?php echo config("view.ajax_error"); ?>);
        });


        $('#update-personal-contact').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            save(formData);
        });

        function save(formData) {
            $("#loading").show();
            $.ajax({
                type:'POST',
                url: '/driver/updateprofile',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    swal("{{__('drivers_companies.updated')}}!", "{{__('drivers_companies.updated')}}!", "success");
                    location.reload();
                },
                error: {!! config("view.ajax_error") !!}
            });

        }


        $(function () {


                $(document).ready(function () {

                    $.get('driver/getmodels/' + $('#comnpany_id').val(), function (data) {

                        var html = "<option value=''>{{__('drivers_companies.select_vehicle')}}</option>";

                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].plate +'-'
                                + data[i]['vehiclemodel']['vehiclebrand'].name  + ':'
                                + data[i]['vehiclemodel'].name  +
                                '</option>';

                        }

                        $('#vehicles').html(html);

                    });

                });


            $('#company_id').on('change', function () {

                $.get('driver/getmodels/' + $('#company_id').val(), function (data) {


                        console.log(data);
                    var html = "<option value=''>{{__('drivers_companies.select_vehicle')}}</option>";;

                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].plate +'-'
                                + data[i]['vehiclemodel']['vehiclebrand'].name  + ':'
                                + data[i]['vehiclemodel'].name  +
                                '</option>';
                        }

                        $('#vehicles').html(html);

                    });
                //alert("ok");

            });

            });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            else {
                var $state = $(
                    '<span><img src="{{ asset("assets/images/flags") }}/' + state.title.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            }
        }

        $(".country-codes").select2({
            templateResult: formatState,
            templateSelection: formatState,
        });
    </script>

    <script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>
@endsection