@extends('themes.robust.layouts.default')

@section('pageTitle', trans('pageTitle.opRecover'))
@section('metaDescription', '...')
@section('metaKeywords', '...')

@section('cssParts')

@stop

@section('content-body')

   <div class="col-md-12">
                <div class="card">
                    <div class="card-head">
                        <div class="card-header">
                            <h4 class="card-title">{{__('expenses.expense_list')}}</h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <a href="javascript:createExpense()">
                                    <button type="button" class="btn btn-primary btn-sm"><i
                                                class="icon-plus4 white"></i>
                                        {{__('expenses.create_expense')}}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse in">
                        <div class="card-block">
                            <!-- Task List table -->


                            <div class="card-block">
                                @include( "components.datatable",
                                                   [   "id"=>"expenses"
                                                   ,"name"=>"expenses"
                                                   ,"datatable_url"=>"/common/datatable/main"
                                                   ,"modelname"=>\App\Models\Expense::class
                                                   ,"tablename"=>"expenses"
                                                    ,"params_json"=>null
                                                   ,"functionname"=>"ExpensesForDriver"
                                                   ,"buttons"=>"components.buttons_expense"
                                                           ,"columns"=>[
                                                                   "actions"=>           __("expenses.table_expense_actions")
                                                                 ,"amount"=>      __("expenses.table_expense_amount")
                                                                 ,"expense_title"=>     __("expenses.table_expense_description")
                                                                 ,"type_name"=>         __("expenses.table_expense_type")
                                                                 ,"companyname"=>       __("expenses.table_expense_belongs_to")
                                                                 ,"plate"=>             __("expenses.table_expense_vehicle_plate")
                                                                 ,"date"=>              __("expenses.table_expense_date")
                                                                 ,"expense_document"=>  __("expenses.table_expense_document")
                                                                 ,"last_updatedby"=>    __("expenses.table_expense_created_by")

                                                                 ]
                                                   ])


                        </div>
                    </div>
                </div>
            </div>

        </div>

    <div class="modal fade modal-lg in" id="saveModal" role="dialog"
         style="background-color: #fffffc;margin: auto;height: 700px">
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
            <h4 style="color: #fffffc">Create / Update Expense</h4>
        </div>
        <div id="modal-body" class="modal-body">

        </div>
    </div>

    @include("components.delete",["post_url"=>'/driver/expenses/delete',"id"=>"expense_id"])
@stop

@section('scriptParts')

    <!-- BEGIN PAGE LEVEL JS-->
    <script type="text/javascript">
        function createExpense() {
            $("#loading").show();
            $.get('/driver/expenses/create', function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }
        function loadElement(expenseId) {
            $("#loading").show();
            $('#modal_title').html('{{__('expenses.expense_details')}}');
            $.get('/driver/expenses/profile/'+expenseId, function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }



        function createFile(userId) {
            $("#loading").show();
            $.get('/driver/department/files/create/'+userId, function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }


        function downloadElement(fileId){
            $.get('/driver/department/files/downloadfile/'+fileId,function (data){
                //window.open(data,'_blank');//  alert(data);
                var linkx = '{{route('pfiles')}}/?u='+data;
                window.open(linkx,'_self');

            }).fail({!! config("view.ajax_error") !!});
        }

        function downloadElement(fileId){
            $.get('/driver/expenses/downloadfile/'+fileId,function (data){
                var downloadlink = '{{route('pfiles')}}/?u='+data;
                downloadlink = downloadlink.toString();
                window.open(downloadlink,'_self');
            }).fail({!! config("view.ajax_error") !!});
        }



        function updateElement(expenseId) {
            $("#loading").show();
            $.get('/driver/expenses/edit/'.concat(expenseId), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
                $(".select2").select2();
            }).fail({!! config("view.ajax_error") !!});
            $('#saveModal').modal();
        }
        function loadActivity(loggable_id) {
            $("#loading").show();
            $.get('/driver/activity/getactivitylog?log_model=Expense&element_id='.concat(loggable_id), function (mdata) {
                $("#loading").hide();
                $("#modal-body").html(mdata);
                $('#saveModal').modal();
            }).fail({!! config("view.ajax_error") !!});

        }
    </script>
    <!-- END PAGE LEVEL JS-->
@stop   