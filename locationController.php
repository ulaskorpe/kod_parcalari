<?php

<?php

namespace App\Http\Controllers\Common\Location;

use App\Helpers\DepartmentHelper\DepartmentHelper;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LocationController extends Controller
{
    public function getCoordinates($placeid=0,$getCoordinates=false){
        $location = Location::where('place_id','=',$placeid)->first();
        if(empty($location->id)){

        if($getCoordinates){

            $ch = curl_init();
            $link ="https://maps.googleapis.com/maps/api/place/details/json?placeid=".$placeid."&key=".env('GOOGLE_API_KEY');
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $addresses = curl_exec($ch);
            curl_close($ch);
            $addresses=json_decode($addresses);

            return  json_encode(['lat'=>$addresses->result->geometry->location->lat,'lon'=>$addresses->result->geometry->location->lng]);
        }else{
            return  json_encode(['lat'=>0,'lon'=>0]);
        }
        }else{
            return  json_encode(['lat'=>$location->lat,'lon'=>$location->lon]);
        }
    }

    public function getGeocode($placeid=0,$address=null){

        $location = Location::where('id','=',$placeid)->first();
        if(empty($location) && !empty($address)){
             $location=Location::search($address,null,true,true)->limit(1)->first();
        }


        if(empty($location->id)){
            $link="https://maps.googleapis.com/maps/api/geocode/json?address=".DepartmentHelper::fixetiket($address);
            $jsonData   = file_get_contents($link);
            $data = json_decode($jsonData);

            if($data->status=="OVER_QUERY_LIMIT"){
                $link="https://maps.googleapis.com/maps/api/geocode/json?address=".DepartmentHelper::fixetiket($location->address)."&key=".env('GOOGLE_API_KEY');
                $jsonData= file_get_contents($link);
                $data = json_decode($jsonData);
            }



           if($data->{'status'}!="ZERO_RESULTS"){

            try{
            $location = Location::where('place_id','=',$data->{'results'}[0]->{'place_id'})->first();
            if(empty($location->id)){

                $address=(!empty($address))?$address:$data->{'results'}[0]->{'formatted_address'};
                $new = new Location();
                $new->place_id=$data->{'results'}[0]->place_id;
                $new->lat=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $new->lon=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $new->address=$address;
                $new->geocode = json_encode($data->{'results'});
                $new->save();

                //$geoCode =  $new->geocode ;
                //dd($new);
                //$geoCode=str_replace("\\","",$geoCode);
                return  $new->geocode;//substr($geoCode,1,strlen($geoCode)-2);

            }else{///güncelle
                ///
                $address=(!empty($address))?$address:$data->{'results'}[0]->{'formatted_address'};
                $location->lat=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $location->lon=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $location->address=$address;
                $location->geocode = json_encode($data->{'results'});
                $location->save();
                return  $location->geocode;
              /*  $geoCode = json_decode($location->geocode);

                $geoCode=str_replace("\\","",$geoCode);
                return  substr($geoCode,1,strlen($geoCode)-2);*/
            }

            $geoCode =  json_encode($data->{'results'});

            }catch ( \Exception $e){
            ///  echo $e->getMessage();
             }
             //   return $geoCode;//ztn string
            }else{
                return null;

            }
        }else{

            if((strlen($location->geocode)<3)||(($location->lat+$location->lon)==0)){///var ama geocode yok
                $link="https://maps.googleapis.com/maps/api/geocode/json?address=".DepartmentHelper::fixetiket($location->address);
                $geoCode= file_get_contents($link);
                $data = json_decode($geoCode);
                if($data->status="OVER_QUERY_LIMIT"){
                $link="https://maps.googleapis.com/maps/api/geocode/json?address=".DepartmentHelper::fixetiket($location->address)."&key=".env('GOOGLE_API_KEY');
                $geoCode= file_get_contents($link);
                $data = json_decode($geoCode);
                 }

                $geoCode=json_encode($data->{'results'});

               if($data->{'status'}!="ZERO_RESULTS"){
                $location->lat=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $location->lon=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $location->geocode= json_encode($data->{'results'});
                $location->save();
                }


            }

            $geoCode= json_encode($location->geocode);


        }

        if(substr($geoCode,0,1)=="\""){
            $geoCode=str_replace("\\","",$geoCode);
            return  substr($geoCode,1,strlen($geoCode)-2);
        }else{
            return $geoCode;
        }
    }
////arrays for seeder//////
    public function getLocations(){

        $locations=Location::all();
        $code="[";
        $lat="[";
        $lon="[";
        $address="[";

        foreach ($locations as $location){
            $code.="'".$location->place_id."',";
            $lat.="'".$location->lat."',";
            $lon.="'".$location->lon."',";
            $address.="'".$location->address."',";


        }
        $code.="0]";
        $lat.="0]";
        $lon.="0]";
        $address.="0]";

        echo $code.";<br>";
        echo $lat.";<br>";
        echo $lon.";<br>";
        echo $address.";<br>";
    }

    public function fillgeocodes(){

        $locations = Location::all();
        foreach ($locations as $location){

           if((strlen($location->geocode)<3)||(($location->lat+$location->lon)==0)){///var ama geocode yok

               echo $location->address."<br>";
               $geoCode=$this->getGeocode($location->place_id);
               echo "[".$geoCode."]";

               /*
                     $data= json_decode($geoCode);
                 if($data->{'status'}!="ZERO_RESULTS") {
                     $location->lat=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                     $location->lon=$data->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                     $location->geocode=$geoCode;
                     $location->save();
                 }else{
                     echo $location->address . " : yok";
                 }*/
             }

        }

    }

    public  static function getAddress($placeId){


        $location = Location::where('id','=',$placeId) ->first();

        //$location = json_decode($location);

        return (!empty($location->id))? json_encode($location):null;
    }
}


?>