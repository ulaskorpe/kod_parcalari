<link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
<script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>
<div class="col-xs-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title"><i class="icon-head"></i>{{__('drivers_companies.update_driver')}}</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                </div>
                <div class="col-md-2">
                    @if(!empty($driver->updated_by))
                        ( {{__('drivers_companies.last_updated_by',['name'=>$driver->lastUpdated->fullname()])}} )
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body collapse in">
            <div class="card-block">
                <form class="form" id="add-driver" action="{{ route('manager.driver.create') }}"
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
                                <input type="hidden" value="{{$driver_company->id}}" readonly name="company_id" id="company_id">
                                <h4>{{$driver_company->name}}</h4>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {{__('drivers_companies.assign_vehicle')}} :

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="companySelectBox">
                                <select class="js-example-basic-single" name="vehicle_id" id="vehicle_id">

                                    <option value="0"></option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                                @if($vehicle->id== $driver->vehicle_id) selected @endif>
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


                    <h4 class="form-section"><i
                                class="icon-person-add"></i>{{__('drivers_companies.driver_profil_info')}}
                    </h4>
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first_name">{{__('drivers_companies.first_name')}}</label>
                                <input type="text" id="first_name" class="form-control"
                                       placeholder="{{__('drivers_companies.first_name')}}" required
                                       name="first_name" value="{{ old('first_name',$driver->user->name) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="last_name">{{__('drivers_companies.last_name')}}</label>
                                <input type="text" id="last_name" class="form-control"
                                       placeholder="{{__('drivers_companies.last_name')}}" name="last_name" required
                                       value="{{ old('last_name',$driver->user->last_name) }}"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">{{__('drivers_companies.gender')}}</label>
                                <select name="gender" id="gender"  class="form-control">
                                    <option></option>
                                    <option value="{{strtolower(__('drivers_companies.male'))}}"
                                            @if(old('gender',$driver->user->gender)==strtolower(__('drivers_companies.male'))) selected @endif>{{__('drivers_companies.male')}}
                                    </option>
                                    <option value="{{strtolower(__('drivers_companies.female'))}}"
                                            @if(old('gender',$driver->user->gender)==strtolower(__('drivers_companies.female'))) selected @endif>
                                        {{__('drivers_companies.female')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="birthofdate">{{__('drivers_companies.birth_of_date')}}</label>
                                @include("components.date",["id"=>"birthday","name"=>"birthday","value"=>$driver->user->birth_date])
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="password">{{__('drivers_companies.is_vip')}}</label>
                            <div class="form-group">
                                @include("components.toggle",["id"=>"is_vip_name","name"=>"is_vip_name","dataon"=>__('common.yes'),"dataoff"=>__('common.no'),"value"=>old('is_vip_name',$driver->is_vip)])


                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="password">{{__('drivers_companies.password')}}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="password" class="form-control" id="password"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:addPassword();" class="btn btn-warning" type="button"
                                           style="padding-left: 2px;padding-right: 2px;">{{__('drivers_companies.generate')}}</a>
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="residential_id">{{__('clients.banned_until')}}   </label>
                            <input type="date" class="form-control font-size-small" name="banned_until"
                                   id="banned_until" value="{{ old('banned_until',$driver->user->banned_until) }}"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-5">
                            <label for="address">{{__('drivers_companies.address')}}</label>
                            <div class="form-group">
                                @if($driver->address_id>0)
                                    @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                     "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                     ,"value"=>['id'=>$driver->address_id,'text'=>$driver->address->address,'hint'=>$driver->address->address_note]
                                       ])
                                @else
                                    @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                       "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'])
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="postal_code">{{__('drivers_companies.postal_code')}}</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control"
                                   placeholder="{{__('drivers_companies.postal_code')}}"
                                   value="{{old('postal_code',$driver->postal_code)}}" >
                        </div>
                        <div class="col-md-2">
                            <label for="postal_code">{{__('drivers_companies.city')}}</label>
                            <input type="text" name="place" id="place" value="{{old('place',$driver->place)}}"
                                   class="form-control"
                                   placeholder="{{__('drivers_companies.city')}}" >
                        </div>

                        <div class="col-md-3">
                            <label>{{__('drivers_companies.country')}}</label>
                            <div class="form-group">
                                <select name="country_id" id="country_id" class="country-codes" required onchange="changeNationality();">
                                    <option value="">Select Country</option>
                                    @foreach($country as $c)
                                        <option title="{{ $c->code }}" value="{{ $c->code }}"
                                                @if($c->code==old('company_country_id',$driver->country_id)) selected @endif>
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
                                        class="country-codes" style="height: 38px;">
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('phone_number_country_code',substr($driver->user->gsm_phone,0,strpos($driver->user->gsm_phone,'-')))))
                                                selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>{{__('drivers_companies.telephone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="gsm_phone" type="text" class="form-control" id="gsm_phone" placeholder=""
                                       tabindex=""
                                       value="{{ old('gsm_phone',substr($driver->user->gsm_phone,strpos($driver->user->gsm_phone,'-')+1,strlen($driver->user->gsm_phone))) }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="email">{{__('drivers_companies.email')}}</label>
                                <input type="text" id="email" class="form-control"
                                       placeholder="{{__('drivers_companies.email')}}"
                                       name="email" value="{{ old('email',$driver->user->email) }}" required/>

                            </div>
                        </div>

                    </div>


                    <div class="form-actions">
                        <input type="submit" id="saveBtn" class="btn btn-danger pull-right" value="{{__('drivers_companies.update_driver')}}">
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
    }

    $("#vehicle_id").select2();

    $('#add-driver').submit(function (e) {
        e.preventDefault();
        save({{$driver->id}});
    });


    @if($driver->is_vip==1)
    $("#is_vip_name").val(1);
    $('#is_vip').bootstrapToggle('on');
    @else
    $("#is_vip_name").val(0);
    $('#is_vip').bootstrapToggle('off');
    @endif




    $('#is_vip').change(function () {
        if ($(this).prop('checked')) {
            $("#is_vip_name").val(1);
        }
        else {
            $("#is_vip_name").val(0);
        }
    });

    function save(driverId) {
        $("#loading").show();
        $.post('/driver_company/driver/edit/'.concat(driverId), $('#add-driver').serialize(), function (data) {
            $("#loading").hide();
            swal("{{__('drivers_companies.updated')}}", "{{__('drivers_companies.driver_is_updated')}}", "success");
            location.reload();
        }).fail({!! config("view.ajax_error") !!});
    }


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
        console.log(state);
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