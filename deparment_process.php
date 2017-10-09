<?php

    public function process(Request $request)
    {

        $userInfo = new UserInfo();
        $user = new User();

        $messages = [];

        $kontrol = Validator::make($request->all(), array(
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

            if (empty($request->input('user_id'))) {

                return redirect()->route('manager.department.create', array('role_id' => $request->input('role_id')))->withErrors($kontrol)->withInput();
            } else {
                return redirect()->route('manager.department.edit', array('user_id' => $request->input('user_id')))->withErrors($kontrol)->withInput();
            }

        } else {////hata yok

             

            $admin_right = (!empty($request->admin_right)) ? 1 : 0;
            $work_right = (!empty($request->work_right)) ? 1 : 0;

            if (empty($request->input('user_id'))) {/////insert
                /*$id = DB::table('users')->insertGetId(
                    ['email' => 'john@example.com', 'votes' => 0]
                );*/
                $phone_number = $request->input('phone_number_country_code')."-".$request->input('phone_number');

                $user = new User;

                $user->name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                $user->password = Hash::make('secret');
                $user->status = 1;
                $user->gsm_phone = $phone_number;
                $user->gender = $request->input('gender');
                $user->birth_date = $request->input('birth_date');
                $role = Role::find($request->input('role_id'));
                $user->attachRole($role);
                $user->save();

                $user_info = new UserInfo;
                $user_info->user_id = $user->id;
                $user_info->svnr = $request->input('svnr');
                $user_info->title = $request->input('title');
                $user_info->license_number = $request->input('licensenumber');
                $user_info->license_date = $request->input('license_date');
                $user_info->classes = $request->input('class_dizi');
                $user_info->languages = $request->input('lang_dizi');
                $user_info->nationality = $request->input('nationality');
                $user_info->residense_permit = $request->input('residense_permit');
                $user_info->residense_permit_ends = $request->input('residense_permit_date');
                $user_info->work_place = $request->input('work_place');
                $user_info->address = $request->input('address');
                $user_info->postal_code = $request->input('postal_code');
                $user_info->comments = $request->input('comments');
                $user_info->gps_color = $request->input('gps_color');
                $user_info->admin_right = $admin_right;
                $user_info->working_right = $work_right;

                $user_info->save();


                $user_info_id = $user_info->id;
                $user_id = $user->id;

                if ($request->input('role_id') == $role->id) {/////driver
                    $driver = new Driver();
                    $driver->user_id = $user_id;
                    $driver->address = $request->input('address');
                    $driver->postal_code = $request->input('postal_code');
                    $driver->save();

                }////driver


            } else {////update


                $user_info = $userInfo->where('user_id', '=', $request->input('user_id'))->first();
                $userInfo->where('user_id', '=', $request->input('user_id'))->update(
                    [
                        'svnr' => $request->input('svnr'),
                        'title' => $request->input('title'),
                        'license_number' => $request->input('licensenumber'),
                        'license_date' => $request->input('license_date'),
                        'classes' => $request->input('class_dizi'),
                        'languages' => $request->input('lang_dizi'),
                        'nationality' => $request->input('nationality'),
                        'residense_permit' => $request->input('residense_permit'),
                        'residense_permit_ends' => $request->input('residense_permit_date'),
                        'work_place' => $request->input('work_place'),
                        'photo' => $user_info->photo,
                        'address' => $request->input('address'),
                        'postal_code' => $request->input('postal_code'),
                        'comments' => $request->input('comments'),
                        'admin_right' => $admin_right,
                        'working_right' => $work_right,
                        'gps_color' => $request->input('gps_color')
                    ]
                );

                $phone_number = $request->input('phone_number_country_code')."-".$request->input('phone_number');

                $user->where('id', '=', $request->input('user_id'))->update(
                    [
                        'email' => $request->input('email'),
                        'gsm_phone' => $phone_number,
                        'name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name'),
                        'gender' => $request->input('gender'),
                        'birth_date' => $request->input('birth_date')
                    ]
                );

                $user_id = $request->input('user_id');
                $user_info_id = $user_info->id;

                if ($request->input('role_id') == 3) {/////driver

                    $driver = Driver::where('user_id', '=', $user_id)->first();
                    $driver->address = $request->input('address');
                    $driver->postal_code = $request->input('postal_code');
                    $driver->save();
                }////driver
            }////////update


            $dosya = $request->file('dosya');
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