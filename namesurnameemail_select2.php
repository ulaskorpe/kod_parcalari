<?php

  private function NameSurnameEmail($model, $term,$params=null)
    {
        if (empty($term)) {
            return \Response::json([]);
        } else {

            $x="A";
            if(isset($params)){

                $x=$params;
               $params = json_decode($params);


            }//{"company_id":"3","department_id":"11"}



            if(isset($params->company_id)){
                if(isset($params->department_id)){
                    $userArray=ClientCompanyPivot::where('client_company_id','=',$params->company_id)
                        ->where('client_company_department_id','=',$params->department_id)->pluck('client_id')->toArray();


                }else{
                    $userArray=ClientCompanyPivot::where('client_company_id','=',$params->company_id)->pluck('client_id')->toArray();
                }


                $tags = $model::with("user")->whereIn('id',$userArray)
                     ->search($term)
                    ->limit(5)->get();

            }else{/////params->company_id
                ///
            $tags = $model::with("user")
                ->search($term)
                ->limit(5)->get();

            }
            $formatted_tags = [];
            foreach ($tags as $tag) {
                $formatted_tags[] = ['id' => $tag->id, 'text' => $x." :".ucfirst($tag->user->name . " " . $tag->user->last_name) . " (" . $tag->user->email . ")"];
            }

            return $formatted_tags;
        }
    }
?>