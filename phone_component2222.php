@php
    $obj = (!empty($obj))?$obj : "telInput";
    $errorDiv="error-msg-".$id;
    $validDiv="valid-msg-".$id;
@endphp


<div>

    <table><tr><td>
    <input type="tel" class="{{isset($class)?$class:"form-control"}}" id="phone-{{$id}}" name="phone-{{$name}}" value="{{old("phone-".$name,isset($value)?str_replace("-","",'+'.$value):"") }}"
    @if(!empty($required) && ($required)) required @endif>
    <input type="hidden" id="{{$id}}" name="{{$name}}" value="">
    <input type="hidden" id="old-{{$id}}" name="old-{{$name}}" value="{{old("old-".$name,isset($value)?$value:"") }}">
            </td></tr>
            <tr><td>
            <span id="{{$validDiv}}" class="success" style="display: none">✓ Valid Number</span>
            <span id="{{$errorDiv}}" class="danger" style="display: none">X Invalid Number</span>
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
        if($('#old-{{$id}}').val()!=''){
            $('#phone-{{$id}}').prop('required',false);
        }

        // For documentations https://intl-tel-input.com/
        var phone_{{$id}} = $("#phone-{{$id}}"), errorMsg = $("#{{$errorDiv}}"), validMsg = $("#{{$validDiv}}"), countryCode = 0;
var i_{{$id}} = 0;
        phone_{{$id}}.intlTelInput({
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
        phone_{{$id}}.blur(function () {
          if(i_{{$id}}>0){
            reset_{{$id}}();
            if ($.trim(phone_{{$id}}.val())) {
                if (phone_{{$id}}.intlTelInput("isValidNumber")) {
                    validMsg.show();
                    var countryData =  phone_{{$id}}.intlTelInput("getSelectedCountryData");
                    countryCode = countryData.dialCode;
                    var number = phone_{{$id}}.intlTelInput("getNumber").replace("+" + countryCode, "");
                    $("#{{$id}}").val(countryCode + "-" + number).trigger("change");
                } else {
                    phone_{{$id}}.addClass("danger");
                    errorMsg.show();
                }
            }
          }
            i_{{$id}}++;
        });
        phone_{{$id}}.on("keyup change",  reset_{{$id}}  );
        //countrycode change
        phone_{{$id}}.on("countrychange", function (e, countryData) {
            countryCode = countryData.dialCode;
        });

        phone_{{$id}}.on("click", function (e, countryData) {
            @if(isset($onclick))
            {!! $onclick !!}
            @endif

        });


        var reset_{{$id}} = function () {
            $('#{{$id}}').val('').trigger("change");
            phone_{{$id}}.removeClass("danger");
            errorMsg.hide();
            validMsg.hide();
        };
    </script>
@append