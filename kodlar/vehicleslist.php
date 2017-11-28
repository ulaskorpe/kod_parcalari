@extends('themes.robust.layouts.default')

@section('pageTitle', __('page_title.manager_vehicle_list'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')

@stop

@section('content-body')
    <section id="basic-form-layouts">


        <div class="col-xs-12">

            <div class="row match-height" style="padding-top: 10px">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title"><i class="icon-car"></i> {{__('vehicles.vehicle_list')}}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <a href="javascript:createVehicle();">
                                        <button type="button" class="btn btn-primary btn-sm"><i class="icon-plus4 white"></i>
                                            {{__('vehicles.create_vehicle')}}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body collapse in">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">


                                        @include( "components.datatable",[
                                                 "id"=>"vehicles"
                                                  ,"name"=>"vehicles"
                                                  ,"datatable_url"=>"/common/datatable/main"
                                                  ,"modelname"=>\App\Models\Vehicle::class
                                                  ,"tablename"=>"vehicles"
                                                         ,"params_json"=>null
                                                  ,"functionname"=>"Vehicles"
                                                  ,"buttons"=>"components.buttons_set2"
                                                   ,'width'=>'140px'
                                                  ,"columns"=>[
                                                               "actions"=>     __('vehicles.actions')
                                                               ,"plate"=>  __('vehicles.plate')
                                                                ,"brand"=>   __('vehicles.brand')
                                                                ,"model"=>  __('vehicles.model')
                                                                ,"class"=>  __('vehicles.class')
                                                                ,"company"=> __('vehicles.company')

                                                  ]])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title"><i class="icon-eye"></i> {{__('vehicles.vehicle_info')}}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="detail" class="card-body collapse in">


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="modal fade modal-lg in" id="saveModal" role="dialog" style="background-color: #fffffc;margin: auto;height: 600px">
        <div id="loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <!--//TODO: Translate docs must be edited...-->
            <h4 style="color: #fffffc">{{__('vehicles.create_update_vehicle')}}</h4>
        </div>
        <div id="modal-body" class="modal-body">

        </div>
    </div>

    @include("components.delete",["post_url"=>"/manager/vehicle/delete","id"=>"vehicle_id"])


@stop

@section('scriptParts')

    <!-- BEGIN PAGE LEVEL JS-->
    <script type="text/javascript">


        function createVehicle() {
            $("#loading").show();
            $.get('/manager/vehicle/create', function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }

        function updateVehicle(vehicleId) {
            $("#loading").show();
            $.get('/manager/vehicle/edit/'.concat(vehicleId), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }



        function loadElement(vehicleId) {
            alert(vehicleId);
          
        }
    </script>
    <!-- END PAGE LEVEL JS-->
@stop