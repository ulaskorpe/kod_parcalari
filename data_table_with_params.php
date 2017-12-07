<?php
////controllerdan giden 
return view('themes.' . static::$tf . '.manager.personnel.files.index', ['user_id' => $user_info->user_id, 'user' => $user, 'params' => json_encode(['user_id' => $user->id])]);



///datatable a gelen
                @include( "components.datatable",
                                       [
                                       "id"=>"user_files"
                                       ,"name"=>"user_files"
                                       ,"datatable_url"=>"/common/datatable/main"
                                       ,"modelname"=>\App\Models\UserFile::class
                                       ,"tablename"=>"user_files"
                                       ,"params_json"=>$params
                                       ,"functionname"=>"UserFiles"
                                       ,"buttons"=>"components.buttons_user_files"
                                                    ,"columns"=>[
                                                    "actions"=>__("expenses.table_expense_actions"),
                                                    "description"=>__('department.description')
                                                    ,"document"=>   __('department.document')
                                              //      ,"file_type"=>   __('department.file_type')
                                                    ,"date"=>__('department.date')

                                                     ]
                                       ])




////datatablecontrollerda karşılığını bulan

private function UserFiles(Model $model, $table, $page_count = 10, $order_by = null, $asc_desc = null, $keyword_query = null, $params_json = null)
    {

        $link = '<a href="' . makePrivateFileUrl('#expensedocument#') . '" target="_blank"><i class="icon-outbox"></i><span></span></a>';
        $SQLreplace1 = "REPLACE('" . $link . "', '#expensedocument#',user_files.file)";

        $params = json_decode($params_json);
        $order_by = ($order_by != null) ? $order_by : "id";
        $asc_desc = ($asc_desc != null) ? $asc_desc : "desc";
        $keyword_query = ($keyword_query != null) ? $keyword_query : "";

        if (!empty($keyword_query) && $keyword_query != "") {

            $data = $model::search((string)$keyword_query, null, true)
                ->select('user_files.description', 'user_files.date', 'user_files.id'
                    , DB::raw($SQLreplace1 . " as document")

                )
                ->where('user_id', '=', $params->user_id)
                ->paginate($page_count);
        } else {

            if ($order_by != null) {
                $data = $model:: select('user_files.description', 'user_files.date', 'user_files.id'
                    , DB::raw($SQLreplace1 . " as document")

                )
                    ->where('user_id', '=', $params->user_id)
                    ->orderBy($order_by, $asc_desc)
                    ->paginate($page_count);

            } else {

                $data = $model:: select('user_files.description', 'user_files.date', 'user_files.id'
                    , DB::raw($SQLreplace1 . " as document")

                )
                    ->where('user_id', '=', $params->user_id)
                    ->paginate($page_count);
            }

        }
        return $data;
    }

?>

 @foreach(\Enum\TaskPriorities::getListUcfirst() as $key=>$string)
                                            <option value="{{$key}}" @if(old('priority')==$key) selected @endif>{{__('Tasks.priority_'.$string)}}</option>
                                        @endforeach