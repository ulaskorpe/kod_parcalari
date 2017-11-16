@php
    $obj = (!empty($obj))?$obj : "telInput";
    $errorDiv="";
@endphp

<div>

    <table><tr><td>
    <input type="tel" class="{{isset($class)?$class:"form-control"}}" id="phone-{{$id}}" name="phone-{{$name}}" value="{{old("phone-".$name,isset($value)?str_replace("-","",'+'.$value):"") }}"
    @if(!empty($required) && ($required)) required @endif>
    <input type="text" id="{{$id}}" name="{{$name}}" value="{{old($name,isset($value)?str_replace("-","",'+'.$value):"") }}">
    <input type="hidden" id="old-{{$id}}" name="old-{{$name}}" value="{{old("old-".$name,isset($value)?str_replace("-","",'+'.$value):"") }}">
            </td></tr>
            <tr><td>
            <span id="valid-msg" class="success" style="display: none">✓ Valid Number</span>
            <span id="error-msg" class="danger" style="display: none">X Invalid Number</span>
        </td></tr>
    </table>
</div>
<style>
    .country-list .country {
        z-index: 9999;
    }
</style>

@section("scripts")
    <script type="text/javascript">


        // For documentations https://intl-tel-input.com/
        var {{$obj}} = $("#phone-{{$id}}"), errorMsg = $("#error-msg"), validMsg = $("#valid-msg"), countryCode = 0;

        {{$obj}}.intlTelInput({
            nationalMode: true,
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            }
        });
        // on blur: validate
        {{$obj}}.blur(function () {
            reset();
            if ($.trim({{$obj}}.val())) {
                if ({{$obj}}.intlTelInput("isValidNumber")) {
                    validMsg.show();
                    var number = {{$obj}}.intlTelInput("getNumber").replace("+" + countryCode, "");
                    $("#{{$id}}").val(countryCode + "-" + number).trigger("change");
                } else {
                    {{$obj}}.addClass("danger");
                    $('#{{$id}}').val('');
                    $('#phone-{{$id}}').val('');
                    errorMsg.show();
                }
            }

        });
        {{$obj}}.on("keyup change", reset);
        //countrycode change
        {{$obj}}.on("countrychange", function (e, countryData) {
            countryCode = countryData.dialCode;

        });

        {{$obj}}.on("click", function (e, countryData) {
            @if(isset($onclick))
            {!! $onclick !!}
            @endif

        });


        var reset = function () {
            $("#{{$id}}").val("").trigger("change");
            {{$obj}}.removeClass("danger");
            errorMsg.hide();
            validMsg.hide();
        };
    </script>
@append




             <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="phone_number_country_code" id="phone_number_country_code"
                                        class="country-codes" id="country-codes" required >
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
                            <label>{{__('clients.telephone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="phone_number" type="text" class="form-control" required id="phone_number"
                                       placeholder="{{__('clients.telephone')}}" tabindex=""
                                       value="{{ old('phone_number') }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>


        <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="backup_first_phone_code" id="backup_first_phone_code"
                                        class="country-codes"
                                        id="country-codes" >
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('backup_first_phone_code')) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('clients.backup_first_phone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="backup_first_phone" type="text" class="form-control"
                                       id="backup_first_phone"
                                       placeholder="" tabindex="" value="{{ old('phone_number') }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>                        




                                   <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="spare_second_phone_code" id="spare_second_phone_code"
                                        class="country-codes"
                                        id="country-codes">
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('backup_first_phone_code')) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('clients.spare_second_phone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="spare_second_phone" type="text" class="form-control"
                                       id="spare_second_phone"
                                       placeholder="" tabindex="" value="{{ old('spare_second_phone') }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>



                        <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="backup_first_phone_code" class="country-codes"
                                        id="backup_first_phone_code" required>
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('backup_first_phone_code',substr($client->backup_first_phone,0,strpos($client->backup_first_phone,'-')))) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('clients.backup_first_phone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="backup_first_phone" class="form-control" id="backup_first_phone"
                                       placeholder="" tabindex=""
                                       value="{{ old('backup_first_phone',substr($client->backup_first_phone,strpos($client->backup_first_phone,'-')+1,strlen($client->backup_first_phone))) }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="spare_second_phone_code" class="country-codes"
                                        id="spare_second_phone_code" required>
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('spare_second_phone_code',substr($client->spare_second_phone,0,strpos($client->spare_second_phone,'-')))) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('clients.spare_second_phone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="spare_second_phone" class="form-control" id="spare_second_phone"
                                       placeholder="" tabindex=""
                                       value="{{ old('spare_second_phone',substr($client->spare_second_phone,strpos($client->spare_second_phone,'-')+1,strlen($client->spare_second_phone))) }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>                        