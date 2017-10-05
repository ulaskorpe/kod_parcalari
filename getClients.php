<?
    public function getClients($company_id = 0, $department_id = 0)
    {
        $key = __('orders.select_client');
        if ($company_id) {
            $company = ClientCompany::find($company_id);

            if ($department_id) {
                $department = ClientCompanyDepartment::find($department_id);
                $key .= " (" . $company->company_name . "-" . $department->department_name . ")";

                $clientArray = ClientCompanyPivot::where('client_company_id', '=', $company_id)->where('client_company_department_id', '=', $department_id)
                    ->pluck('client_id')->toArray();
                $clients = Client::with('user')->whereIn('id', $clientArray)->get();

            } else {////company only
                $key .= " (" . $company->company_name . ")";
                $clientArray = ClientCompanyPivot::where('client_company_id', '=', $company_id)->pluck('client_id')->toArray();
                $clients = Client::with('user')->whereIn('id', $clientArray)->get();
            }
        } else {
            $clients = Client::with('user')->get();
        }

        $html = "<option value=''> " . $key . " </option>";

        foreach ($clients as $client) {
            $html .= "<option value='" . $client->id . "'> " . $client->user->fullname() . " </option>";
        }
        return $html;
    }

?>