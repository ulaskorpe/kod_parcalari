<table id="vehicles" class="table  table-bordered row-grouping display   icheck table-middle dataTable no-footer">
                                    <thead>
                                    <tr role="row">
                                        <th>{{__('vehicles.actions')}}</th>
                                        <th>{{__('vehicles.plate')}}</th>
                                        <th>{{__('vehicles.brand')}}</th>
                                        <th>{{__('vehicles.model')}}</th>
                                        <th>{{__('vehicles.company')}}</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vehicles as $vehicle)

                                        <tr id="client-row-{{ $vehicle->id }}">
                                            <td width="25%">
                                                <div class="media">
                                                    <div class="media-body media-middle">
                                                        <a href="javascript:loadVehicleProfile({{ $vehicle->id }})" class="btn btn-float btn-sm btn-info"> <i class="icon-eye"></i>
                                                            <span></span>
                                                        </a>
                                                        <a href="javascript:updateVehicle({{$vehicle->id}})" class="btn btn-float btn-sm btn-warning"> <i class="icon-pencil2"></i>
                                                            <span></span>
                                                        </a>

                                                        <a href="{{route('manager.vehicle.profile-show',$vehicle->id)}}" class="btn btn-float btn-sm btn-blue"> <i class="icon-profile"></i>
                                                            <span></span> </a>

                                                        <a href="javascript:deleteElement({{$vehicle->id}})" class="btn btn-float btn-sm btn-danger delete"> <i class="icon-cross2"></i>
                                                            <span></span> </a>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>{{ $vehicle->plate }}</td>
                                            <td>{{ $vehicle->vehiclemodel->vehiclebrand->name }}</td>
                                            <td>{{ $vehicle->vehiclemodel->name }}</td>
                                            <td>
                                                @if($vehicle->company_id)
                                                    {{ $vehicle->company->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>