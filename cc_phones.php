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
                                                            @if($number==old('code1',$c1)) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number1" class="form-control"  name="phone_number1" placeholder="{{__('drivers_companies.phone')}} #1"
                                                   value="{{ old('phone_number1',$p1) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}} #2</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="code2" id="code2" class="country-codes" >
                                                <option value=""></option>
                                                @foreach($countrycodes as $code=>$number)
                                                    <option title="{{ $code }}"
                                                            value="{{ $number }}"
                                                            @if($number==old('code2',$c2)) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number2" class="form-control" name="phone_number2" placeholder="{{__('drivers_companies.phone')}} #2"
                                                   value="{{ old('phone_number2',$p2) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_phone_number3">{{__('drivers_companies.phone')}} #3</label>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <select name="code3" id="code3" class="country-codes" >
                                                <option value=""></option>
                                                @foreach($countrycodes as $code=>$number)
                                                    <option title="{{ $code }}"
                                                            value="{{ $number }}"
                                                            @if($number==old('code3',$c3)) selected @endif>
                                                        +{{ $number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="phone_number3" class="form-control" name="phone_number3" placeholder="{{__('drivers_companies.phone')}} #3"
                                                   value="{{ old('phone_number3',$p3) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            ---------------tankcardcompany----------------


                 <div class="col-md-2">
                                <label>{{__('clients.country_code')}}</label>
                                <div class="form-group">
                                    <select name="phone_code" id="phone_code" class="country-codes" id="country-codes" required>
                                        @foreach($countrycodes as $code=>$number)
                                            <option title="{{ $code }}"
                                                    value="{{ $number }}"
                                                    @if($number==old('phone_code')) selected @endif>
                                                +{{ $number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>{{__('vehicles.phone')}}</label>
                                <div class="form-group has-feedback has-icon-left">
                                    <input name="phone" type="text" class="form-control" id="phone" placeholder="" tabindex="" value="{{ old('phone') }}">
                                    <div class="form-control-position">
                                        <i class="icon-classictelephone"></i>
                                    </div>
                                    <div class="help-block font-small-3"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>{{__('clients.country_code')}}</label>
                                <div class="form-group">
                                    <select name="phone_code2" id="phone_code2" class="country-codes" id="country-codes">
                                        @foreach($countrycodes as $code=>$number)
                                            <option title="{{ $code }}"
                                                    value="{{ $number }}"
                                                    @if($number==old('phone_code2')) selected @endif>
                                                +{{ $number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>{{__('vehicles.mobile_phone')}}</label>
                                <div class="form-group has-feedback has-icon-left">
                                    <input name="mobile_phone" type="text" class="form-control" id="mobile_phone" placeholder="" tabindex="" value="{{ old('mobile_phone') }}">
                                    <div class="form-control-position">
                                        <i class="icon-classictelephone"></i>
                                    </div>
                                    <div class="help-block font-small-3"></div>
                                </div>
                            </div>
                            