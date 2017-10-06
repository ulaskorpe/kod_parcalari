         @foreach($model as $m)
                                            <tr>
                                                <td class=" details-control">
                                                    <table id="table{{$m->id}}" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;background-color:#fff;display:none">

                                                        <tr>
                                                            <th>Driver Name</th>
                                                            <th>Vehicle</th>
                                                            <th>Is Accept</th>
                                                            <th>Is Complated</th>
                                                            <th>Complated Date</th>

                                                        </tr>
                                                        @foreach($m->jobs as $j)
                                                            @if(isset($j->driver->id))
                                                                @if($j->driver->id>0)
                                                                    <tr>

                                                                        <td>{{$j->driver->user->name}} {{$j->driver->user->last_name}}</td>
                                                                        <td>{{$j->vehicleclass->name}}</td>
                                                                        <td>{{$j->isaccepted == 0 ? 'No' : 'Yes'}}</td>
                                                                        <td>{{$j->is_complated == 0 ? 'No' : 'Yes'}}</td>
                                                                        <td>{{$j->is_complated == 0 ? '' : $j->complated_at}}</td>
                                                                    </tr>
                                                                @endif
                                                            @else
                                                                <tr style="background-color: floralwhite">
                                                                    <td>Unassigned to driver</td>
                                                                    <td>@if(isset($j->vehicleclass->name)){{$j->vehicleclass->name}}@endif</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                </td>
                                                <td style="display: none;">{{$m->id}}</td>
                                                <td>{{$m->package->name}}</td>
                                                <td>{{$m->start_time}}</td>
                                                <td>{{$m->duration}}</td>
                                                <td>{{$m->price}}</td>
                                                <td>
                                                    <a href="javascript:loadOrder({{ $m->id }});" class="btn btn-float btn-sm btn-info">
                                                        <i class="icon-eye"></i>
                                                        <span></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach