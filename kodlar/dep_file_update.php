    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title"><i class="icon-file"></i> {{$title}}</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    </div>
                    <div class="col-md-2">
                        @if(!empty($file->updated_by))
                            ( {{__('drivers_companies.last_updated_by',['name'=>$file->lastUpdated->fullname()])}} )
                        @endif
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form" id="update_file" action="{{ route('manager.department.files.update') }}"
                          method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <input type="hidden" name="user_id" id="user_id" value="{{$file->user->id}}">
                            <input type="hidden" name="file_id" id="file_id" value="{{$file->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">{{__('department.files')}}</label>
                                        <input type="file" name="file" class="form-control" id="files" placeholder="{{__('department.files')}}" value="">
                                        @if(!empty($file->file))
                                            <a href="{{route('pfiles')}}/?u={{$file->file}}" target="_blank">{{$filename}}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">{{__('department.file_type')}}</label>

                                        <select name="file_type" id="file_type" required class="form-control">
                                            <option value="">{{__('department.select_file_type')}}</option>
                                            @foreach(\Enum\UserStatus::getList() as $key=>$string)
                                                <option value="{{$key}}" @if(old('file_type',$file->file_type)==$key) selected @endif>{{__('department.file_type_'.$string)}}</option>
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
                                               placeholder="{{__('department.description')}}" value="{{ $file->description }}" required/>
                                      </div>
                                </div>
                            </div>


                            <div class="form-actions">
                                <button class="btn btn-danger pull-right" type="submit">
                                    <i class="icon-check"></i> {{__('department.update_file')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Vehicle Add -->


@section('scriptParts')
    <script type="text/javascript">
        $('#update_file').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            alert("ok");
          ///  save(formData);
        });

        function save(formData) {
            $("#loading").show();
            $.ajax({
                type: 'POST',
                url: '/manager/department/files/edit/{{$file->id}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal("File updated ", "File updated!", "success");
                    location.reload();
                },
                error:  {!! config("view.ajax_error") !!}
            });
            $("#loading").hide();

        }


    </script>
@stop