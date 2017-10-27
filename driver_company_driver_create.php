<link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
<script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>
<div class="col-xs-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="icon-head"></i> Create Driver</h4>
            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        </div>
        <div class="card-body collapse in">
            <div class="card-block">

                <form class="form" id="add-driver" action="{{ route('driver_company.driver.create') }}"
                      method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <h5 class="form-section"><i class="icon-office"></i>Company Info</h5>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                @if(0)
                                Is Company :
                                <input type="checkbox" data-toggle="toggle" id="corporate" name="corporate" data-on="Yes" data-off="No"/>
                                <input type="hidden" name="is_company" id="is_company" value="0">
                                    @endif
                                Company Name :
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group" id="companySelectBox">
                                <select class="form-control" name="company_id" id="company_id">

                                    @foreach($model as $company)
                                        <option value="{{ $company->id }}"
                                                @if($company->id==old('company')) selected @endif>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="display: none" id="corporate_block">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" id="company_name" class="form-control" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_country">Country</label>
                                    <select name="company_country" id="company_country" class="form-control">

                                        @foreach($companycountries as $c)
                                            <option title="{{ $c->name }}" value="{{ $c->id }}" @if($c->id==old('company_country')) selected @endif>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_firm_number">Firm Number</label>
                                    <input type="text" id="company_firm_number" class="form-control"
                                           placeholder="Firm Number" name="company_firm_number"
                                           value="{{ old('company_firm_number') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_tax_number">Tax Number</label>
                                    <input type="text" id="company_tax_number" class="form-control"
                                           placeholder="Tax Number" name="company_tax_number"
                                           value="{{ old('company_tax_number') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="eu_tax_number">Tax Number</label>
                                    <input type="text" id="eu_tax_number" class="form-control"
                                           placeholder="EU Tax Number" name="eu_tax_number"
                                           value="{{ old('eu_tax_number') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="int_tax_number">Tax Number</label>
                                    <input type="text" id="int_tax_number" class="form-control"
                                           placeholder="INT Tax Number" name="int_tax_number"
                                           value="{{ old('eu_tax_number') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_email">Email</label>
                                    <input type="text" id="company_email" class="form-control"
                                           placeholder="Email" name="company_email"
                                           value="{{ old('company_email') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number1">Phone Number</label>
                                    <input type="text" id="company_phone_number1" class="form-control"
                                           name="company_phone_number1" placeholder="Phone Number"
                                           value="{{ old('company_phone_number1') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number2">Phone Number</label>
                                    <input type="text" id="company_phone_number2" class="form-control"
                                           name="company_phone_number2" placeholder="Phone Number"
                                           value="{{ old('company_phone_number2') }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">Phone Number</label>
                                    <input type="text" id="company_phone_number3" class="form-control"
                                           name="company_phone_number3" placeholder="Phone Number"
                                           value="{{ old('company_phone_number3') }}"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="company_address">Address</label>
                                    <textarea id="company_address" class="form-control" name="company_address" placeholder="Address"> {{ old('company_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="form-section"><i class="icon-person-add"></i>Driver Profile Info
                    </h4>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" class="form-control"
                                       placeholder="First Name" required
                                       name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" class="form-control"
                                       placeholder="Last Name" name="last_name" required
                                       value="{{ old('last_name') }}"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" required class="form-control">
                                    <option></option>
                                    <option value="male" @if(old('gender')=='male') selected @endif>Male
                                    </option>
                                    <option value="female" @if(old('gender')=='female') selected @endif>
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="birthofdate">Birth Of Date</label>
                                <input type="date" class="form-control font-size-small" name="birthday"
                                       value="{{ old('birthday') }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="address">Address</label>
                            <div class="form-group">
                                <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" required>
                        </div>
                        <div class="col-md-1">
                            <label>Code</label>
                            <div class="form-group">
                                <select name="phone_number_country_code"  id="country-codes" style="height: 38px;">
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
                        <div class="col-md-3">
                            <label>Telephone</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="phone_number" type="text" class="form-control"id="phone_number" placeholder="" tabindex="" value="{{ old('phone_number') }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control" placeholder="Email"
                                       name="email" value="{{ old('email') }}" required/>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="password">Password</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="password" class="form-control" id="password" required/>
                                    <span class="input-group-btn">
                                        <a href="javascript:addPassword();" class="btn btn-warning" type="button" style="padding-left: 2px;padding-right: 2px;">Generate</a>
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                Assign Vehicle :

                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group" id="companySelectBox">
                                <select class="js-example-basic-single"  name="vehicle_id" id="vehicle_id">

                                <option value="0"></option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                                @if($vehicle->id==old('vehicle_id')) selected @endif>
                                            [{{ $vehicle->plate }}]
                                            {{ $vehicle->vehiclemodel->vehiclebrand->name }}->{{ $vehicle->vehiclemodel->name }}
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
                    <div class="form-actions">
                        <input type="submit" id="saveBtn" class="btn btn-danger pull-right" value="Create Driver" >
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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

    $('#add-driver').submit(function(e){
        e.preventDefault();
        save();
    });

    function save() {
        $("#loading").show();
        $.post('/driver_company/driver/create',$('#add-driver').serialize(), function (data) {
            console.log(data);
            $("#loading").hide();
                swal("Created!", "Driver is created !", "success");
                location.reload();
        }).fail(function(data) {
            if(data.status === 422){
                var errors = data.responseJSON;
                var errosHtml="";
                $.each( errors, function( key, value ) {
                    var id="#".concat(key);
                    $("#"+key).css("border",'1px solid red');
                    $("#"+key).effect( "shake" )
                    toastr.options.positionClass = "toast-container toast-bottom-full-width";
                    toastr["error"](value[0]);

                });

            }
        });
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
        var val =generatePassword();
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
