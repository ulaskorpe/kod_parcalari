<?php

                for($i=0;$i<100;$i++){
                  $driverDizi[$i]=rand(1,300);
                }
                //$driverDizi=[1,3,5,6,8,13,15,13,11,15,2,3,55,45,13,31,12,1,7,];

                $i=0;
                $date=Carbon::now()->format('d-m-Y H:i');
                foreach ($driverDizi as $driver_id){
                        $yeni_driver=Driver::with('user')->where('id','=',$driverDizi[$i])->first();


                    $Log = new DriverVehicleAssignmentLog();
                    $Log["vehicle_id"] =1;

                    if(!empty($driverDizi[$i-1])){
                        $eski_driver=Driver::with('user')->where('id','=',$driverDizi[$i-1])->first();
                        $Log["old_driver_id"] = $eski_driver->id;
                        $Log["old_driver_name"] = $eski_driver->user->fullname();

                    }else{
                        $Log["old_driver_id"] = 0;
                        $Log["old_driver_name"] = "";

                    }

                    $Log["driver_id"] = $yeni_driver->id;
                    $Log["driver_name"] = $yeni_driver->user->fullname();
                    $Log["date_time"] = Carbon::parse($date)->format('d-m-Y H:i');
                    $Log->save();
                    $date=Carbon::parse($date)->addDay();
                    $i++;
                }

?>