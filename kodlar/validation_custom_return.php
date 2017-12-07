  if(!empty($request->additional_email)){

                $additional = str_replace(" ",";",str_replace(",",";",$request->additional_email));

                $additional_array = (!empty($additional)) ? explode(';', $additional) : [];
                foreach ($additional_array as $add) {
                    if(!$this->isValidEmail($add)){
                        $data['message'] = $add." is not a valid email address";
                        //$rules= array_merge($rules, [$add=>'required']);
                        return response($data, 422);
                    }
                }

            }




                                    @role('driver')
                                    @include("components.multiple_select2",[
                                      "id"=>"modal_user_id"
                                      ,"name"=>"modal_user_id",
                                      "autocomplete_url"=>"/common/autocomplate/select2"
                                      ,"modelname"=>\App\User::class
                                      ,"functionname"=>"DriverUser"
                                      ])
                                    @endrole