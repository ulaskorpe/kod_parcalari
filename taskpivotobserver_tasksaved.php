<?php

        $statusArray=array();
        foreach(\Enum\TaskStatuses::getListUcfirst() as $key=>$string){
            $statusArray[$key]=__('Tasks.status_'.$string);
        }


        $task=Task::with('created_by')->where('id','=',$taskUserPivot->task_id)->select('created_by_id','task_title')->first();


        $user=User::find(Auth::id());
        $original_status = $taskUserPivot->getOriginal('status');

        if($task->group_task==1){

            if($original_status!=$taskUserPivot->status){
          /*      $message=__('Tasks.changed_task',['name'=>$user->fullname(),'title'=>$task->task_title,'original'=>$statusArray[$original_status],'status'=>$statusArray[$taskUserPivot->status]]);
                SocketHelper::socketTaskInformer($taskUserPivot->user_id,$message);

                $notification=new Notification();
                $notification->user_id=$taskUserPivot->user_id;
                $notification->notification=$message;
                $notification->save();*/
            }

        }else{

            if($original_status!=$taskUserPivot->status){
          $message=$task->task_title."::::".$user->fullname();



          //__('Tasks.changed_task',['name'=>$user->fullname(),'title'=>$task->task_title,'original'=>$statusArray[$original_status],'status'=>$statusArray[$taskUserPivot->status]]);
               SocketHelper::socketTaskInformer($task->created_by_id,$message);

                            $notification=new Notification();
                            $notification->user_id=$task->created_by_id;
                            $notification->notification=$message;
                            $notification->save();
            }

        }



               $notification=new Notification();
                        $notification->user_id=111;
                        $notification->notification="GROP MSG ".$taskPivot->task->task_title.":::".$taskPivot->task->group_task;
                        $notification->save();
?>


        //$original = $task->getOriginal();

//        SocketHelper::socketTaskInformer($task->created_by_id,$task->task_title." UPDAYTED");

        /*$original_title = $task->getOriginal('task_title');
        $original_description = $task->getOriginal('task_description');
        $original_priority = $task->getOriginal('task_priority');*/


