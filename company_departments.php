    <div class="row" id="departments"></div>

    <script type="text/javascript">

    function getDepartments() {
        $.get('{{asset('/client/company/departments')}}/{{$client_company->id}}', function (data) {////return view
            $('#departments').html(data);

        });
    }


    function addDepartment() {
        if ($('#department_name').val() == '') {
            toastr.options.positionClass = "toast-container toast-bottom-full-width";
            toastr["error"]('department name cant be null');
        } else {
            $.ajax({
                type: "POST",
                data: {
                    '_token': '{{csrf_token()}}'
                    , 'company_id': '{{$client_company->id}}'
                    , 'user_id': '{{Auth::id()}}'
                    , 'department_name': $('#department_name').val()

                },
                url: '/client/company/add-department',
                success: function (result) {
                    getDepartments();
                    $('#department_name').val('');
                    //
                }
            }).fail(function (response) {
                if (response.status === 422) {
                    toastr.options.positionClass = "toast-container toast-bottom-full-width";
                    toastr["error"](response.responseText);
                }
            });

        }

    }

    function removeDepartment(departmentId) {


        swal({
                title: "{{__('clients.are_you_sure')}}",
                text: "{{__('clients.department_will_be_deleted')}}",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "{{__('clients.yes_delete_department')}}",
                cancelButtonText: "{{__('clients.no')}}",
                closeOnConfirm: false,
                closeOnCancel: false,

            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        data: {
                            '_token': '{{csrf_token()}}'
                            , 'department_id': departmentId
                            , 'user_id': '{{Auth::id()}}'
                            , 'company_id': '{{$client_company->id}}'

                        },
                        url: '/client/company/remove-department',
                        success: function (result) {
                            getDepartments();
                            swal("Deleted!", "{{__('clients.department_deleted')}}", "success");


                        }
                    }).fail(function (response) {
                        if (response.status === 422) {
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"](response.responseText);
                        }
                    });


                } else {
                    swal("Cancelled", "{{__('Expenses.no_change')}}", "error");
                }
            });
        getDepartments();
    }


    $(document).ready(function () {
        getDepartments();

    });

</script>

<?php  /////route 
Route::get('/departments/{company_id}', 'CompanyController@departments')->name('client.company.departments');
Route::post('/add-department', 'CompanyController@addDepartment');
Route::post('/remove-department', 'CompanyController@removeDepartment');


//////companycontroller 


    public function departments($company_id=0){
        $departments=ClientCompanyDepartment::where('client_company_id','=',$company_id)->get();

        $client=Client::where('user_id','=',Auth::id())->first();

        $authorized=ClientCompanyPivot::where('client_company_id','=',$company_id)->where('authorized','=',1)
                    ->where('client_id','=',$client->id)->pluck('client_company_department_id')->toArray();
        return view('themes.' . static::$tf . '.client.company.departments', [
            'departments' => $departments,'authorized'=>$authorized
        ]);

    }


        public function addDepartment(Request $request){

        $findDepartment=ClientCompanyDepartment::where('department_name','=',$request['department_name'])->where('client_company_id','=',$request['company_id'])
            ->first();
        if(empty($findDepartment->id)){
        $department=new ClientCompanyDepartment();
        $department->department_name=$request['department_name'];
        $department->client_company_id=$request['company_id'];
        $department->save();

        $client=Client::where('user_id','=',Auth::id())->first();

        $clientDepartment=new ClientCompanyPivot();
        $clientDepartment->client_id =$client->id;
        $clientDepartment->client_company_id=$request['company_id'];
        $clientDepartment->client_company_department_id = $department->id;
        $clientDepartment->authorized=1;
        $clientDepartment->save();

        return response("ok", 200);
        }else{
            return response("there is a department named ".$request['department_name'], 422);
        }


    }

   public function removeDepartment(Request $request){

      $department=ClientCompanyDepartment::where('id','=',$request['department_id'])->first();

        $client=Client::where('user_id','=',Auth::id())->first();
        $authorized=ClientCompanyPivot::where('client_company_id','=',$department->client_company_id)->where('authorized','=',1)
            ->where('client_id','=',$client->id)->pluck('client_company_department_id')->toArray();


        if($department->department_name!='Management'&&(in_array($request['department_id'],$authorized))){
            $managmentDepartment=ClientCompanyDepartment::where('client_company_id','=',$request['company_id'])
                ->where('department_name','=','Management')->first();

            ClientCompanyPivot::where('client_company_id','=',$request['company_id'])
                ->where('client_company_department_id','=',$department->id)
                ->update(['client_company_department_id'=>$managmentDepartment->id]);
            $department->delete();
            return response("ok", 200);
        }else{
            return response("You cant delete  ".$department->department_name." department", 422);
        }
    }


///////departments migrate

      Schema::create('client_company_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_name');
            $table->unsignedInteger('client_company_id')->default(0);
            $table->boolean('is_management')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->integer('updated_by')->nullable()->default(0);
        });

//////cc pivot 
  Schema::create('clients_companies', function(Blueprint $table)
        {
            $table->integer('client_id')->unsigned()->index();
            $table->integer('client_company_id')->unsigned()->index();
            $table->integer('client_company_department_id')->nullable()->default(0);
            $table->boolean('authorized')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

?>


/*/*/*/*/* view departments -  partial


<div class="col-md-6">
    <h4 class="form-section"><i class="icon-office"></i> {{__('clients.company_departments')}}</h4>

    <div class="row">
            @foreach($departments as $department)
            <div class="col-md-3" style="margin: 5px;background-color: #f4f4f4;">{{$department->department_name}}

                @if($department->department_name!='Management' && (in_array($department->id,$authorized)))
                        <button class="btn btn-red btn-sm pull-right" type="button" style="margin-left: 20px;" onclick="removeDepartment({{$department->id}})">
                            <i class="icon-cross"></i>
                        </button>
                    @endif
            </div>
                @endforeach
    </div>


</div>
<div class="col-md-6">
    <h4 class="form-section"><i class="icon-plus"></i> {{__('clients.add_department')}}</h4>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control" id="department_name" id="department_name">
        </div>
        <div class="col-md-1">
            <button class="btn btn-green pull-right" type="button" style="margin-left: 20px;" onclick="addDepartment()">
                <i class="icon-plus"></i>
            </button>
        </div>
    </div>
</div>