<!--
/** * OrangeTech Soft Taxi & Mietwagen Verwaltungssystem
 *
 * @package   Premium
 * @author    OrangeTech Soft <support@orangetechsoft.at>
 * @link      http://www.orangetechsoft.at/
 * @copyright 2017 OrangeTech Soft
 */

/**
 * @package OrangeTech Soft Taxi & Mietwagen Verwaltungssystem
 * @author  OrangeTech Soft <support@orangetechsoft.at>
 */

-->


<div class="col-xs-12">
    <div class="card">
        <div class="card-header">


            <div class="row">
                <div class="col-md-10">
                    <h4 class="card-title"><i class="icon-person-add"></i>{{__('clients.update_client')}}</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                </div>
                <div class="col-md-2">
                    @if(!empty($client->updated_by))
                        ( Last Updated By: {{$client->lastUpdated->fullname()}} )
                    @endif
                </div>
            </div>

        </div>
        <div class="card-body collapse in">
            <div class="card-block">
                <form class="form" id="add-client" action="{{ route('client.client.update') }}" method="post"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <h4 class="form-section"><i class="icon-office">{{__('clients.company_info')}}</i></h4>


                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                {{__('clients.company_name')}} :

                            </div>
                        </div>
                        <div class="col-md-3">
                            @php
                                $company_array=(!empty(old('client_companies')))?old('client_companies'):[];
                            @endphp
                            <select name="client_company_id" id="client_company_id" class="form-control"
                                    onchange="showbutton();">
                                <option value="">Select</option>
                                @foreach($client_companies as $company)
                                    <option value="{{ $company->id }}"
                                            @if(in_array($company->id,$company_array)) selected @endif>
                                        {{$company->company_name}} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-2">
                            @include("components.toggle",["id"=>"is_authorized","name"=>"is_authorized","dataon"=>__('clients.authorized'),"dataoff"=>__('clients.not_authorized')
                            ,"data_set"=>['true'=>'Authorized','false'=>'Not Authorized']])
                        </div>


                        <div id="saveBtn" style="display: none">
                            <div class="col-md-3">
                                <select name="department_id" id="department_id" class="form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button"
                                        class="form-control btn btn-orange"
                                        onclick="addCompany();"><i
                                            class="glyphicon glyphicon-plus"></i>
                                </button>

                            </div>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">

                            <textarea name="client_company_values" id="client_company_values" cols="30" rows="10"
                                      style="display:none">{{$val}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <div id="client_companies_show"></div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="row" id="company_list" style="display: none;">
                        <div class="col-md-6 top-buffer">
                            <table class="table-bordered table-sm"
                                   style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>{{__('clients.client_company')}}</th>
                                    <th>{{__('clients.client_company_department')}}</th>
                                    <th>{{__('clients.is_authorized')}}</th>
                                    <th>{{__('clients.is_default_company')}}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="extra_list_body">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h4 class="form-section"><i class="icon-key2"></i>{{__('clients.client_account')}}</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="phone_number_country_code" id="" class="country-codes" id="country-codes"
                                        required>
                                    @foreach($countrycodes as $code=>$number)
                                        <option title="{{ $code }}"
                                                value="{{ $number }}"
                                                @if($number==old('phone_number_country_code',substr($client->user->gsm_phone,0,strpos($client->user->gsm_phone,'-')))) selected @endif>
                                            +{{ $number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('clients.telephone')}}</label>
                            <div class="form-group has-feedback has-icon-left">
                                <input name="phone_number" class="form-control" id="phone_number" placeholder=""
                                       tabindex="" required
                                       value="{{ old('phone_number',substr($client->user->gsm_phone,strpos($client->user->gsm_phone,'-')+1,strlen($client->user->gsm_phone))) }}">
                                <div class="form-control-position">
                                    <i class="icon-classictelephone"></i>
                                </div>
                                <div class="help-block font-small-3"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">{{__('clients.email')}}</label>
                                <input id="email" class="form-control" placeholder="Email" name="email"
                                       value="{{ old('email',$client->user->email) }}" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="password">{{__('clients.is_vip')}}</label>
                            <div class="form-group">
                                @include("components.toggle",["id"=>"is_vip_name","name"=>"is_vip_name","dataon"=>__('common.yes'),"dataoff"=>__('common.no'),"value"=>$client->is_vip])
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="password">{{__('clients.password')}}</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="password" id="password" class="form-control" id="password"/>
                                    <span class="input-group-btn">
                                        <a href="javascript:addPassword();" class="btn btn-warning" type="button"
                                           style="padding-left: 2px;padding-right: 2px;">{{__('clients.generate')}}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="banned_until">{{__('clients.banned_until')}}   </label>
                            @include("components.date",["id"=>"banned_until","name"=>"banned_until","value"=>$client->user->banned_until])
                        </div>
                    </div>

                    <h4 class="form-section"><i class="icon-person"></i> {{__('clients.client_profile_info')}} </h4>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="title">{{__('clients.title')}}</label>
                                <fieldset class="form-group position-relative">
                                    <input id="title" class="form-control" placeholder="{{__('clients.title')}}"
                                           name="title" value="{{ old('title',$client->title) }}">
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name">{{__('clients.first_name')}}</label>
                                <input id="first_name" class="form-control" placeholder="{{__('clients.first_name')}}"
                                       name="first_name" value="{{ old('first_name',$client->user->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="last_name">{{__('clients.last_name')}}</label>
                                <input id="last_name" class="form-control" placeholder="{{__('clients.last_name')}}"
                                       name="last_name" value="{{ old('last_name',$client->user->last_name) }}"
                                       required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">{{__('clients.gender')}} {{$client->user->gender}}</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option></option>
                                    <option value="{{strtolower(__('clients.male'))}}"
                                            @if(old('gender',$client->user->gender)=='male') selected @endif>{{__('clients.male')}}
                                    </option>
                                    <option value="{{strtolower(__('clients.female'))}}"
                                            @if(old('gender',$client->user->gender)=='female') selected @endif>
                                        {{__('clients.female')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="birthofdate">{{__('clients.birth_of_date')}}</label>
                                @include("components.date",["id"=>"birth_date","name"=>"birth_date","value"=>$client->user->birth_date])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="address">{{__('clients.address')}}</label>
                            <div class="form-group">


                                @if($client->address_id>0)
                                    @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                     "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                     ,"value"=>['id'=>$client->address_id,'text'=>$client->address->address,'hint'=>$client->address->address_note]
                                       ])
                                @else
                                    @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                       "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'])
                                @endif

                            </div>
                        </div>


                        <div class="col-md-2">
                            <label for="postcode">{{__('clients.post_code')}}</label>
                            <div class="form-group">
                                <input class="form-control" name="postcode"
                                       value="{{ old('postcode',$client->postcode) }}"/>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <label for="place">{{__('clients.place')}}</label>
                            <div class="form-group">
                                <input class="form-control" name="place" value="{{ old('place',$client->place) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="residential_id">{{__('clients.residential')}}</label>


                            <select name="residential_id" id="residential_id" class="country-codes" required
                                    onchange="changeCountryCode()">
                                <option value="">Select Country</option>
                                @foreach($countries as $code=>$countryname)
                                    <option value="{{ $code }}" title="{{ $code }}"
                                            @if($code==old('residential_id',$client->residential_id)) selected @endif>{{ $countryname }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="row">


                        <div class="col-md-2">
                            <label>{{__('clients.invoice_mail')}} </label>
                            <div class="form-group">


                                <input type="text" class="form-control" id="invoice_email" name="invoice_email"
                                       value="{{old('invoice_mail',$client->invoice_email)}}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>{{__('clients.country_code')}}</label>
                            <div class="form-group">
                                <select name="backup_first_phone_code" class="country-codes"
                                        id="backup_first_phone_code">
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
                                        id="spare_second_phone_code">
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

                    </div>


                    @if(0)
                        <h4 class="form-section"><i class="icon-wallet"></i> {{__('clients.client_bank_info')}}</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="bank_account_owner">{{__('clients.account_owner')}}</label>
                                <div class="form-group has-feedback">
                                    <input name="bank_account_owner" id="bank_account_owner" class="form-control"
                                           placeholder=""
                                           value="{{ old('bank_account_owner',$client->bank_account_owner) }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="bank_name">{{__('clients.bank')}}</label>
                                <div class="form-group has-feedback">
                                    <input name="bank_name" id="bank_name" class="form-control" placeholder=""
                                           value="{{ old('bank_name',$client->bank_name) }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="iban">{{__('clients.iban')}}</label>
                                <div class="form-group has-feedback">
                                    <input name="iban" id="iban" class="form-control" placeholder=""
                                           value="{{ old('iban',$client->iban) }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="bic">{{__('clients.bic')}}</label>
                                <div class="form-group has-feedback">
                                    <input name="bic" id="bic" class="form-control" placeholder=""
                                           value="{{ old('bic',$client->bic) }}"/>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="form-section"><i class="icon-world"></i>{{__('clients.client_passport_info')}}
                            </h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="identification_card">{{__('clients.identification_type')}}</label>
                                        <select name="identification_card" class="form-control"
                                                id="identification_card">
                                            <option></option>
                                            <option value="{{__('clients.id_card')}}"
                                                    @if(__('clients.passport')==old('identification_card', $client->identification_card)) selected @endif>
                                                ID
                                                CARD
                                            </option>
                                            <option value="{{__('clients.passport')}}"
                                                    @if(__('clients.passport')==old('identification_card', $client->identification_card) ) selected @endif>
                                                PASSPORT
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="nationality">{{__('clients.nationality')}}</label>
                                    <select name="nationality" id="nationality" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $code=>$countryname)
                                            <option value="{{ $code }}"
                                                    @if($code==old('nationality',$client->nationality_id)) selected @endif>{{ $countryname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="identification_number">{{__('clients.identification_number')}}</label>
                                        <input class="form-control" name="identification_number"
                                               id="identification_number"
                                               value="{{ old('identification_number',$client->identification_number) }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="related_person">{{__('clients.related_person_name')}}</label>
                                    <input class="form-control" name="related_person" id="related_person"
                                           value="{{ old('related_person',$client->related_person) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="form-section"><i
                                        class="icon-file-text3"></i>{{__('clients.client_invoice_settings')}}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{__('clients.company_name_show_on_invoice')}} :<br>

                                        @include("components.toggle",["id"=>"invoice_company_name","name"=>"invoice_company_name","dataon"=>__('clients.show'),"dataoff"=>__('clients.hide')
                                                                                ,"value"=>$client->invoice_company_name,"data_set"=>['true'=>'show','false'=>'hide']])

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{__('clients.customer_name_show_on_invoice')}} :<br>

                                        @include("components.toggle",["id"=>"invoice_customer_name","name"=>"invoice_customer_name","dataon"=>__('clients.show'),"dataoff"=>__('clients.hide')
                                        ,"value"=>$client->invoice_customer_name,"data_set"=>['true'=>'show','false'=>'hide']])

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{__('clients.invoice_type')}} :<br>
                                        @include("components.toggle",["id"=>"invoice_type","name"=>"invoice_type","dataon"=>__('clients.instant'),"dataoff"=>__('clients.monthly')
                                                                              ,"value"=>$client->invoice_type,"data_set"=>['true'=>'instant','false'=>'monthly']])

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{__('clients.invoice_send_via_email')}}:<br>

                                        @include("components.toggle",["id"=>"send_via_email","name"=>"send_via_email","dataon"=>__('common.yes'),"dataoff"=>__('common.no')
                                        ,"value"=>$client->invoice_via_email])


                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{__('clients.invoice_send_via_mail')}}:<br>
                                        @include("components.toggle",["id"=>"send_via_mail","name"=>"send_via_mail","dataon"=>__('common.yes'),"dataoff"=>__('common.no')
                                        ,"value"=>$client->invoice_via_mail])


                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{__('clients.invoice_send_via_sms')}}:<br>
                                        @include("components.toggle",["id"=>"send_via_sms","name"=>"send_via_sms","dataon"=>__('common.yes'),"dataoff"=>__('common.no')
                                                                  ,"value"=>$client->invoice_via_sms])

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(0)
                        <h4 class="form-section"><i class="icon-cash"></i> {{__('clients.special_packages')}}</h4>

                        <div class="row">


                            @php
                                $oldArray=(!empty(old('special_packages')))?old('special_packages'):$specialPackages ;
                            @endphp
                            <div class="col-md-12">

                                <select class="js-example-basic-multiple"
                                        name="special_packages[]"
                                        id="special_packages[]" multiple="multiple">
                                    <option value=""></option>
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}"
                                                @if(in_array($package->id,$oldArray)) selected @endif>{{$package->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                    @endif
                    <style>
                        h1.hidden {
                            display: none;
                        }
                    </style>

                    <div class="hidden">
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
                                                        /*      $specialprice =$client->prices()
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

                                    @if(count($specialPackages))
                                        <tr>
                                            <td colspan="20">Special Packages</td>
                                        </tr>

                                        @foreach($specialPackages as $package)
                                            <tr>
                                                <td>{{ $package->name }}</td>
                                                @foreach($vehicleclasses as $vc)
                                                    <td>
                                                        @php
                                                            /*      $specialprice =$client->prices()
                                                              ->where('vehicle_class_id',$vc->id)
                                                              ->where('package_id',$package->id)
                                                              ->get()->first();*/


              $val=(!empty($specialPrices[$package->id][$vc->id]))?$specialPrices[$package->id][$vc->id]
              :((!empty($priceArray[$package->id][$vc->id]))?$priceArray[$package->id][$vc->id]:0);
                                                        @endphp


                                                        <input type="number" step="0.01" class="form-control"
                                                               name="prices[{{ $package->id }}][{{ $vc->id }}]"
                                                               value="{{ $val}}"/>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <a class="btn btn-grey pull-right" data-dismiss="modal" style="margin-right: 10px;">
                                    <i class="icon-cross2"></i> {{__('clients.close')}}
                                </a>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-danger pull-right" type="submit" id="saveBtn">
                                    <i class="icon-check"></i> {{__('clients.update_client')}}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function changeCountryCode() {
        var country = $('#residential_id').val();
        console.log("co:" + country);
        //$('#nationality').val(country).trigger('change');
        $.get('{{asset('/client/client/find_country_code')}}/' + country, function (country_code) {////return view
            $('#backup_first_phone_code').val(country_code).trigger('change');
            $('#spare_second_phone_code').val(country_code).trigger('change');
            $('#phone_number_country_code').val(country_code).trigger('change');
        });
    }


    var companyList = [];
    var clientCompanies = [];
    var departments = [];
    @foreach($client_companies as $clientcompany)
    clientCompanies.push({
        companyid: '{{$clientcompany->id}}',
        companyname: '{{$clientcompany->company_name}}'.trim()
    });
    @endforeach

    @foreach($departments as $department)
    departments.push({
        departmentid: '{{$department->id}}',
        departmentname: '{{$department->department_name}}'.trim()
    });
    @endforeach


    $(document).ready(function () {

        $("#client_company_id").select2();
        $("#nationality").select2();
        $(".js-example-basic-multiple").select2();
        addCompanyStart();

    });


    function fillcompanyList() {
        var content = "";
        var submitvalues = [];
        var i = 0;
        for (var key in companyList) {
            if (typeof companyList[key] !== 'undefined' && companyList[key] != null) {
                content += '<tr><td>' + companyList[key].companyname + '</td>';
                content += '<td>' + companyList[key].departmentname + '</td>';
                content += '<td>' + companyList[key].isauthorized + '</td>';

                /*if(companyList[key].isauthorized==1){
                    content += '<td>' +   '{{__('clients.authorized')}}' + companyList[key].isauthorized + '</td>';
                }else{
                    content += '<td>' +   '{{__('clients.not_authorized')}}' +companyList[key].isauthorized + '</td>';
                }*/

                if (i == 0 && companyList[key].companyid != '') {
                    content += '<td><input type="radio" name="is_default_company" id="is_default_company" checked value="' + companyList[key].companyid + '"></td>';
                } else {
                    content += '<td><input type="radio" name="is_default_company" id="is_default_company" value="' + companyList[key].companyid + '"></td>';
                }
                content += '<td><button type="button" onclick="removeCompany(' + key + ')" class="btn btn-float btn-sm btn-danger delete"><i class="icon-cross2"></i></button></td></tr>';
                i++;
            }
        }
        $('#companyList').val(JSON.stringify(companyList));
        $('#extra_list_body').html(content);


    }

    function addCompany() {

        if (document.getElementById('client_company_id').selectedOptions[0].innerHTML != "") {
            var value = document.getElementById('client_company_id').selectedOptions[0].innerHTML;
            var department = document.getElementById('department_id').selectedOptions[0].innerHTML;
            for (var i = 0; i < companyList.length; i++) {
                if (companyList[i]["companyid"] === $('#client_company_id').val() && department === companyList[i]["departmentname"]) {
                    companyList.splice(i, 1);
                }
            }
            companyList.push({
                companyid: $('#client_company_id').val(),
                companyname: value,
                departmentname: department,
                isauthorized: $('#is_authorized').val(),
                val1: "@" + $('#client_company_id').val() + ":" + $('#department_id').val() + ":1",
                val2: "@" + $('#client_company_id').val() + ":" + $('#department_id').val() + ":2"
            });

            fillcompanyList();
            document.getElementById('client_company_id').selected = '';
        }
        else {
            toastr.options.positionClass = "toast-container toast-bottom-full-width";
            toastr["error"]("Please select a client company");
            return false;
        }


        var val1 = "@" + $('#client_company_id').val() + ":" + $('#department_id').val() + ":1";
        var val2 = "@" + $('#client_company_id').val() + ":" + $('#department_id').val() + ":2";

        document.getElementById('client_company_values').value = $('#client_company_values').val().replace(val1, '');
        document.getElementById('client_company_values').value = $('#client_company_values').val().replace(val2, '');

        var auth = ($('#is_authorized').val() == 'Authorized' ) ? 1 : 2;
        document.getElementById('client_company_values').value += '@' + $('#client_company_id').val() + ":" + $('#department_id').val() + ":" + auth;


        if (companyList.length > 0) {
            $('#company_list').show(500);
        } else {
            $('#company_list').hide(500);
        }
    }

    function removeCompany(key) {
        if (companyList[key].isauthorized == "Authorized") {
            var value = companyList[key].val1;
        } else {
            var value = companyList[key].val2;
        }
        companyList.splice(key, 1);
        var currentValue = $('#client_company_values').val();
        document.getElementById('client_company_values').value = currentValue.replace(value, '');
        fillcompanyList();
    }

    function showDepartments() {
        if ($('#client_company_id').val()) {
            $.get('client/get_departments/' + $('#client_company_id').val(), function (data) {
                $('#department_id').html(data);
            });
        } else {
            $('#department_id').html('');
        }

    }///showdepartments


    function findCompany(id) {
        var company = 'null';
        for (var i = 0; i < clientCompanies.length; i++) {
            if (clientCompanies[i].companyid == id) {
                company = clientCompanies[i].companyname.trim();
                break;
            }
        }
        return company;
    }

    function findDepartment(id) {
        var department = 'null';
        for (var i = 0; i < departments.length; i++) {
            if (departments[i].departmentid == id) {
                department = departments[i].departmentname.trim();
                break;
            }
        }
        return department;
    }

    function addCompanyStart() {

        var arr = $('#client_company_values').val().split("@");
        var arr2 = '';
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] != '') {
                arr2 = arr[i].split(':');
                companyList.push({
                    companyid: arr2[0],
                    companyname: findCompany(arr2[0]),
                    departmentname: findDepartment(arr2[1]),
                    isauthorized: (arr2[2] == 2) ? '{{__('clients.not_authorized')}}' : '{{__('clients.authorized')}}',
                    val1: "@" + arr2[0] + ":" + arr2[1] + ":1",
                    val2: "@" + arr2[0] + ":" + arr2[1] + ":2"
                });
            }
        }
        if (companyList.length > 0) {
            $('#company_list').show(500);
        } else {
            $('#company_list').hide(500);
        }

        fillcompanyList();
    }


    function showbutton() {
        if ($('#client_company_id').val()) {
            showDepartments();
            $('#saveBtn').show(500);
        } else {
            $('#saveBtn').hide(500);
        }
    }

    function addPassword() {
        var val = generatePassword();
        $("#password").val(val);
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


    $('#add-client').submit(function (e) {
        e.preventDefault();
        save({{$client->id}});
    });

    function save(clientId) {
        $("#loading").show();
        $.post('/client/client/update/'.concat(clientId), $('#add-client').serialize(), function (data) {
            $("#loading").hide();
            swal("{{__('clients.updated')}}", "{{__('clients.client_is_updated')}}", "success");
            location.reload();
        }).fail({!! config("view.ajax_error") !!});
    }

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
@yield('scripts')

