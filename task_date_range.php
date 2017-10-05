   <div class="row">
                        <div class="col-md-2">
                            <div id="show_name"><h4
                                        class="card-title">{{__('Tasks.tasks',['name'=>$user->fullname()])}}</h4>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="user_id">{{__('Tasks.start_at')}}</label>
                            @include('components.date_time',['id'=>'start_at','name'=>'start_at','value'=>\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(-30),'onchange'=>'show_tasks'])

                        </div>
                        <div class="col-md-2">
                            <label for="user_id">{{__('Tasks.end_at')}}</label>
                            @include('components.date_time',['id'=>'end_at','name'=>'end_at','value'=>\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(15),'onchange'=>'show_tasks'])
                        </div>
                        <div class="col-md-2">
                            <label for="user_id">Tasks For</label>
                            <select name="user_id" id="user_id" class="form-control"
                                    onchange="show_tasks();">
                                <option value="all">All</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->display_name}} Tasks</option>
                                @endforeach

                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->fullname()}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="user_id">{{__('Tasks.status')}}</label>
                            <select name="status" id="status" class="form-control" onchange="show_tasks();">
                                <option value="0">Open Tasks</option>
                                <option value="3">Completed Tasks</option>
                                <option value="2">Tasks in progress</option>
                                <option value="1">To-do Tasks</option>
                                <option value="5">Cancelled Tasks</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label for="user_id">{{__('tasks.priority')}}</label>
                            <select name="priority" id="priority" class="form-control" onchange="show_tasks();">
                                <option value="0"> {{__('Tasks.all_tasks')}}</option>
                                <option value="1"> {{__('Tasks.low')}}</option>
                                <option value="2"> {{__('Tasks.medium')}}</option>
                                <option value="3"> {{__('Tasks.high')}}</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <table>
                                <tr>
                                    <td>
                                        <a href="javascript:createTask()">
                                            <button type="button" class="btn btn-primary btn-sm"><i
                                                        class="icon-plus4 white"></i>
                                                {{__('Tasks.create_task')}}
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <a href="{{route('user.tasks.index')}}">
                                            <button type="button" class="btn btn-orange btn-sm"><i
                                                        class="icon-list white"></i>
                                                {{__('Tasks.task_list')}}
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </table>


                        </div>

                    </div>