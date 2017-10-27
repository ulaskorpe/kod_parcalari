    <div class="card-body collapse in">
                <div class="card-block">
                    <!-- Task List table -->
                    <table id="clients"
                           class="table  table-bordered row-grouping display   icheck table-middle dataTable no-footer">
                        <thead>
                        <tr>

                            <th>{{__('department.description')}}</th>
                            <th>{{__('department.date')}}</th>
                            <th>{{__('department.file')}}</th>
                            <th>{{__('department.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php
                         $privateFileHelper = new App\Helpers\PrivateFileHelper\PrivateFileHelper();
                        @endphp
                        @foreach($files as $file)
                            @php
                            $fileArray=explode('/',$file->file);
                            @endphp

                            <tr id="client-row-{{ $file->id }}">

                                <td>
                                    <div class="media">
                                        <div class="media-body media-middle">
                                            {{ $file->description}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="media">
                                        <div class="media-body media-middle">
                                            {{ $file->date }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="media">
                                        <div class="media-body media-middle">
                                            {{ $fileArray[count($fileArray)-1] }}
                                        </div>
                                    </div>
                                </td>
                                <td width="127px;">
<a href="{{$privateFileHelper->makeUrl($file->file)}}" target="_blank" class="btn btn-float btn-info btn-sm"><i class="icon-outbox"></i><span></span></a>
<a href="{{ route('manager.department.files.update', ['user_id'=>$file->user_id,'file_id'=>$file->id]) }}" class="btn btn-float btn-warning btn-sm"><i class="icon-pencil"></i><span></span></a>
<a href="javascript:deleteElement({{$file->id}})"  class="btn btn-float btn-sm btn-danger delete">  <i class="icon-cross2"></i>
                                        <span></span> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>


            {{$privateFileHelper->makeUrl($file->file)}}