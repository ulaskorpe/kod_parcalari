<div class="card-block ">
    <strong>{{$model->user->name}} {{$model->user->last_name}}</strong>
    <hr/>
    <div class="bs-callout-primary callout-border-left p-1">

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">Name:</div>
                    <div class="col-md-8">{{$model->user->name}} {{$model->user->last_name}} </div>
                </div>
                <div class="row">
                    <div class="col-md-4">Email:</div>
                    <div class="col-md-8">{{$model->user->email}}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">Phone:</div>
                    <div class="col-md-8">{{$model->user->gsm_phone}}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">Postal Code:</div>
                    <div class="col-md-8">{{$model->postal_code}}</div>
                </div>

                @if($model->vehicle_id)

                    <div class="row">
                        <div class="col-md-4">Assigned Vehicle :</div>
                        <div class="col-md-8">

                            [{{ $vehicle->plate }}]<br>
                            {{ $vehicle->vehiclemodel->vehiclebrand->name }}->{{ $vehicle->vehiclemodel->name }}
                            ( {{ $vehicle->vehiclemodel->vehicleclass->name }} )
                            @if($vehicle->company_id)
                                <br>  {{ $vehicle->company?$vehicle->company->name:"" }}
                            @endif


                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-6  border-left border-left-grey">
                <div class="row">
                    <div class="col-md-4">Birth Date:</div>
                    <div class="col-md-8">{{\Carbon\Carbon::parse($model->user->birth_date)->format("d-M-Y")}}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">Gender:</div>
                    <div class="col-md-8">
                        {{$model->user->gender}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">Company:</div>
                    <div class="col-md-8">@if($model->company){{ $model->company->name }}@else -  @endif</div>
                </div>
                <div class="row">
                    <div class="col-md-4">Address:</div>
                    <div class="col-md-8">{{$model->address->address}}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button class="btn btn-outline-primary" onclick="driverDetails({{$model->id}})">Driver Details</button>
            </div>
        </div>
    </div>


</div>