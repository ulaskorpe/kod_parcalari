'params'=>	


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
                                                    "description"=>__('department.description')
                                                    ,"document"=>   __('Department.document')
                                                    ,"date"=>__('department.date')
                                                    ,"actions"=>__("Expenses.table_expense_actions")
                                                     ]
                                       ])



 @foreach(\Enum\TaskPriorities::getListUcfirst() as $key=>$string)
                                            <option value="{{$key}}" @if(old('priority')==$key) selected @endif>{{__('Tasks.priority_'.$string)}}</option>
                                        @endforeach