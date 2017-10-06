<?php

public function templateassign(Request $gelenler)
{

    /*1  override  2  leave*/

$userWorkTemplate=new UserWorkTemplate();
    $userWork=new UserWork();



     $userWorkTemplates=$userWorkTemplate->where('user_id','=',$gelenler->user_id)->get();
     $dizi=array();

     foreach ($userWorkTemplates as $temp){
      $dizi[$temp->week_day]=array('description'=>$temp->description,'start_at'=>$temp->start_at,'end_at'=>$temp->end_at);

     }



    $basla=Carbon::parse($gelenler->input('start_at'))   ;
    $bitis=Carbon::parse( $gelenler->input('end_at')) ;

    $length = $bitis->diffInDays($basla);

 while($basla<=$bitis){
     $wd=(($basla->dayOfWeek+1)>6)?($basla->dayOfWeek):($basla->dayOfWeek);
     $gun = $basla->format('Y-m-d');

//'2017-07-20 14:55:00';//


     //$start_at= Carbon::parse($gun.' '.$dizi[$wd]['start_at']) ;
     //$end_at =Carbon::parse( $gun.' '.$dizi[$wd]['end_at']) ;

     if(!empty($dizi[$wd])) {

         $start_at=$gun.' '.$dizi[$wd]['start_at'];
         $end_at=$gun.' '.$dizi[$wd]['end_at'];
         $varmi = $userWork->where('user_id', '=', $gelenler->user_id)->whereBetween('start_at', [$start_at, $end_at])->first();
         $varmi2 = $userWork->where('user_id', '=', $gelenler->user_id)->whereBetween('end_at', [$start_at, $end_at])->first();
         if (!empty($varmi->id) || !empty($varmi2->id)) {

             $id = (!empty($varmi->id)) ? $varmi->id : $varmi2->id;
             if ($gelenler->override == 1) {
                 //// echo "silinecek";
                 $userWork->where('user_id', '=', $gelenler->user_id)->whereBetween('start_at', [$start_at, $end_at])->delete();
                 $userWork->where('user_id', '=', $gelenler->user_id)->whereBetween('end_at', [$start_at, $end_at])->delete();
                 $userWork = new UserWork;
                 $userWork->start_at = $start_at;
                 $userWork->end_at = $end_at;
                 $userWork->user_id = $gelenler->user_id;
                 $userWork->description = $dizi[$wd]['description'];
                 $userWork->save();



             } else {
                 /// echo "duracak";
             }
             //  echo "[var".$varmi2->description.':'.$varmi2->id.':'.$varmi2->start_at.':'.$varmi2->end_at."]<br>";
         } else {

             $userWork = new UserWork;
             $userWork->start_at = $start_at;
             $userWork->end_at = $end_at;
             $userWork->user_id = $gelenler->user_id;
             $userWork->description = $dizi[$wd]['description'];
             $userWork->save();



         }
         //  echo $start_at.' EnD'. $end_at.': DESC' .$dizi[$wd]['description']."<br>";
         /// echo $gun.':'.$wd."<br><hr>";

     }else{////güne temp atanmamış


     }///!empty
       //$sonra=$now->startOfWeek()->addDay($i)->format('Y/m/d');
      $basla=$basla->addDay(1);

     //dd($start_at);
    }///while

    //'manager.department.workweekly'
   return redirect()->route('manager.department.workweekly',array('user_id'=>$gelenler->input('user_id')));

//return "ok";
}//////assign template
?>