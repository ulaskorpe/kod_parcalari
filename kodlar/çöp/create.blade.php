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
                    <h4 class="card-title"><i class="icon-head"></i> Create Vehicle</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <a href="{{ route('manager.vehicle.index') }}" class="btn btn-primary btn-sm"><i
                                    class="icon-plus4 white"></i> Back</a>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <form class="form" id="add-vehicle" action="{{ route('manager.vehicle.create') }}"
                              method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="brand">Brand</label>
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
                                        <label for="company">Model</label>
                                        <div class="form-group">
                                            <select class="form-control" name="model" id="modelselect">
                                            </select>
                                            {!! $errors->getBag('validation')->first('model', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="plate">Plate</label>
                                        <div class="form-group">
                                            <input name="plate" type="text" class="form-control" required
                                                   value="{{ old('plate') }}"/>
                                            {!! $errors->getBag('validation')->first('plate', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="notes">Notes</label>
                                        <div class="form-group">
                                            <input name="notes" type="text" class="form-control"
                                                   value="{{ old('notes') }}"/>
                                            {!! $errors->getBag('validation')->first('notes', '<p class="tag-default tag-danger block-tag text-xs-right"><small class="block-area white">:message</small></p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button class="btn btn-danger pull-right" type="submit">
                                        <i class="icon-check"></i> Create Vehicle
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