  <tr><td width="10%">&nbsp;</td><td>
                                    <input type="hidden" name="seen_{{$task->task_id}}" id="seen_{{$task->task_id}}" value="{{$task->seen}}">
                                    <div class="row task_row alert alert-info" onclick="updateTask({{$task->task_id}})" id="new_task_{{$task->task_id}}">
                                        <div class="col-md-12">
                                            <b>{{__('Tasks.new_task')}} : {{$task->task_title}}</b>
                                            <img src="{{asset('image/'.$priority_images[$task->priority])}}" alt="{{$priority_images[$task->priority]}}" style="padding: 3px;"><br>
                                            {{\Carbon\Carbon::parse($task->start_at)->format('d/m/Y H:i')}}
                                        </div>
                                    </div>
                                </td>
                            </tr>