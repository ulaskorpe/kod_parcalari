<?php

namespace App\Helpers\SocketHelper;


use App\Models\Log\DriverStateChangeLog;
use App\Models\Notification;
use App\Models\Task;
use App\Models\TaskUserPivot;
use Illuminate\Support\Facades\Redis;

class SocketHelper
{
    public static function socketdriver(int $driverid, int $type, $data)
    {
        $redis = Redis::connection();
        $redis->publish('driver-' . $driverid, json_encode([
            "type" => $type,
            "data" => $data
        ]));
    }

    public static function sockettimetable($status)
    {
        $redis = Redis::connection();
        $redis->publish('timetable', $status);
    }

    public static function socketTaskInformer($user_id,$message)
    {

       // $data=\GuzzleHttp\json_encode($data);

        $redis = Redis::connection();
        $redis->publish('notification-'.$user_id,$message);
    }

    public static function sockettask($user_id,$task)
    {
        $priority_images=array('', 'low.png', 'medium.png', 'high.png');
        $newTaskCount=TaskUserPivot::where('user_id','=',$user_id)->where('seen','=',0)->count();




        $taskHtml="<tr><td width=\"10%\">&nbsp;</td><td>
        <div class=\"row task_row alert alert-info\" onclick=\"updateTask(".$task->id.")\"><div class=\"col-md-12\">
        <b>".__('Tasks.new_task').":".$task->task_title."</b>
        <img src=\"".asset('image/'.$priority_images[$task->priority])."\" alt=\"".
        $priority_images[$task->priority]."\" style=\"padding: 3px;\"><br>".\Carbon\Carbon::parse($task->start_at)->format('d/m/Y H:i')."</div></div></td></tr>";

        $task_title=__('Tasks.task_created_notification',['title'=>$task->task_title?$task->task_title:"title",
            'name'=>$task->created_by()->first()?$task->created_by()->first()->fullname():"Manager"]);


        $data=['taskHtml'=>$taskHtml,'count'=>$newTaskCount,'task_title'=>$task_title];
        $data=\GuzzleHttp\json_encode($data);

        $redis = Redis::connection();
        $redis->publish('todo-'.$user_id,$data);

    }

    public static function sockettooperators(int $type, $data)
    {
        $redis = Redis::connection();

        $redis->publish('manager', json_encode([
            "type" => $type,
            "data" => $data
        ]));
    }

    public static function sockettooperator(int $user_id, int $type, $data)
    {
        $redis = Redis::connection();
        $redis->publish('notification-'.$user_id, $task_title);
    }


}