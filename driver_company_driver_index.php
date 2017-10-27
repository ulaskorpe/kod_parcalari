@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opRecover'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')

@stop

@section('content-body')
    <section id="basic-form-layouts">
        <div class="row match-height" style="padding-top: 10px">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">

                            <h4 class="card-title"><img src="{{asset('/image/src/driver.png?v=2')}}" width="24"></img> Driver List</h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                @if(0)
                                <a href="javascript:createDriver()">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="icon-plus4 white"></i>
                                        Create Driver
                                    </button>
                                </a>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <!-- Task List table -->
                            <table id="clients"
                                   class="table  table-bordered row-grouping display table-responsive  icheck table-middle">
                                <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th style="width: 107px">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($model as $driver)
                                    <tr id="client-row-{{ $driver->id }}">
                                        <td>
                                             {{ $driver->user->fullname() }}
                                        </td>
                                        <td class="text-xs-center">
                                            <a href="mailto:{{ $driver->user['email'] }}">{{ $driver->user['email'] }}</a>
                                        </td>
                                        <td>{{ $driver->user->gsm_phone }}</td>

                                        <td class="text-xs-center">
                                            @if($driver->company)
                                                {{ $driver->company->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>


                                            <a href="{{route('driver_company.order.orderlist',['driver_id'=>$driver->id])}}" class="btn btn-float btn-sm btn-warning">
                                                <i class="icon-watch"></i>
                                                <span></span>
                                            </a>

                                            <a href="javascript:loadDriverProfile({{ $driver->id }})" class="btn btn-float btn-sm btn-info">
                                                <i class="icon-eye"></i>
                                                <span></span>
                                            </a>
                                            @if(0)
                                            <a href="javascript:updateDriver({{$driver->id}})"
                                               class="btn btn-float btn-sm btn-warning">
                                                <i class="icon-pencil2"></i>
                                                <span></span>
                                            </a>

                                            <a href="javascript:deleteDriver({{$driver->id}})"
                                               class="btn btn-float btn-sm btn-danger delete">
                                                <i class="icon-cross2"></i>
                                                <span></span>
                                            </a>
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">
                            <h4 class="card-title"><i class="icon-eye"></i> Driver Information</h4>
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
    </section>

    <div class="modal fade modal-lg" id="saveModal" role="dialog" style="background-color: #fffffc;margin: auto">
        <div id="loading" class="folding-cube loader-blue-grey" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;  margin: auto;">
            <div class="cube1 cube"></div>
            <div class="cube2 cube"></div>
            <div class="cube4 cube"></div>
            <div class="cube3 cube"></div>
        </div>
        <div class="modal-header bg-info">
            <a class="close" data-dismiss="modal" style="color: #fffffc">×</a>
            <!--//TODO: Translate docs must be edited...-->
            <h4 style="color: #fffffc">@yield('title',trans('Create/Update Driver'))</h4>
        </div>
        <div id="modal-body" class="modal-body">

        </div>
    </div>

@stop

@section('scriptParts')

    <!-- BEGIN PAGE LEVEL JS-->
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#clients').DataTable({
                searchable: true
            });
            var href;

            $('#confirm-danger').click(function (event) {

                window.location = href;
            });
        });
        function loadDriverProfile(driverId) {
            $("#loading").show();
            $.get('/driver_company/driver/profile/'.concat(driverId), function (mdata) {
                $("#loading").hide();
                $("#detail").html(mdata);
            });
        }

        function updateDriver(driverId) {
            $("#loading").show();
            $.get('/driver_company/driver/update/'.concat(driverId), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }
        function deleteDriver(companyId) {
            swal({
                    title: "Are you sure?",
                    text: "This company will be deleted",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get('/driver_company/driver/delete/'.concat(companyId), function (mdata) {
                            swal("Deleted!", "Company is deleted !", "success");
                            location.reload();
                        }).fail(function () {
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"]("An Error Occurred !");
                        });
                    } else {
                        swal("Cancelled", "There is no change!", "error");
                    }
                });

        }

        function createDriver() {
            $("#loading").show();
            $.get('/driver_company/driver/create', function (mdata) {
               // console.log(mdata);
                $("#loading").hide();
                $("#modal-body").html(mdata);
            });
            $('#saveModal').modal();
        }

    </script>
    <!-- END PAGE LEVEL JS-->
@stop