@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opRecover'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')

@stop

@section('content-body')
    <section id="basic-form-layouts">

        <div class="col-xs-12">


            <div class="row match-height" style="padding-top: 10px">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title"><i class="icon-users2"></i>{{__('clients.client_list')}}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <a href="javascript:createClient();">
                                        <button type="button" class="btn btn-primary btn-sm"><i
                                                    class="icon-plus4 white"></i>
                                            {{__('clients.create_client')}}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body collapse in">
                            <div class="card-block">
                                @include( "components.datatable",
                                         [   "id"=>"clients"
                                         ,"name"=>"clients"
                                         ,"datatable_url"=>"/common/datatable/main"
                                         ,"modelname"=>\App\Models\Client::class
                                         ,"tablename"=>"clients"
                                         ,"functionname"=>"ClientsClients"
                                         ,"params_json"=>null
                                         ,"buttons"=>"components.buttons_set"
                                         ,"columns"=>["full_name"=>            __("clients.table_name")
                                                       ,"email"=>               __("clients.table_email")
                                                       ,"gsm_phone"=>           __("clients.table_phone")
                                                       ,"company_name"=>           __("clients.company_name")
                                                       ,"actions"=>             __("clients.table_actions")]])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title"><i class="icon-eye"></i> {{__('clients.client_information')}}
                                </h4>
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
    <div class="modal fade modal-xl" id="saveModal" role="dialog" style="background-color: #fffffc;margin: auto">
        <div id="loading" class="folding-cube loader-blue-grey"
             style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <!--//TODO: Translate docs must be edited...-->
            <h4 style="color: #fffffc">@yield('title',trans(__('clients.create_update_client')))</h4>
        </div>
        <div id="modal-body" class="modal-body">

        </div>
    </div>
    <div class="modal hide" id="loginModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">✕</button>
            <h3>Please Confirm Your Password</h3>
        </div>
        <div class="modal-body" style="text-align:center;">
            <div class="row-fluid">
                <div class="span10 offset1">
                    <div id="modalTab">
                        <div class="tab-content">
                            <div class="tab-pane active" id="login">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scriptParts')
    <script type="text/javascript">
        $(document).ready(function () {
            
        });

        function loadClientProfile(clientId) {
            $("#loading").show();
            $.get('/client/client/profile/'.concat(clientId), function (mdata) {
                $("#loading").hide();
                $("#detail").html(mdata);
            });
        }

        function createClient() {
            $("#loading").show();
            $.get('/client/client/create', function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }

        function updateClient(clientId) {
            $("#loading").show();
            $.get('/client/client/update/'.concat(clientId), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }


    </script>
@stop