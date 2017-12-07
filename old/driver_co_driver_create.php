<link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
<script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>

<div class="col-xs-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="icon-head"></i>{{__('drivers_companies.create_driver')}}</h4>
            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        </div>


        <div class="card-body collapse in">
            <div class="card-block">

                <form class="form" id="add-driver" action="{{ route('driver_company.driver.create') }}"
                      method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <h5 class="form-section"><i class="icon-office"></i>{{__('drivers_companies.company_info')}}</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                {{__('drivers_companies.company_info')}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="companySelectBox">
                                <input type="hidden" name="company_id" id="company_id" value="{{$driver_company->id}}" readonly>
                                <h4>{{$driver_company->name}}</h4>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                {{__('drivers_companies.assign_vehicle')}}:
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="companySelectBox">
                                <select class="js-example-basic-single" name="vehicle_id" id="vehicle_id">

                                    <option value="0"></option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                                @if($vehicle->id==old('vehicle_id')) selected @endif>
                                            [{{ $vehicle->plate }}]
                                            {{ $vehicle->vehiclemodel->vehiclebrand->name }}
                                            ->{{ $vehicle->vehiclemodel->name }}
                                            ( {{ $vehicle->vehiclemodel->vehicleclass->name }} )
                                            @if($vehicle->company_id)
                                                {{ $vehicle->company?$vehicle->company->name:"" }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <h4 class="form-section"><i class="icon-person-add"></i>{{__('drivers_companies.driver_profil_info')}}
                    </h4>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first_name">{{__('drivers_companies.first_name')}}</label>
                                <input type="text" id="first_name" class="form-control"
                                       placeholder="{{__('drivers_companies.first_name')}}" required
                                       name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="last_name">{{__('drivers_companies.last_name')}}</label>
                                <input type="text" id="last_name" class="form-control"
                                       placeholder="{{__('drivers_companies.last_name')}}" name="last_name" required
                                       value="{{ old('last_name') }}"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">{{__('drivers_companies.gender')}}</label>
                                <select name="gender" id="gender"  class="form-control">
                                    <option></option>
                                    <option value="{{strtolower(__('drivers_companies.male'))}}"
                                            @if(old('gender')==strtolower(__('drivers_companies.male'))) selected @endif>{{__('drivers_companies.male')}}
                                    </option>
                                    <option value="{{strtolower(__('drivers_companies.female'))}}" @if(old('gender')==strtolower(__('drivers_companies.female'))) selected @endif>
                                        {{__('drivers_companies.female')}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="birthofdate">{{__('drivers_companies.birth_of_date')}}</label>

                                @include("components.date",["id"=>"birthday","name"=>"birthday","value"=>""])
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="password">{{__('drivers_companies.is_vip')}}</label>
                            <div class="form-group">
                                @include("components.toggle",["id"=>"is_vip_name","name"=>"is_vip_name","dataon"=>__('common.yes_'),"dataoff"=>__('common.no_'),"value"=>old('is_vip_name',0)])
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="password">{{__('drivers_companies.password')}}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="password" class="form-control" id="password" required/>
                                    <span class="input-group-btn">
                                        <a href="javascript:addPassword();" class="btn btn-warning" type="button"
                                           style="padding-left: 2px;padding-right: 2px;">{{__('drivers_companies.generate')}}</a>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <label for="address">{{__('drivers_companies.address')}}</label>
                            <div class="form-group">
                                @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                  "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                    ])


                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="postal_code">{{__('drivers_companies.postal_code')}}</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control"
                                   placeholder="{{__('drivers_companies.postal_code')}}" >
                        </div>
                        <div class="col-md-2">
                            <label for="postal_code">{{__('drivers_companies.city')}}</label>
                            <input type="text" name="place" id="place" class="form-control"
                                   placeholder="{{__('drivers_companies.city')}}" >
                        </div>

                        <div class="col-md-3">
                            <label>{{__('drivers_companies.country')}}</label>
                            <div class="form-group">
                                <select name="country_id" id="country_id" class="country-codes" required onchange="changeNationality();">
                                    <option value="">Select Country</option>
                                    @foreach($country as $c)
                                        <option title="{{ $c->code }}" value="{{ $c->code }}" @if($c->code==old('company_country_id')) selected @endif>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-2">
                            <label>{{__('drivers_companies.code')}}</label>
                            <div class="form-group">
                                <select name="phone_number_country_code" id="phone_number_country_code"
                                        class="country-codes" style="height: 38px;" required>
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('phone_number_country_code')) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{__('drivers_companies.telephone')}}</label>
                                <div class="form-group has-feedback has-icon-left">
                                    <input name="gsm_phone" type="text" class="form-control" id="gsm_phone" placeholder=""
                                           tabindex="" value="{{ old('gsm_phone') }}" required>
                                    <div class="form-control-position">
                                        <i class="icon-classictelephone"></i>
                                    </div>
                                    <div class="help-block font-small-3"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">{{__('drivers_companies.email')}}</label>
                                    <input type="email" id="email" class="form-control" placeholder="{{__('drivers_companies.email')}}"
                                           name="email" value="{{ old('email') }}" required/>

                                </div>
                            </div>


                        </div>


                    </div>


                    <div class="form-actions">
                        <input type="submit" id="saveBtn" class="btn btn-danger pull-right" value="{{__('drivers_companies.create_driver')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function changeNationality() {


        $.get('{{asset('/driver_company/driver/find_country_code')}}/' + $('#country_id').val(), function (data) {////return view
            $('#phone_number_country_code').val(data).trigger('change');


        });

        //    document.getElementById('nationality').value=$('#residential_id').val();
    }



    $("#vehicle_id").select2();
    $(function () {
        $('#corporate').change(function () {
            if ($(this).prop('checked')) {
                $('#companySelectBox').hide();
                $('#corporate_block').show();
                $("#company_name").prop('required', true);
                $("#company_country").prop('required', true);
                $("#company_firm_number").prop('required', true);
                $("#company_tax_number").prop('required', true);
                $("#company_address").prop('required', true);
                $("#is_company").val(1);
            }
            else {
                $('#companySelectBox').show();
                $('#corporate_block').hide();
                $("#company_name").prop('required', false);
                $("#company_country").prop('required', false);
                $("#company_firm_number").prop('required', false);
                $("#company_tax_number").prop('required', false);
                $("#company_address").prop('required', false);
                $("#is_company").val(0);
            }
        });
    });

    $('#add-driver').submit(function (e) {
        e.preventDefault();
        save();
    });

    function save() {
        $("#loading").show();
        $.post('/driver_company/driver/create', $('#add-driver').serialize(), function (data) {
            $("#loading").hide();
            swal("{{__('drivers_companies.driver_is_created')}}", "{{__('drivers_companies.driver_is_created')}}", "success");
            location.reload();
        }).fail({!! config("view.ajax_error") !!});
    }


    $('#is_vip').change(function () {
        if ($(this).prop('checked')) {
            $("#is_vip_name").val(1);
        }
        else {
            $("#is_vip_name").val(0);
        }
    });

    function generatePassword() {
        var length = 6,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal
    }

    function addPassword() {
        var val = generatePassword();
        $("#password").val(val);
    }


    function formatState(state) {
        ///    console.log(state);
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
@yield('scripts')