
   <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="icon-file"></i> {{__('department.files_title',['name'=>$user->fullname()])}}</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">

                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">

                    <form class="form" id="create_file" action="{{route('manager.department.files.create') }}"
                          method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">{{__('department.files')}}</label>
                                        <input type="file" name="file" class="form-control" id="files" placeholder="{{__('department.files')}}" value="" >

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">{{__('department.file_type')}}</label>

                                        <select name="file_type" id="file_type"   class="form-control">
                                            <option value="">{{__('department.select_file_type')}}</option>
                                            @foreach(\Enum\PersonalFileTypes::getList() as $key=>$string)
                                                <option value="{{$key}}" @if(old('file_type')==$key) selected @endif>{{__('department.file_type_'.$string)}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_address">{{__('department.description')}}</label>
                                        <input type="text" id="description" class="form-control"
                                               name="description"
                                               placeholder="{{__('department.description')}}" value="{{ old('description') }}"/>
                                    </div>
                                </div>
                            </div>


                            <div class="form-actions">

                                <button class="btn btn-danger pull-right" type="submit">
                                    <i class="icon-check"></i> {{__('department.create_file')}}
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


@section('scriptParts')
    <script type="text/javascript">

/*
        $('#create_file').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            alert("ok");
            save(formData);
            //$('#create-package').submit();
        });

        function save(formData) {
            $.ajax({
                type: 'POST',
                url: '/manager/department/files/create',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal("personal updated ", "personal updated!", "success");
                    location.reload();
                    // window.open('/manager/department/index/4', '_self');
                },
                error: function (data) {

                    var errors = data.responseJSON;
                    errors = errors['errors'];
                    var errosHtml = "";
                    var i = 0;
                    $.each(errors, function (key, value) {
                        if (i == 0) {
                            var id = "#".concat(key);
                            $("#" + key).css("border", '1px solid red');
                            $("#" + key).effect("shake");
                            $("#" + key).focus();
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"](errors[key]);

                        }
                    });


                }
            });

        }


*/

$('#create_file').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    save(formData);
});

function save(formData) {
    $("#loading").show();
    $.ajax({
        type: 'POST',
        url: '/manager/department/create',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            swal("Expense created ", "Expense created!", "success");

            location.reload();
        },
        error: {!!config("view.ajax_error")!!}
    });
    $("#loading").hide();

}


    </script>
@stop