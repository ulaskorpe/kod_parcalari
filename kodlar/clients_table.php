      <table id="clients"
                                       class="table  table-bordered row-grouping display   icheck table-middle dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>{{__('clients.full_name')}}</th>
                                        <th>{{__('clients.client_companies')}}</th>
                                        <th>{{__('clients.email')}}</th>
                                        <th>{{__('clients.phone')}}</th>

                                        <th style="width: 107px">{{__('clients.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($model as $client)
                                        <tr id="client-row-{{ $client->id }}">
                                            <td>
                                                 {{ $client->user['name'] .' '.$client->user['last_name'] }}
                                            </td>

                                            <td class="text-xs-left">
                                              @foreach($client->companies as $company)
                                                   {{$company->clientCompany->company_name}} ,<br/>
                                                  @endforeach
                                            </td>
                                            <td class="text-xs-center">
                                                <a href="mailto:{{ $client->user['email'] }}">{{ $client->user['email'] }}</a>
                                            </td>
                                            <td>{{ $client->user->gsm_phone }}</td>

                                            <td width="18%">

                                                <a href="javascript:loadClientProfile({{ $client->id }})"
                                                   class="btn btn-float btn-sm btn-info"> <i class="icon-eye"></i>
                                                    <span></span>
                                                </a>

                                                <a href="javascript:updateClient({{$client->id}})"
                                                   class="btn btn-float btn-sm btn-warning"> <i
                                                            class="icon-pencil2"></i>
                                                    <span></span>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>