@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opRecover'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')

@stop

@section('content-body')
    <section id="basic-form-layouts">
        <div class="col-xs-12">


            <div class="row" style="padding-top: 10px">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">

                                <h4 class="card-title"><img src="{{asset('/image/src/driver.png?v=2')}}" width="24"> </img>{{__('drivers_companies.driver_list')}}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <a href="javascript:createDriver()">
                                        <button type="button" class="btn btn-primary btn-sm"><i class="icon-plus4 white"></i>
                                            {{__('drivers_companies.create_driver')}}
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
                                          "id"=>"drivers"
                                           ,"name"=>"clients"
                                           ,"datatable_url"=>"/common/datatable/main"
                                           ,"modelname"=>\App\Models\Driver::class
                                           ,"tablename"=>"drivers"
                                           ,"params_json"=>null
                                           ,"functionname"=>"DriversForDriverCompany"
                                           ,"buttons"=>"components.buttons_set3"
                                           ,"columns"=>[
                                                        "actions"=> __("drivers_companies.table_actions")
                                                        ,"name"=> __("drivers_companies.table_name")
                                                         ,"last_name"=>     __("drivers_companies.table_last_name")
                                                         ,"email"=>         __("drivers_companies.table_email")
                                                         ,"gsm_phone"=>     __("drivers_companies.table_phone")

                                           ]])
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title"><i class="icon-eye"></i> {{__('drivers_companies.driver_information')}}</h4>
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

    <div class="modal fade modal-xl" id="saveModal" role="dialog" style="background-color: #fffffc;margin: auto;height: 900px;">
        <div id="loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <!--//TODO: Translate docs must be edited...-->
            <div id="modal_title"></div>

        </div>
        <div id="modal-body" class="modal-body">

        </div>
    </div>
    @include("components.delete",["post_url"=>"/manager/driver/delete","id"=>"driver_id"])
    @include("components.modal",["id"=>"modalCreatePunishment","modal_class"=>"modal fade modal-lg","modal_header"=>"Create Driver Punishment"])
@stop

@section('scriptParts')

    <!-- BEGIN PAGE LEVEL JS-->
    <script type="text/javascript">
        $(document).ready(function () {

            var href;

            $('#confirm-danger').click(function (event) {

                window.location = href;
            });
        });

        function loadElement(driverId) {

            $("#loading").show();
            $.get('/driver_company/driver/profile/'.concat(driverId), function (mdata) {
                $("#loading").hide();
                $("#detail").html(mdata);
            });
        }


        function createDriver(driverId) {
            $("#modal_title").html("<h4 style=\"color: #fffffc\" id=\"modal_title\">{{__('drivers_companies.create_driver')}}</h4>");
            $("#loading").show();
            $.get('/driver_company/driver/create/', function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }

        function updateElement(driverId) {
            $("#modal_title").html("<h4 style=\"color: #fffffc\" id=\"modal_title\">{{__('drivers_companies.update_driver')}}</h4>");
            $("#loading").show();
            $.get('/driver_company/driver/edit/'.concat(driverId), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }

        function driverDetails(driverId,show,start_at,end_at){
           show=(show==null)?'show_expenses':show;
            start_at=(start_at==null)?'{{\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(-7)->toDateString()}}':start_at;
            end_at=(end_at==null)?'{{\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(+7)->toDateString()}}':end_at;
            /*
            $("#modal_title").html("<h4 style=\"color: #fffffc\" id=\"modal_title\">{{__('drivers_companies.driver_details')}}</h4>");
            $("#loading").show();
            $.get('/driver_company/driver/driver_details/'.concat(driverId)+'/'+show+'/'+start_at+'/'+end_at, function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();*/

            window.open('{{asset('/driver_company/driver/driver_details/')}}/'.concat(driverId),'_self');

        }

    </script>
    <!-- END PAGE LEVEL JS-->
@stop