
 <div class="row">
                        <form action="{{route('driver.order.orderlist')}}" method="post" style="float: right">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <h4>{{__('Orders.orders_for',['name'=>$driver->user->fullname()])}}</h4>
                            </div>
                            <div class="col-md-6">
                                {{ \Carbon\Carbon::parse($startdate)->format('d.m.Y')}} - {{ \Carbon\Carbon::parse($enddate)->format('d.m.Y')}}
                            </div>
                        </form>
                    </div>

                    <div class="card-header">

                    </div>

 <table>
                                    <tr><td colspan="6"></td></tr>
                                    <tr>

                                        <td style="padding-left: 15px;">



                                        </td>
                                        <td width="10%">&nbsp;</td>
                                        <td>
                                            <table><tr>
                                            @foreach(\Enum\JobStatuses::getListUcfirst() as $key=>$string)
                                                @php
                                                $name=strtolower($string);
                                                $value = (in_array($name,$show_array))?1:0;
                                                @endphp
                                                <td>
                                                    <label for="password">{{$string}}</label><br>
                                                    @include("components.toggle",["id"=>$name,"name"=>$name,"dataon"=>__('Orders.show'),"dataoff"=>__('Orders.hide'),"value"=>$value])</td>
                                            @endforeach
                                                </tr></table>
                                        </td>
                                        <td>


                                            @include("components.daterange",
                                            [
                                            "start_date_id"=>"filterstartdate"
                                            ,"start_date_name"=>"filterstartdate"
                                            ,"startdate"=>$startdate
                                            ,"end_date_id"=>"filterenddate"
                                            ,"end_date_name"=>"filterenddate"
                                            ,"enddate"=>$enddate
                                            ,"view"=>"true"
                                            ])
                                        </td>

                                        <td>

                                            <div style="float: right;;margin-left: 20px;">
                                                <button class="btn btn-primary">
                                                    <i class="icon-filter"></i>&nbsp;{{__('orders.filter')}}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>