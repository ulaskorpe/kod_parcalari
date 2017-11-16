 @if(!empty(old('private_users')))
                                                            @foreach($clients as $client)
                                                                <option value="{{$client->id}}"
                                                                        @if(in_array($client->id,old('private_users'))) selected @endif>
                                                                    @if(!empty($client->company_name))
                                                                        [ {{$client->company_name}}
                                                                        ] @endif {{$client->user->fullname()}}
                                                                </option>
                                                            @endforeach

                                                        @else
                                                            @foreach($clients as $client)
                                                                <option value="{{$client->id}}">
                                                                    @if(!empty($client->company_name))
                                                                        [ {{$client->company_name}}
                                                                        ] @endif {{$client->user->fullname()}}
                                                                </option>
                                                            @endforeach

                                                        @endif




    @if(!empty(old('private_companies')))

                                                                    @foreach($clientCompanies as $company)
                                                                        <option value="{{$company->id}}"
                                                                                @if(in_array($company->id,old('private_companies'))) selected @endif>
                                                                            {{$company->company_name}}
                                                                        </option>
                                                                    @endforeach

                                                                @else

                                                                    @foreach($clientCompanies as $company)
                                                                        <option value="{{$company->id}}">
                                                                            {{$company->company_name}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif


        <select class="js-example-basic-multiple"
                                                            name="private_users[]"
                                                            id="private_users[]" multiple="multiple" >





                                                    </select>                                                                