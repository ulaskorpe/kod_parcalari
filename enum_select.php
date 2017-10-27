       <select name="status" id="status" class="form-control" onchange="getTodo(this.value)">
                                <option value="">{{__('Tasks.select_status')}}</option>
                                @foreach(\Enum\TaskStatuses::getListUcfirst() as $key=>$string)
                                    <option value="{{$key}}" @if($status_ctrl==$key) selected @endif>{{__('Tasks.status_'.$string)}}</option>
                                @endforeach
                            </select>

                        @foreach(\Enum\TaskStatuses::getListUcfirst() as $key=>$string)

                            @if(count($task->opentasks))
                                <a href="javascript:userStatus('{{$task->id}}','{{$key}}')">{{__('Tasks.status_'.$string)}}  : {{count($task->opentasks)}} <br></a>
                            @endif

                        @endforeach


////////////////department - edit enums
            [1,'A1','A1'],[1,'A2','A2'],[1,'B','B'],[1,'C','C'],
            [2,'English','en'],[2,'Türkçe','tr'],[2,'Deutsch','de'],
            [3,'English','gb'],[3,'Türk','tr'],[3,'Deutsch','de'],[3,'USA','us'],[3,'Österreich','at'],
            [4,'Citizen',''],[4,'Foreigner',''],
            [5,'Office',''],[5,'Field','']                        