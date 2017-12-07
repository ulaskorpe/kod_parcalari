

@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opVehicles'))
@section('metaDescription', '...')
@section('metaKeywords', '...')


@section('cssParts')

@stop

@section('content-body')
    <!-- Vehicle Add -->

        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="icon-head"></i> {{__('vehicles.create_vehicle')}}</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="{{ route('driver_company.vehicle.index') }}" class="btn btn-primary btn-sm"><i
                                    class="icon-plus4 white"></i> {{__('vehicles.back')}}</a>
                    </div>
                </div>



                <div class="card-body collapse in">
                    <div class="card-block">
                        <form class="form" id="add-vehicle" action="{{ route('driver_company.vehicle.create') }}"  method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                            <div class="form-body">

                                @if ($errors->any())

                                    <div class="row">
                                    <div class="alert alert-danger col-md-4">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    </div>


                                @endif



                           <div class="row">
                                    <div class="col-md-4">

                                        <label for="brand">{{__('vehicles.brand')}}</label>
                                        <div class="form-group">
                                            <select class="form-control" id="brand" name="brand">
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                            @if($brand->id==old('brand')) selected @endif>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->getBag('validation')->first('brand', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="company">{{__('vehicles.model')}}</label>
                                        <div class="form-group">
                                            <select class="form-control" name="model" id="modelselect">
                                            </select>
                                            {!! $errors->getBag('validation')->first('model', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="plate">{{__('vehicles.plate')}}</label>
                                        <div class="form-group">
                                            <input name="plate" type="text" class="form-control" required
                                                   value="{{ old('plate') }}"/>
                                            {!! $errors->getBag('validation')->first('plate', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="notes">{{__('vehicles.company')}}</label>
                                        <div class="form-group">
                                            <select name="company_id" id="company_id" class="form-control" disabled>
                                                <option value="">Select</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" @if($company->id ==  $driver_company_id) selected @endif>    {{$company->name}} </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="notes">{{__('vehicles.km')}}</label>
                                        <div class="form-group">
                                            <input name="km" id="km"
                                                   type="number" min="0" class="form-control"
                                                   data-bts-postfix="€" step="1"
                                                   data-bts-decimals="2"
                                                   value="{{ old('km') }}"
                                                   style="min-width: 100px"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="notes">{{__('vehicles.notes')}}</label>
                                        <div class="form-group">
                                            <input name="notes" type="text" class="form-control"
                                                   value="{{ old('notes') }}"/>
                                            {!! $errors->getBag('validation')->first('notes', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button class="btn btn-danger pull-right" type="submit">
                                        <i class="icon-check"></i> {{__('vehicles.create_vehicle')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Vehicle Add -->
    <!-- TODO : View, Edit Vehicles -->
@stop

@section('scriptParts')
    <script type="text/javascript">

        $(document).ready(function () {

            $.get('getmodels/' + $('#brand').val(), function (data) {

                var html = "";

                for (var i = 0; i < data.length; i++) {

                    html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }

                $('#modelselect').html(html);

            });
        });

        $('#brand').on('change', function () {

            $.get('getmodels/' + $('#brand').val(), function (data) {

                var html = "";

                for (var i = 0; i < data.length; i++) {

                    html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                }

               $('#modelselect').html(html);

            });
        });
        function formatState(state) {
            console.log(state);
            if (!state.id) {
                return state.text;
            }
            else {
                var $state = $(
                    '<span><img src="{{ asset("assets/images/flags") }}/' + state.title.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            }
        }
        $(".country-codes").select2({
            templateResult: formatState,
            templateSelection: formatState,
        });
        $('#corporate').on('change', function () {
            if ($('#corporate:checked').val()) {
                $('#corporate_block').removeClass('hidden');
            } else {
                $('#corporate_block').addClass('hidden');
            }
        });
    </script>
@stop