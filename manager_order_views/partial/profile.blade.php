


    <div class="row">
        <div class="col-md-12">
            <div class="bs-callout-primary callout-border-left p-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{__('orders.order')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.id')}}:</div>
                            <div class="col-md-7">{{$order->id}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.time')}}:</div>
                            <div class="col-md-7">{{$order->start_time}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.type')}}:</div>
                            {{--<div class="col-md-8">{{$order->order_type}}</div>--}}
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.price')}}:</div>
                            <div class="col-md-7">{{$order->price}} €</div>
                        </div>
                        <div class="row top-buffer">
                            <div class="col-md-12">
                                <h5>{{__('orders.payment')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.type')}}:</div>
                            <div class="col-md-7">{{$order->paymenttype->payment_title}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.status')}}:</div>
                            <div class="col-md-7">{{$order->payment_status==0?'Not Paid':'Paid'}}</div>
                        </div>
                        <div class="row top-buffer">
                            <div class="col-md-12">
                                <h5>{{__('orders.note')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.general')}}:</div>
                            <div class="col-md-7">{{$order->note}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.driver')}}:</div>
                            <div class="col-md-7">{{$order->drivernote}}</div>
                        </div>
                    </div>


                    <div class="col-md-6 border-left border-left-grey">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{__('orders.client')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.name')}}:</div>
                            <div class="col-md-7">{{$order->client->user->fullname()}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.phone')}}:</div>
                            <div class="col-md-7">{{$order->client->user->gsm_phone}}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">{{__('orders.company')}}:</div>
                            <div class="col-md-7">{{$order->client->company ? $order->client->company->company_name : '-'}}</div>
                        </div>


                        <div class="row top-buffer">
                            <div class="col-md-12">
                                <h5>{{__('orders.start_info')}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.address')}}:</div>
                            <div class="col-md-7">{{$order->locations->first()->startlocation->address}}</div>
                        </div>


                        <div class="row">
                            <div class="col-md-5">{{__('orders.address_note')}}:</div>
                            <div class="col-md-7">{{$order->locations->first()->startlocation->address_note}}</div>
                        </div>
                        <div class="row top-buffer">
                            <div class="col-md-12">
                                <h5>{{__('orders.end_info')}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">{{__('orders.address')}}:</div>
                            <div class="col-md-7">{{$order->locations->first()->endlocation->address}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">{{__('orders.address_note')}}:</div>
                            <div class="col-md-7">{{$order->locations->first()->endlocation->address_note}}</div>
                        </div>
                    </div>
                </div>


                @if($order->jobs->count()>0)
                    <hr>
                    <div class="row top-buffer">
                        <div class="col-md-12"><h5>{{__('orders.jobs')}}</h5></div>
                        <div class="col-md-12">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>{{__('orders.driver_name')}}</th>
                                    <th>{{__('orders.vehicle_class')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->jobs as $job)
                                    <tr>
                                        <td>
                                            {{$job->driver?$job->driver->user->fullname():'Unassigned'}}
                                        </td>
                                        <td>
                                            {{$job->vehicleclass->name}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>

