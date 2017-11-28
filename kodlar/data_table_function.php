<?php

   private function ClientOperatorLogs(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query, $params_json = null)
    {
        $params = json_decode($params_json);


   		$order_by = ($order_by != null) ? $order_by : "operator_logs.created_at";
        $asc_desc = ($asc_desc != null) ? $asc_desc : "desc";


        if (!empty($keyword_query) && $keyword_query != "") {
            $data = $model::search((string)$keyword_query, null, true)
                ->leftJoin("users", "users.id", $table . ".created_by")
                ->where($table . ".client_id", '=', $params->client_id)
                ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                    , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                        . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                    , "operator_logs.operator_log"
                    , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                ->paginate($page_count);
        } else {
            if ($order_by != null){
                $data = $model::leftJoin("users", "users.id", $table . ".created_by")
                    ->where($table . ".client_id", '=', $params->client_id)
                    ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                        , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                        , "operator_logs.operator_log"
                        , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);
            }

            else{
                $data = $model::leftJoin("users", "users.id", $table . ".created_by")
                    ->where($table . ".client_id", '=', $params->client_id)
                    ->select(DB::raw("CONCAT(users.name,' ',users.last_name) AS operator_name")
                        , DB::raw("(CASE WHEN operator_logs.operator_log_type_id=" . OperatorLogTypes::Note . " THEN 'Note' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Action . " THEN 'Action' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Issue . " THEN 'Issue' "
                            . "WHEN operator_logs.operator_log_type_id= " . OperatorLogTypes::Warning . " THEN 'Warning' ELSE '' END) as operator_log_type")
                        , "operator_logs.operator_log"
                        , DB::raw('DATE_FORMAT(operator_logs.created_at, "%d-%m-%Y  %H:%i:%s") as log_date'))
                    ->orderBy(, )
                    ->paginate($page_count);
            }

        }
        return $data;

    }

?>