   <?php
$table->integer('updated_by')->nullable()->default(0);

UserInfo::                   observe(UserInfoObserver::class);


    public function lastUpdated()
    {
        return $this->belongsTo(\App\User::class, 'updated_by', 'id');
    }

           ?>


            <div class="card-header">

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title"><i class="icon-head"></i> {{__('personel_form.title')}}{{$user->name.' '.$user->last_name}} </h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    </div>
                    <div class="col-md-2">
                        @if(!empty($user_info->updated_by))
                            ( {{__('drivers_companies.last_updated_by',['name'=>$user_info->lastUpdated->fullname()])}} )
                        @endif
                    </div>

                    <div class="col-md-4">

                        <a href="{{ route('manager.department.files', $user->id) }} ">
                            <button type="button" class="btn btn-green"><i class="icon-file white"></i>
                                {{__('personel_form.personel_files')}}
                            </button>
                        </a>

                    </div>

                </div>


            </div>           