  public function getAddress( )
    {




               //$faker = \Faker\Factory::create();
        $ch = curl_init();
        for($j=0;$j<500;$j++){

            echo $j."<hr>";
                    $place="Adana"; //$faker->city;

                $link ="https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$place."&key=".env('GOOGLE_API_KEY');
                curl_setopt($ch, CURLOPT_URL, $link);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $addresses = curl_exec($ch);


                $addresses=json_decode($addresses);
                //$adresArray=array();
                $k=0;
                foreach ($addresses->predictions as $address){
                    echo $address->description."<br>";
//                    $adresArray[$k]=array('place_id'=>$address->place_id,'lat'=>'40.991649','lon'=>'28.713542','address'=>$address->description);
//                        $k++;
//                    $formatted_tags[] = ['id' => $address->place_id, 'text' =>   ucfirst($address->description)];
//                    $i++;
                }
        }
        curl_close($ch);

                return "ok";

    }
