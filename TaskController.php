<?php

namespace App\Http\Controllers\Manager\Task;

use App\Models\RoleUser;
use App\Models\Task;
use App\Models\TaskUserPivot;
use App\Role;
use App\User;
use Carbon\Carbon;
use Dompdf\Exception;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {



        $user_id= \Auth::id();

        $data=[
            'users'=>User::all(),
            'roles'=>Role::all(),
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'user'=>User::find($user_id),
            'status' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done'))

        ];



        return view('themes.' . static::$tf . '.manager.task.index', $data);
    }

    private function tarihFormat($tarih){
        /*
         *    endDate: new Date(2013, 1, 6, 23, 59),
                                startDate: new Date(2013, 1,6, 14,11)

        2017-07-16 12:00:00
         *"07/11/2017 14:00"
         * */

        $dizi=explode(' ',$tarih);
        $diziTarih=explode('-',$dizi[0]);
        $diziSaat=explode(':',$dizi[1]);
        /*$ay=intval($diziTarih[1])-1;
        $gun=intval($diziTarih[2]);
        $saat=intval($diziSaat[0]);
        $dk=intval($diziSaat[1]);*/
        //$sonuc=$diziTarih[0].','.$ay.','.$gun.','.$saat.','.$dk;
        $sonuc=$diziTarih[1].'/'.$diziTarih[2].'/'.$diziTarih[0].' '.$diziSaat[0].':'.$diziSaat[1];
        return $sonuc;
    }

    public function tarihYap($deger){
        $aylar=array('Jan'=>'01','Feb'=>'02','Mar'=>'03','Apr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'08','Sep'=>'09','Oct'=>'10','Nov'=>'11','Dec'=>'12');
        //Thu Jul 13 2017 03:10:00 GMT+0300  // 2017-07-16 15:53:14
        $dizi= explode(" ",$deger);
        //$diziTarih=explode("-",$dizi[0]);
        //$diziSaat=explode(":",$dizi[1]);
        if(empty($aylar[$dizi[1]])){
        return $deger;
        }else{
        return $dizi[3].'-'.$aylar[$dizi[1]].'-'.$dizi[2].' '.$dizi[4];
        }
    }

    public function timeline($user_id=0){


        $user_id=($user_id)?$user_id:\Auth::id();
        $user_=User::where('id','=',$user_id)->first();

   // $tasks=Task::where('user_id','=',$user_id)->where('cancelled','=',0)->get();


        $data=array(
            'title'=>'Tasks for '.$user_->fullname(),
                     'user'=>$user_,
            'roles'=>Role::all(),
            'users'=>User::all(),
            'user_id'=>$user_id,
            'bugun'=>$this->tarihFormat(date('Y-m-d H:i:s')));

        return view('themes.' . static::$tf . '.manager.task.timeline', $data);

    }////timeline

    public function show_timeline($user_id=0,$status=0,$start_at=0,$end_at=0,$priority=0){

        $start_at=(!empty($start_at))? Carbon::parse($start_at)->format('Y-m-d H:i:s'):Carbon::parse(date('Y-m-d H:i:s'))->addDay(-10);
        $end_at=(!empty($end_at))? Carbon::parse($end_at)->format('Y-m-d H:i:s'):Carbon::parse($start_at)->addDay(1);


        if($end_at<=$start_at){
            $end_at=Carbon::parse($start_at)->addDay(7);
        }

        $user_id=($user_id)?$user_id:'all';
        $userId=(int)$user_id;

        if($user_id=='all'){
            $userArray=User::all()->pluck('id')->toArray();

        }elseif($userId==0){
            $role=Role::where('name','=',$user_id)->first();
            $userArray=RoleUser::where('role_id','=',$role->id)->pluck('user_id')->toArray();
        }else{
            $userArray=[$userId];
        }
        $cancelled=0;

        if($status && $status!=5){
            $tasks=Task::UserSelect($userArray)->TaskStatus([3])->CancelStatus(0)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }elseif ($status==5){//cancelled tasks
            $cancelled=1;
            $tasks=Task::UserSelect($userArray)->CancelStatus(1)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }else{///open tasks
            $tasks=Task::UserSelect($userArray)->TaskStatus([1,2])->CancelStatus(0)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }



        $data=[

            'start_day'=>Carbon::parse($start_at)->format('Y,m,d'),
            'dates'=>$start_at." - ".$end_at,
            'tasks'=>$tasks,
            'cancelled'=>$cancelled,
            'user_id'=>$user_id,
            'priority_images' => array('', 'low.png', 'medium.png', 'high.png'),
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'status' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done'))

        ];

        return view('themes.' . static::$tf . '.manager.task.show_timeline', $data);

    }

    public function show_tasks($user_id=0,$status=0,$start_at=0,$end_at=0,$priority=0){


        $start_at=(!empty($start_at))? Carbon::parse($start_at)->format('Y-m-d H:i:s'):Carbon::parse(date('Y-m-d H:i:s'))->addDay(-10);
        $end_at=(!empty($end_at))? Carbon::parse($end_at)->format('Y-m-d H:i:s'):Carbon::parse($start_at)->addDay(1);

        $user_id=($user_id)?$user_id:'all';
        $userId=(int)$user_id;

        if($user_id=='all'){
            $userArray=User::all()->pluck('id')->toArray();

        }elseif($userId==0){
            $role=Role::where('name','=',$user_id)->first();
            $userArray=RoleUser::where('role_id','=',$role->id)->pluck('user_id')->toArray();
        }else{
            $userArray=[$userId];
        }
        $cancelled=0;

      ///  echo "<hr>".$start_at."-----".$end_at."<hr>";

        if($status && $status!=5){
            $tasks=Task::UserSelect($userArray)->TaskStatus([$status])->CancelStatus(0)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }elseif ($status==5){//cancelled tasks
            $cancelled=1;
            $tasks=Task::UserSelect($userArray)->CancelStatus(1)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }else{///open tasks
            $tasks=Task::UserSelect($userArray)->TaskStatus([1,2])->CancelStatus(0)->where('start_at','>=',$start_at)->where('start_at','<=',$end_at)->SelectPriority($priority)->get();
        }









        $data=[
            'dates'=>$start_at." - ".$end_at,
            'tasks'=>$tasks,
            'cancelled'=>$cancelled,
            'user_id'=>$user_id,
            'priority_images' => array('', 'low.png', 'medium.png', 'high.png'),
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'status' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done'))

        ];

        return view('themes.' . static::$tf . '.manager.task.show_tasks', $data);

    }

    public function create(Request $request,$start_date=0,$user_id=0)
    {

       $user_id=(!empty($user_id))?$user_id:\Auth::id();
        $start_date=(!empty($start_date)) ? $this->tarihYap($start_date): \Carbon\Carbon::parse(date('Y-m-d H:i'));
        $allArray=Role::pluck('name');

        $start_date=Carbon::parse($start_date)->format("d-m-Y H:i");

        if ($request->isMethod('post')) {

            $rules = [
            //    'modal_user_id'=>'required',
                'task_title' => 'required',
                'task_description' => 'required',
                'priority' => 'required',
                'status' => 'required',
            ];
            $this->validate($request, $rules);


            \DB::transaction(function () use ($request,$start_date,$allArray) {

                $info="";
                $start_at=  Carbon::parse($request->start_at)->format('Y-m-d H:i:s');
                $end_at=($request->end_at)? Carbon::parse($request->end_at)->format('Y-m-d H:i:s') : Carbon::parse($start_at)->addHour(1);
                $reminder=($request->reminder)? Carbon::parse($request->reminder)->format('Y-m-d H:i:s') : Carbon::parse($start_at)->addDay(1);
                $userArray=(!empty($request->input('modal_user_id')))?$request->input('modal_user_id'):array();

                $sentUsers=User::whereIn('id',$userArray)->get();


                if(count($sentUsers)){
                    $info.=__('tasks.sent_to_users',['number'=>count($sentUsers)])." , ";
                }



                foreach ($allArray as $value){
                    $hidden_id='all_'.$value;
                    if($request->$hidden_id){
                        $info.=__('tasks.sent_all',['value'=>$value])." , ";

                        $role=Role::where('name','=',$value)->first();
                        $user_array=RoleUser::where('role_id','=',$role->id)->pluck('user_id')->toArray();
                        $userArray=array_merge($userArray,$user_array);
                    }
                }


                $newTask = new Task();
                $newTask->created_by =  \Auth::id();
                $newTask->task_title = $request->task_title;
                $newTask->task_description = $request->task_description;
                $newTask->priority = $request->priority;
            //  $newTask->status = $request->status;
                $newTask->start_at =  $start_at ;
                $newTask->reminder = $reminder;
                $newTask->info = $info;
                $newTask->end_at = $end_at;
            //  $newTask->cancelled = 0;
                $newTask->updated_by = 0;
                $newTask->send_email = $request->inform;
                $newTask->additional_email = $request->additional_email;
                //$newTask->date = Carbon::parse($request->task_date)->format('d-m-Y');// Carbon::parse($request->task_date)->format('d-m-Y');
                $newTask->save();



                $sentArray=array();
                $i=0;
                foreach($userArray as $user){
                if(!in_array($user,$sentArray)){

                    $taskUser= new TaskUserPivot();
                    $taskUser->task_id=$newTask->id;
                    $taskUser->user_id=$user;
                    $taskUser->status=$request->status;
                    $taskUser->cancelled=0;
                    $taskUser->save();


                    $sentArray[$i]=$user;
                    $i++;

                    }
                }


                $data="data data data";

            /*    Mail::send('emails.welcome', $data, function ($message) {
                    $message->from('orange.tech.email@gmail.com', 'Laravel');

                    $message->to('ulaskorpe@gmail.com')->cc('ulash6@yahoo.com');
                });*/

                if($request->inform){

                    $email="";

                    $users=User::whereIn('id','sentArray')->get();
                    foreach ($users as $user){

                    }

                    $additional_array=(!empty($request->additional_email))?explode(';',$request->additional_email):[];
                    foreach ($additional_array as $add){


                    }

                }

            });

            return 'ok';
        }////post



        $data=[
            'end_at'=>\Carbon\Carbon::parse($start_date)->addHour(1)->format("d-m-Y H:i"),
            'reminder'=>\Carbon\Carbon::parse($start_date)->addDay(1)->format("d-m-Y H:i"),
            'users'=>User::all(),
            'user_id'=>$user_id,
            'start_at'=>$start_date,
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'status' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done')),
            'all_array'=>$allArray

        ];


        return view('themes.' . static::$tf . '.manager.task.create', $data);
    }


    public function drag_task($task_id=0,$start_date=0,$end_date=0){


    if($task_id){
    $start_date=Carbon::parse($this->tarihYap($start_date))->format('Y-m-d H:i:s');
    $end_date=Carbon::parse($this->tarihYap($end_date))->format('Y-m-d H:i:s');
    $task=Task::find($task_id);
    $task->start_at=$start_date;
    $task->end_at=$end_date;
    $task->save();
    }

       // return $task_id.":"..":".Carbon::parse($end_date)->format("Y-m-d H:i:s");
    }

    public function edit(Request $request,$id)
    {
        //$task  =  Task::find($id);

      if($id<1000000000000){
        $task=Task::with( 'created_by','task_user')->where('tasks.id','=',$id)->first();
        //$users=User::whereIn('id',TaskUserPivot::where('task_id','=',$id)->pluck('user_id')->toArray())->get();
        $users=User::all();
        $userArray=TaskUserPivot::where('task_id','=',$id)->pluck('user_id')->toArray();
        if ($request->isMethod('post')) {
            $rules = [
                'task_title' => 'required',
                'task_description' => 'required',
                'priority' => 'required',

            ];
            $this->validate($request, $rules);
            \DB::transaction(function () use ($request,$task) {
                $start_at= Carbon::parse($request->start_at)->format('Y-m-d H:i:s');
                $end_at=($request->end_at)? Carbon::parse($request->end_at)->format('Y-m-d H:i:s') : Carbon::parse($start_at)->addHour(10)->format('Y-m-d H:i:s');
                $reminder=($request->reminder)? Carbon::parse($request->reminder)->format('Y-m-d H:i:s') : Carbon::parse($start_at)->addDay(1)->format('Y-m-d H:i:s');
                $task->task_title = $request->task_title;
                $task->task_description = $request->task_description;
                $task->priority = $request->priority;
                $task->start_at =$start_at;
                $task->end_at = $end_at;
                $task->reminder =$reminder;

                $task->save();
            //    TaskUserPivot::where('task_id','=',$task->id)->where('user_id','=',$user_id)->update(['status'=>$request->status]);
            });

            return 'ok';
        }////post

        $data=[
            'task'=>$task,
            'end_at'=>$task->end_at,
            'reminder'=>$task->reminder,
           'users'=>$users,
           'userArray'=>$userArray,
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'status' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done'))
        ];
        return view('themes.' . static::$tf . '.manager.task.update', $data);

      }else{

      }
    }


    public function user_status($task_id=0,$status=0){
        $task=Task::find($task_id);
        if($status==0){
            $users=TaskUserPivot::with('user')->where('task_id','=',$task_id)->where('cancelled','=',0)->get();
        }elseif ($status==5){ ///cancelled
            $users=TaskUserPivot::with('user')->where('task_id','=',$task_id)->where('cancelled','=',1)->get();
        }else{
            $users=TaskUserPivot::with('user')->where('task_id','=',$task_id)->where('cancelled','=',0)->where('status','=',$status)->get();
        }

        $data=[
            'task'=>$task,
            'users'=>$users,
            'status'=>$status,
            'priority_images' => array('', 'low.png', 'medium.png', 'high.png'),
            'priority' => array('',__('Tasks.low'),__('Tasks.medium'),__('Tasks.high')),
            'status_array' => array('',__('Tasks.to-do'),__('Tasks.in-progress'),__('Tasks.done'))
        ];
        return view('themes.' . static::$tf . '.manager.task.user_status', $data);
    }


    public function findUser($user_id=0){
        $userId=(int)$user_id;

        if($userId>0){
        $user=User::find($userId);
        return "<h4 class='card-title'>".__('tasks.tasks',['name'=>$user->fullname()])."</h4>";
        }else{
            return "<h4 class='card-title'>".$user_id." Tasks</h4>";
        }

    }

    public function cancel(Request $request)
    {

        TaskUserPivot::where('task_id','=',$request["task_id"])
            ->update(
                ['cancelled'=>1 ,
                 'cancel_reason'=>$request['cancel_reason'] ? $request['cancel_reason'] : __('tasks.none')
                ]);

        return response("ok", 200);


    }

    public function update_done(Request $request)
    {
        TaskUserPivot::where('task_id','=',$request["task_id"])->where('user_id','=',$request["user_id"])->update(['status'=>3]);
        return response("ok", 200);
    }


    public function taskProcess(Request $request){
        $msg='';
        $start_date=$this->tarihYap($request->start_date);
        $end_date=$this->tarihYap($request->end_date);

        $user=User::find($request->user_id);
        //$start_date=Carbon::parse($gelenler->input('start_date'))->format('Y-m-d');
        ///$start_date= Carbon::createFromFormat('Y-m-d', $request->$gelenler->input('start_date'));//$gelenler->input('start_date');
        ///Object { start_date: Date 2017-07-12T07:50:00.000Z, end_date: Date 2017-07-12T10:20:00.000Z, text: "vfggfg", id: 1500212849900, _timed: true, _sday: 2, _inner: false, _sorder: 0, _count: 1, ex: "added" }

        if( $start_date < Carbon::now()){
         ///   return ['msg'=>'date cant be before NOW','hata'=>true];
        }

        $valuesArray = $this->findTaskValues($request->text);
        $task_description = $valuesArray['text'];
        $priority = $valuesArray['priority'];
        $status = $valuesArray['status'];

        if($request->input('ex')=='added'){



            $task= new Task();
            $task->task_title = Carbon::parse($start_date)->format('d-m-Y H:i')." dated task";
            $task->task_description=$task_description;
            $task->priority = $priority;
            $task->status = $status;

          //  $task->start_at=Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        ///   $task->end_at=Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
            $task->start_at=$start_date;
            $task->end_at=$end_date;
            $task->reminder= Carbon::parse($start_date)->addDay(1)->format('Y-m-d H:i:s');
            $task->user_id=$request->user_id;
            $task->created_by = \Auth::id();
            $task->save();


            $msg=Carbon::parse($start_date)->format('Y-m-d H:i')." task added for ".$user->fullname();

         //   echo Carbon::parse($start_date)->addDay(1)->format('Y-m-d H:i:s');

        }else if($request->input('ex')=='changed'){
        if(!empty($request->id)){
            $task=Task::find($request->id);
            $task->task_description=$task_description;
            $task->priority = $priority;
            $task->status = $status;
            $task->start_at=Carbon::parse($start_date)->format('Y-m-d H:i:s');
            $task->end_at=Carbon::parse($end_date)->format('Y-m-d H:i:s');
            $task->save();

            $msg= 'Task updated to '.$start_date.' - '.$end_date." for ".$user->fullname();
        }else{
            $msg="Nothing?";
        }
        }else if($request->input('ex')=='deleted'){

            if(!empty($request->id)){
             $task=Task::find($request->id);
             $task->cancelled=1;
             $task->save();
             $msg=  $task->task_title.' task cancelled for '.$user->fullname();
            }else{
                $msg="Nothing?";
            }
        }else{
            $msg="Undefined Process";
        }
        //dd($gelenler->all());
        return [ 'msg'=>$msg,'hata'=>false];

    }

    private function findPriority($value){
        $value=str_replace("-","",strtolower(trim($value)));

        if(empty($value)){
            return 3;
        }
        $priorityValues = ["","low","medium","high"];
        if(in_array($value,$priorityValues)){
            return array_search($value,$priorityValues);
        }else{
            return 3;
        }
    }

    private function findsStatus($value){
        $value=str_replace("-","",strtolower(trim($value)));
        if(empty($value)){
            return 1;
        }
        $statusValues = ["","todo","inprogress","done"];
        if(in_array($value,$statusValues)){
            return array_search($value,$statusValues);
        }else{
            return 1;
        }
    }

    private function findTaskValues($value){


        $explodeArray = explode("|",$value);

        $valuesArray['text'] = (!empty($explodeArray[0]))?trim($explodeArray[0]):'';
        $valuesArray['priority'] = (!empty($explodeArray[1]))?$this->findPriority($explodeArray[1]):3;
        $valuesArray['status'] = (!empty($explodeArray[2]))?$this->findsStatus($explodeArray[2]):1;

        return $valuesArray;
    }

}
