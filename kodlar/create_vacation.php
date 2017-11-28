
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-file"></i>  {{__('department.create_vacation_for_user')}}</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">

                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form" id="add-vehicle" action="{{ route('manager.department.vacationcreate') }}"
                          method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">

                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            <input type="hidden" name="vacation_id" id="vacation_id" value="">
                            <div class="row">

                                    <div class="col-md-6">
                                        <label for="start_at"> {{__('department.start_at')}} </label>

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="icon-calendar3"></i></span>


                                            <input type="hidden" class="form-control datepicker-default" id="start_at" name="start_at" value="{{old('start_at')}}" >
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="start_at">  {{__('department.end_at')}} </label>

                                        <div class="input-group">

                                            <span class="input-group-addon"><i class="icon-calendar3"></i></span>

                                            <input type="hidden" class="form-control datepicker-default" id="end_at" name="end_at" value="{{old('end_at')}}">
                                        </div>

                                    </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_address"> {{__('department.description')}}</label>
                                        <input type="text" id="description" class="form-control"
                                               name="description"
                                               placeholder=" {{__('department.description')}}" value="{{ old('description') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="height: 70px;">
                                <div class="col-md-12">
                                    <button class="btn btn-danger pull-right" type="submit">
                                        <i class="icon-check"></i>  {{__('department.create_new_vacation')}}</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Vehicle Add -->
    <!-- TODO : View, Edit Vehicles -->

