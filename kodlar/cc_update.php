<link href="{{asset('/robust-assets/css/plugins/extensions/toggle.css')}}" rel="stylesheet">
<script src="{{asset('/robust-assets/js/plugins/extensions/toggle.js')}}"></script>
<div class="col-xs-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title"><i class="icon-office"></i>{{__('clients.update_client_company')}}</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                </div>
                <div class="col-md-2">
                    @if(!empty($client_company->updated_by))
                        ( Last Updated By: {{$client_company->lastUpdated->fullname()}} )
                    @endif
                </div>
            </div>

        </div>


        <div class="card-body collapse in">
            <div class="card-block">
                <form class="form" id="add-company" action=""
                      method="post" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-body">
                        <h4 class="form-section"><i class="icon-office"></i>{{__('clients.company_info')}}</h4>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.company_name')}}</label>
                                    <input type="text" id="company_name" class="form-control"
                                           placeholder="{{__('clients.company_name')}}" name="company_name"
                                           value="{{old('company_name',$client_company->company_name)}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.title')}}</label>
                                    <input type="text" id="title" class="form-control"
                                           placeholder="{{__('clients.title')}}" name="title"
                                           value="{{old('title',$client_company->title)}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.related_person')}}</label>
                                    <input type="text" id="related_person" class="form-control"
                                           placeholder="{{__('clients.related_person')}}" name="related_person"
                                           value="{{old('related_person',$client_company->related_person)}}">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.company_address')}}</label>

                                    @if($client_company->address_id>0)
                                        @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                         "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                         ,"value"=>['id'=>$client_company->address_id,'text'=>$client_company->address->address,'hint'=>$client_company->address->address_note]
                                           ])
                                    @else
                                        @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                           "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'])
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.city')}}</label>
                                    <input type="text" id="place" class="form-control"
                                           placeholder="{{__('clients.city')}}" name="place"
                                           value="{{old('place',$client_company->place)}}" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="company_name">{{__('clients.post_code')}}</label>
                                    <input type="text" id="postcode" class="form-control"
                                           placeholder="{{__('clients.post_code')}}" name="postcode"
                                           value="{{old('postcode',$client_company->postcode)}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="company_country">{{__('clients.country')}}</label>
                                    <select name="country_id" id="country_id" class="country-codes" required onchange="changeCountryCode();">
                                        <option value="">Select Country</option>

                                        @foreach($countries as $code=>$countryname)
                                            <option value="{{ $countryname->code }}" title="{{ $countryname->code }}"
                                                    @if($countryname->code ==old('country_id',$client_company->country_id)) selected @endif>{{ $countryname->name }}  </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                      

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_firm_number">{{__('clients.firm_number')}}</label>
                                    <input type="text" id="firm_number" class="form-control"
                                           placeholder="{{__('clients.firm_number')}}" name="firm_number"
                                           value="{{ old('firm_number',$client_company->firm_number) }}" required/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_tax_number">{{__('clients.tax_number')}}</label>
                                    <input type="text" id="tax_number" class="form-control"
                                           placeholder="{{__('clients.tax_number')}}" name="tax_number"
                                           value="{{ old('tax_number',$client_company->tax_number) }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="eu_tax_number">{{__('clients.eu_tax_number')}}</label>
                                    <input type="text" id="eu_tax_number" class="form-control"
                                           placeholder="{{__('clients.eu_tax_number')}}" name="eu_tax_number"
                                           value="{{ old('eu_tax_number',$client_company->eu_tax_number) }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="int_tax_number">{{__('clients.int_tax_number')}}</label>
                                    <input type="text" id="int_tax_number" class="form-control"
                                           placeholder="{{__('clients.int_tax_number')}}" name="int_tax_number"
                                           value="{{ old('int_tax_number',$client_company->int_tax_number) }}"/>
                                </div>
                            </div>
                        </div>
                        @if(0)
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="company_name">{{__('clients.backup_first_phone')}}</label>
                                        <input type="text" id="backup_first_phone" class="form-control"
                                               placeholder="{{__('clients.backup_first_phone')}}"
                                               name="backup_first_phone"
                                               value="{{old('backup_first_phone',$client_company->backup_first_phone)}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="company_name">{{__('clients.spare_second_phone')}}</label>
                                        <input type="text" id="spare_second_phone" class="form-control"
                                               placeholder="{{__('clients.spare_second_phone')}}"
                                               name="spare_second_phone"
                                               value="{{old('spare_second_phone',$client_company->spare_second_phone)}}">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="company_name">{{__('clients.other_phones')}}</label>
                                        <input type="text" id="phones" class="form-control"
                                               placeholder="{{__('clients.other_phones')}}" name="phones"
                                               value="{{old('phones',$client_company->phones)}}">
                                    </div>
                                </div>

                            </div>
                        @endif

                        <div class="row">
                            @if(0)
                                <div class="col-md-6">
                                    <h4 class="form-section"><i class="icon-wallet"></i>{{__('clients.company_bank_info')}}</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="bank_account_owner">{{__('clients.account_owner')}}</label>
                                            <div class="form-group has-feedback">
                                                <input name="bank_account_owner" id="bank_account_owner" class="form-control"
                                                       placeholder=""
                                                       value="{{ old('bank_account_owner',$client_company->bank_account_owner) }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="bank_name">{{__('clients.bank')}}</label>
                                            <div class="form-group has-feedback">
                                                <input name="bank_name" id="bank_name" class="form-control" placeholder=""
                                                       value="{{ old('bank_name',$client_company->bank_name) }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="iban">{{__('clients.iban')}}</label>
                                            <div class="form-group has-feedback">
                                                <input name="iban" id="iban" class="form-control" placeholder=""
                                                       value="{{ old('iban',$client_company->iban) }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="bic">{{__('clients.bic')}}</label>
                                            <div class="form-group has-feedback">
                                                <input name="bic" id="bic" class="form-control" placeholder=""
                                                       value="{{ old('bic',$client_company->bic) }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $oldArray=(!empty(old('special_packages')))?old('special_packages'):$specialPackages ;
                                @endphp
                                <div class="col-md-6">
                                    <h4 class="form-section"><i class="icon-cash"></i> {{__('clients.special_packages')}}</h4>
                                    <select class="js-example-basic-multiple"
                                            name="special_packages[]"
                                            id="special_packages[]" multiple="multiple">
                                        <option value=""></option>
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}" @if(in_array($package->id,$oldArray)) selected @endif>{{$package->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            @endif

                            <div class="col-md-2">

                                <h4 class="form-section"><i class="icon-email"></i> {{__('clients.invoice_email')}}</h4>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="invoice_email" name="invoice_email"
                                                   value="{{old('invoice_mail',$client_company->invoice_email)}}">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <h4 class="form-section"><i class="icon-file-text3"></i> {{__('clients.invoice_settings')}}</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{__('clients.invoice_type')}}:<br>

                                            @include("components.toggle",["id"=>"invoice_type","name"=>"invoice_type","dataon"=>__('clients.instant'),"dataoff"=>__('clients.monthly')
                                            ,"value"=>$client_company->invoice_type,"data_set"=>['true'=>'instant','false'=>'monthly']])

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{__('clients.invoice_send_via_email')}}:<br>
                                            @include("components.toggle",["id"=>"send_via_email","name"=>"send_via_email","dataon"=>__('clients.yes'),"dataoff"=>__('clients.no'),"value"=>$client_company->send_via_email])


                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{__('clients.send_via_mail')}}:<br>
                                            @include("components.toggle",["id"=>"send_via_mail","name"=>"send_via_mail","dataon"=>__('clients.yes'),"dataoff"=>__('clients.no'),"value"=>$client_company->send_via_mail])


                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            {{__('clients.send_via_sms')}}:<br>
                                            @include("components.toggle",["id"=>"send_via_sms","name"=>"send_via_sms","dataon"=>__('clients.yes'),"dataoff"=>__('clients.no'),"value"=>$client_company->send_via_sms])


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row" id="departments"></div>


                        <h4 class="form-section"><i class="icon-cash"></i> {{__('clients.special_prices')}}</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Package</th>
                                        @foreach($vehicleclasses as $vc)
                                            <th style="min-width: 25px">{{ $vc->name }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($packages as $package)
                                        <tr>
                                            <td>{{ $package->name }}</td>
                                            @foreach($vehicleclasses as $vc)
                                                <td>
                                                    @php
                                                        /*      $specialprice =$client_company->prices()
                                                          ->where('vehicle_class_id',$vc->id)
                                                          ->where('package_id',$package->id)
                                                          ->get()->first();*/


          $val=(!empty($specialPrices[$package->id][$vc->id]))?$specialPrices[$package->id][$vc->id]
            :((!empty($priceArray[$package->id][$vc->id]))?$priceArray[$package->id][$vc->id]:0);
                                                    @endphp
                                                    {{ $val}}

                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="20"><h4>Special Packages</h4></td>
                                    </tr>

                                    @foreach($specialPackages as $package)
                                        <tr>
                                            <td>{{ $package->name }}</td>
                                            @foreach($vehicleclasses as $vc)
                                                <td>
                                                    @php
                                                        $val=(!empty($specialPrices[$package->id][$vc->id]))?$specialPrices[$package->id][$vc->id]
                                                       :((!empty($priceArray[$package->id][$vc->id]))?$priceArray[$package->id][$vc->id]:0);
                                                    @endphp
                                                    {{ $val}}

                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach


                                    </tbody>

                                </table>
                            </div>
                        </div>


                        <div class="form-actions">
                            <button class="btn btn-danger pull-right" type="submit">
                                <i class="icon-check"></i> {{__('clients.update_company')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Vehicle Add -->
<!-- TODO : View, Edit Vehicles -->

<script type="text/javascript">

    function getDepartments() {
        $.get('{{asset('/client/company/departments')}}/{{$client_company->id}}', function (data) {////return view
            $('#departments').html(data);

        });
    }



    function changeCountryCode(){
        var country = $('#country_id').val();
             //console.log("co:"+country);
        //$('#nationality').val(country).trigger('change');
        $.get('{{asset('/client/client/find_country_code')}}/' + country, function (country_code) {////return view
            $('#code1').val(country_code).trigger('change');
            $('#code2').val(country_code).trigger('change');
            $('#code3').val(country_code).trigger('change');
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


    function formatState(state) {
        /// console.log(state);
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


    $('#corporate').on('change', function () {
        if ($('#corporate:checked').val()) {
            $('#corporate_block').removeClass('hidden');
        } else {
            $('#corporate_block').addClass('hidden');
        }
    });

    $('#add-company').submit(function (e) {
        e.preventDefault();
        save({{$client_company->id}});
    });

    function save(clientID) {
        $("#loading").show();
        $.post('/client/company/update/'.concat(clientID), $('#add-company').serialize(), function (data) {
            $("#loading").hide();
            swal("{{__('clients.updated')}}", "{{__('clients.client_company_is_updated')}}", "success");
            location.reload();
        }).fail({!! config("view.ajax_error") !!});
        //alert(clientID);
    }


    function addDepartment() {
        if ($('#department_name').val() == '') {
            toastr.options.positionClass = "toast-container toast-bottom-full-width";
            toastr["error"]('department name cant be null');
        } else {
            $.ajax({
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}'
                    , 'company_id': '{{$client_company->id}}'
                    , 'user_id': '{{Auth::id()}}'
                    , 'department_name': $('#department_name').val()

                },
                url: '/client/company/add-department',
                success: function (result) {
                    getDepartments();
                    $('#department_name').val('');
                    //
                },
                error: {!! config("view.ajax_error") !!}
            });


        }

    }

    function removeDepartment(departmentId) {


        swal({
                title: "{{__('clients.are_you_sure')}}",
                text: "{{__('clients.department_will_be_deleted')}}",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "{{__('clients.yes_delete_department')}}",
                cancelButtonText: "{{__('clients.no')}}",
                closeOnConfirm: false,
                closeOnCancel: false,

            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        data: {
                            '_token': '{{csrf_token()}}'
                            , 'department_id': departmentId
                            , 'user_id': '{{Auth::id()}}'
                            , 'company_id': '{{$client_company->id}}'

                        },
                        url: '/client/company/remove-department',
                        success: function (result) {
                            getDepartments();
                            swal("Deleted!", "{{__('clients.department_deleted')}}", "success");


                        },
                        error: {!! config("view.ajax_error") !!}
                    });


                } else {
                    swal("Cancelled", "{{__('expenses.no_change')}}", "error");
                }
            });
        getDepartments();
    }


    $(document).ready(function () {
        getDepartments();

    });

    $(function () {
        $(".js-example-basic-multiple").select2();
        /*   $('#is_company').change(function () {
               if ($(this).prop('checked')) {
                   $('#company_id').hide();
                   $('#corporate_block').show(500);
                   $("#company_name").prop('required', true);
                   $("#company_country").prop('required', true);
                   $("#company_tax_number").prop('required', true);
                   $("#company_address").prop('required', true);
                   $("#corporate").val(1);
               }
               else {
                   $('#company_id').show();
                   $('#corporate_block').hide(500);
                   $("#company_name").prop('required', false);
                   $("#company_country").prop('required', false);
                   $("#company_tax_number").prop('required', false);
                   $("#company_address").prop('required', false);
                   $("#corporate").val(0);
               }
           });*/


        @if($client_company->invoice_type=='monthly')
        $("#invoice_type").val("monthly");
        $('#invoice_sending_type').bootstrapToggle('on');
        @else
        $("#invoice_type").val("instant");
        $('#invoice_sending_type').bootstrapToggle('off');
        @endif




        @if($client_company->invoice_via_email==1)
        $("#send_via_email").val(1);
        $('#invoice_send_via_email').bootstrapToggle('on');
        @else
        $("#send_via_email").val(0);
        $('#invoice_send_via_email').bootstrapToggle('off');
        @endif

        @if($client_company->invoice_via_mail==1)
        $("#send_via_mail").val(1);
        $('#invoice_send_via_mail').bootstrapToggle('on');
        @else
        $("#send_via_mail").val(0);
        $('#invoice_send_via_mail').bootstrapToggle('off');
        @endif

        @if($client_company->invoice_via_sms==1)
        $("#send_via_sms").val(1);
        $('#invoice_send_via_sms').bootstrapToggle('on');
        @else
        $("#send_via_smm").val(0);
        $('#invoice_send_via_sms').bootstrapToggle('off');
        @endif

        $('#invoice_sending_type').change(function () {
            if ($(this).prop('checked')) {
                $("#invoice_type").val("monthly");
            }
            else {
                $("#invoice_type").val("instant");
            }
        });

        $('#invoice_send_via_type').change(function () {
            if ($(this).prop('checked')) {
                $("#invoice_send_via").val("mail");
            }
            else {
                $("#invoice_send_via").val("email");
            }
        });


        $('#invoice_send_via_email').change(function () {
            if ($(this).prop('checked')) {
                $("#send_via_email").val(1);
            }
            else {
                $("#send_via_email").val(0);
            }
        });


        $('#invoice_send_via_mail').change(function () {
            if ($(this).prop('checked')) {
                $("#send_via_mail").val(1);
            }
            else {
                $("#send_via_mail").val(0);
            }
        });

        $('#invoice_send_via_sms').change(function () {
            if ($(this).prop('checked')) {
                $("#send_via_sms").val(1);
            }
            else {
                $("#send_via_sms").val(0);
            }
        });


    });


</script>
@yield('scripts')