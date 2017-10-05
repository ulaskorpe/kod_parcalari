<?php

    public function process(Request $gelenler)
    {

        $userInfo = new UserInfo();
        $user = new User();

        $messages = [];

        $kontrol = Validator::make($gelenler->all(), array(
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'svnr' => 'required|numeric',
            'licensenumber' => 'required|numeric',
            'license_date' => 'required|date',
            'phone_number_country_code' => 'required|numeric',
            //'phone_number'=>'required|numeric',
            'email' => 'required|email',
            'photo' => 'image'
            //'description' => 'required'
        ), $messages);

         if ($kontrol->fails()) {

            if (empty($gelenler->input('user_id'))) {

                return redirect()->route('manager.department.create', array('role_id' => $gelenler->input('role_id')))->withErrors($kontrol)->withInput();
            } else {
                return redirect()->route('manager.department.edit', array('user_id' => $gelenler->input('user_id')))->withErrors($kontrol)->withInput();
            }

        } else {////hata yok

             

            $admin_right = (!empty($gelenler->admin_right)) ? 1 : 0;
            $work_right = (!empty($gelenler->work_right)) ? 1 : 0;

            if (empty($gelenler->input('user_id'))) {/////insert
                /*$id = DB::table('users')->insertGetId(
                    ['email' => 'john@example.com', 'votes' => 0]
                );*/
                $phone_number = $gelenler->input('phone_number_country_code')."-".$gelenler->input('phone_number');

                $user = new User;

                $user->name = $gelenler->input('first_name');
                $user->last_name = $gelenler->input('last_name');
                $user->email = $gelenler->input('email');
                $user->password = Hash::make('secret');
                $user->status = 1;
                $user->gsm_phone = $phone_number;
                $user->gender = $gelenler->input('gender');
                $user->birth_date = $gelenler->input('birth_date');
                $role = Role::find($gelenler->input('role_id'));
                $user->attachRole($role);
                $user->save();

                $user_info = new UserInfo;
                $user_info->user_id = $user->id;
                $user_info->svnr = $gelenler->input('svnr');
                $user_info->title = $gelenler->input('title');
                $user_info->license_number = $gelenler->input('licensenumber');
                $user_info->license_date = $gelenler->input('license_date');
                $user_info->classes = $gelenler->input('class_dizi');
                $user_info->languages = $gelenler->input('lang_dizi');
                $user_info->nationality = $gelenler->input('nationality');
                $user_info->residense_permit = $gelenler->input('residense_permit');
                $user_info->residense_permit_ends = $gelenler->input('residense_permit_date');
                $user_info->work_place = $gelenler->input('work_place');
                $user_info->address = $gelenler->input('address');
                $user_info->postal_code = $gelenler->input('postal_code');
                $user_info->comments = $gelenler->input('comments');
                $user_info->gps_color = $gelenler->input('gps_color');
                $user_info->admin_right = $admin_right;
                $user_info->working_right = $work_right;

                $user_info->save();


                $user_info_id = $user_info->id;
                $user_id = $user->id;

                if ($gelenler->input('role_id') == $role->id) {/////driver
                    $driver = new Driver();
                    $driver->user_id = $user_id;
                    $driver->address = $gelenler->input('address');
                    $driver->postal_code = $gelenler->input('postal_code');
                    $driver->save();

                }////driver


            } else {////update


                $user_info = $userInfo->where('user_id', '=', $gelenler->input('user_id'))->first();
                $userInfo->where('user_id', '=', $gelenler->input('user_id'))->update(
                    [
                        'svnr' => $gelenler->input('svnr'),
                        'title' => $gelenler->input('title'),
                        'license_number' => $gelenler->input('licensenumber'),
                        'license_date' => $gelenler->input('license_date'),
                        'classes' => $gelenler->input('class_dizi'),
                        'languages' => $gelenler->input('lang_dizi'),
                        'nationality' => $gelenler->input('nationality'),
                        'residense_permit' => $gelenler->input('residense_permit'),
                        'residense_permit_ends' => $gelenler->input('residense_permit_date'),
                        'work_place' => $gelenler->input('work_place'),
                        'photo' => $user_info->photo,
                        'address' => $gelenler->input('address'),
                        'postal_code' => $gelenler->input('postal_code'),
                        'comments' => $gelenler->input('comments'),
                        'admin_right' => $admin_right,
                        'working_right' => $work_right,
                        'gps_color' => $gelenler->input('gps_color')
                    ]
                );

                $phone_number = $gelenler->input('phone_number_country_code')."-".$gelenler->input('phone_number');

                $user->where('id', '=', $gelenler->input('user_id'))->update(
                    [
                        'email' => $gelenler->input('email'),
                        'gsm_phone' => $phone_number,
                        'name' => $gelenler->input('first_name'),
                        'last_name' => $gelenler->input('last_name'),
                        'gender' => $gelenler->input('gender'),
                        'birth_date' => $gelenler->input('birth_date')
                    ]
                );

                $user_id = $gelenler->input('user_id');
                $user_info_id = $user_info->id;

                if ($gelenler->input('role_id') == 3) {/////driver

                    $driver = Driver::where('user_id', '=', $user_id)->first();
                    $driver->address = $gelenler->input('address');
                    $driver->postal_code = $gelenler->input('postal_code');
                    $driver->save();
                }////driver
            }////////update


            $dosya = $gelenler->file('dosya');
            if (!empty($dosya)) {
                $d_adi = $dosya->getClientOriginalName();
                $uzanti = $this->uzantiBul($d_adi);
                $d_adi = str_replace('.' . $uzanti, '', $d_adi);
                $dosya_adi = $this->fixetiket($d_adi) . "_" . rand(1000, 99999) . "." . $uzanti;
                Storage::put($dosya_adi, file_get_contents($dosya));
                $userInfo->where('id', '=', $user_info_id)->update(
                    ['photo' => $dosya_adi]
                );
            }////!empty

        }//////hata yok


        return redirect()->route('manager.department.edit', array('user_id' => $user_id));

    }
?>