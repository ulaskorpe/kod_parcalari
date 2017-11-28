 @include("components.telephone",["id"=>"phone_number","name"=>"phone_number","class"=>"form-control input-lg","onclick"=>"switchLogintype('gsm')"])

////eski driver create 
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



                        </div>


                    </div>



//////driver co create


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}} #1</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="code1" id="code1" class="country-codes" >
                                                <option value=""></option>
                                                @foreach($countrycodes as $code=>$number)
                                                    <option title="{{ $code }}"
                                                            value="{{ $number }}"
                                                            @if($number==old('code1')) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number1" class="form-control"
                                                   name="phone_number1"
                                                   placeholder="{{__('drivers_companies.phone')}} #1"
                                                   value="{{ old('phone_number1') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}} #2</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="code2" id="code2" class="country-codes">
                                                <option value=""></option>
                                                @foreach($countrycodes as $code=>$number)
                                                    <option title="{{ $code }}"
                                                            value="{{ $number }}"
                                                            @if($number==old('code2')) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number2" class="form-control"
                                                   name="phone_number2"
                                                   placeholder="{{__('drivers_companies.phone')}} #2"
                                                   value="{{ old('phone_number2') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}} #3</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="code3" id="code3" class="country-codes">
                                                <option value=""></option>
                                                @foreach($countrycodes as $code=>$number)
                                                    <option title="{{ $code }}"
                                                            value="{{ $number }}"
                                                            @if($number==old('code3')) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number3" class="form-control"
                                                   name="phone_number3"
                                                   placeholder="{{__('drivers_companies.phone')}} #3"
                                                   value="{{ old('phone_number3') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
recourse update 

                                      <div class="col-md-1">
                                <label>{{__('clients.country_code')}}</label>
                                <div class="form-group">
                                    <select name="phone_code" class="country-codes"
                                            id="phone_code" required>
                                        @foreach($countrycodes as $code=>$number)
                                            <option title="{{ $code }}"
                                                    value="{{ $number }}"
                                                    @if($number==old('phone_code',substr($recourse->phone,0,strpos($recourse->phone,'-')))) selected @endif>
                                                +{{ $number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>{{__('clients.backup_first_phone')}}</label>
                                <div class="form-group has-feedback has-icon-left">
                                    <input name="phone_number" class="form-control" id="phone_number"
                                           placeholder="" tabindex="" required
                                           value="{{ old('phone_number',substr($recourse->phone,strpos($recourse->phone,'-')+1,strlen($recourse->phone))) }}">
                                    <div class="form-control-position">
                                        <i class="icon-classictelephone"></i>
                                    </div>
                                    <div class="help-block font-small-3"></div>
                                </div>
                            </div>
