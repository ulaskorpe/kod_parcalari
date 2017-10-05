  public function isManager($company_id,$client_id){

        $isManager=ClientCompanyPivot::with('client_company_department')->whereHas('client_company_department',function($q){
            $q->where('is_management','=',1);
        }) ->where('client_company_id', '=', $company_id)->where('client_id','=',$client_id)->first();


        /*     $isManager=ClientCompanyPivot::where('client_company_department_id','=',function($q) use ($company_id)
             {
                 $q->from('client_company_departments')
                     ->selectRaw('id')
                     ->where('client_company_id', '=', $company_id)
                     ->where('is_management','=',1);
             }
             )->where('client_id','=',$client_id)
                 ->where('authorized','=',1)->get();*/

        return (count($isManager)) ? true : false ;

    }