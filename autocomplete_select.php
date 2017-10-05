<?
            if(isset($params->company_id)){

                $user=User::find(Auth::id());
                if($user->hasRole('manager')){/////
                    $clientArray=ClientCompanyPivot::where('client_id','!=',$params->client)
                 ->where('client_company_id','=',$params->company_id)->pluck('client_id')->toArray();
                }else if($this->isManager($params->company_id,Auth::id())) {

                    if ($$params->department_id) {
                        $clientArray = ClientCompanyPivot::where('client_id', '!=', $params->client)->where('client_company_id', '=', $params->company_id)
                            ->where('client_company_department_id', '=', $params->department_id)->pluck('client_id')->toArray();
                    }
                }///////is manager_?
?>