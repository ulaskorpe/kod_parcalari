

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
<form class="form" id="create-file" name="create-file" action="{{route('manager.department.files.create') }}"
                          method="post" enctype="multipart/form-data">



                        {{csrf_field()}}
                        <div class="form-body">
                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">{{__('department.files')}}</label>
                                        <input type="file" name="file" class="form-control" id="files[]" placeholder="{{__('department.files')}}" value=""  required>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company_address">{{__('department.description')}}</label>
                                        <input type="text" id="description" class="form-control"
                                               name="description" required
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
        $('#create-file').submit(function(e){
            e.preventDefault();
            alert("ok");
            var formData = new FormData(this);
            save(formData);
        });

        function save(formData) {
            $("#loading").show();
            $.ajax({
                type:'POST',
                url: '/manager/department/files/create',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    swal("{{__('Vehicles.created')}}!", "{{__('Vehicles.vehicle_class_is_created')}}!", "success");
                    location.reload();
                },
                error: function(data){
                    if (data.status === 422) {
                        var errors = data.responseJSON;
                        var errosHtml = "";
                        $.each(errors, function (key, value) {
                            var id = "#".concat(key);
                            $("#" + key).css("border", '1px solid red');
                            $("#" + key).effect("shake")
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"](value[0]);

                        });

                    }
                }
            });

        }

    </script>
@stop