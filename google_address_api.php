<?php

 $ch = curl_init();
        $link ="https://maps.googleapis.com/maps/api/place/autocomplete/json?input=eskişe&key=".env('GOOGLE_API_KEY');
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $addresses = curl_exec($ch);
        curl_close($ch);
        $addresses=json_decode($addresses);
        $locations=array();
        $i=0;

        foreach ($addresses->predictions as $address){

            echo $address->place_id.":".$address->description."<br>";


            $i++;
        //    echo $address->predictions->description."<br>";
        }

     

         dd($addresses);

 
?>
https://maps.googleapis.com/maps/api/place/autocomplete/json?input=eskişeh&key=AIzaSyCs04NeB3LlmwXTJ1m1q3aF4qmKURYAOcM 
 //// get address
https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJXw4MIgg-zBQRCJoEOFk5ibw&key=AIzaSyCs04NeB3LlmwXTJ1m1q3aF4qmKURYAOcM 
 /// get coordinates


 {"lat":39.64829719999999,"lon":30.5739579