<?php

} else {
                $rules = [
                    'email' => 'required|string|email|max:255|unique:users',
                    'first_name' => 'required|string|min:3',
                    'last_name' => 'required|string|min:3',
                    'birthday' => 'required|date',
                    'gender' => 'required',
                    'password' => 'required|string|min:6',
                    'company_name' => 'required|string|min:3',
                    'company_tax_number' => 'required',
                    'company_email' => 'required',
                    'company_address' => 'required',
                    'company_phone_number1' => 'required',
                    'phone_number_country_code' => 'required',
                ];
                $this->validate($request, $rules);

                DB::transaction(function () use ($request) {
                    //after validation Save user
                    $NewUser = new User();
                    $NewUser->name = $request->input('first_name');
                    $NewUser->last_name = $request->input('last_name');
                    $NewUser->email = $request->input('email');
                    $NewUser->password = \Hash::make($request->input('password'));
                    $NewUser->gender = $request->input('gender');
                    $NewUser->birth_date = $request->input('birthday');
                    $NewUser->gsm_phone = $request->input('phone_number_country_code') . "-" . $request->input('phone_number');
                    $NewUser->status = 1;
                    //TODO: Roles will be add
                    $NewUser->role_id = 2;
                    $NewUser->save();

                    $NewClient = new Client();

                    $NewClient->company_name = $request->input('company_name');
                    $NewClient->company_email = $request->input('company_email');
                    $NewClient->company_phone_number1 = $request->input('company_phone_number1');
                    $NewClient->company_phone_number2 = $request->input('company_phone_number2');
                    $NewClient->company_phone_number3 = $request->input('company_phone_number3');
                    $NewClient->company_firm_number = $request->input('company_firm_number');
                    $NewClient->company_tax_number = $request->input('company_tax_number');
                    $NewClient->company_eu_tax_number = $request->input('company_eu_tax_number');
                    $NewClient->company_int_tax_number = $request->input('company_int_tax_number');
                    $NewClient->company_country_id = $request->input('company_country');
                    $NewClient->company_earnings_guarantee = $request->input('company_earnings_guarantee');
                    $NewClient->company_commission = $request->input('company_commission');
                    $NewClient->company_address=$request->input('company_address');

                    $NewClient->user_id = $NewUser->id;
                    $NewClient->corporate=$request->input('corporate');
                    $NewClient->company_client_id=$request->input('company');
                    $NewClient->title=$request->input('title');
                    $NewClient->residential_id=$request->input('residential_id');
                    $NewClient->postcode=$request->input('postcode');
                    $NewClient->place=$request->input('place');
                    $NewClient->backup_first_phone=$request->input('backup_first_phone');
                    $NewClient->spare_second_phone=$request->input('spare_second_phone');
                    $NewClient->bank_account_owner=$request->input('bank_account_owner');
                    $NewClient->bank_name=$request->input('bank_name');
                    $NewClient->iban=$request->input('iban');
                    $NewClient->bic=$request->input('bic');
                    $NewClient->identification_card=$request->input('identification_card');
                    $NewClient->identification_number=$request->input('identification_number');
                    $NewClient->nationality_id=$request->input('nationality');

                    $NewClient->invoice_company_name=$request->input('invoice_company_name');
                    $NewClient->invoice_customer_name=$request->input('invoice_customer_name');
                    $NewClient->address = $request->input('address');
                    $NewClient->related_person=$request->input('related_person');
                    $NewClient->invoice_type=$request->input('invoice_type');
                    if($request->input('invoice_send_via')=='email'){
                        $NewClient->invoice_via_email=1;
                        $NewClient->invoice_via_mail=0;
                    }
                    else{
                        $NewClient->invoice_via_mail=1;
                        $NewClient->invoice_via_email=0;

                    }
                    $NewClient->save();
                    $NewClient->client_number=100000+$NewClient->id;
                    $NewClient->save();

                    $attributes = $request->request->all();
                    $prices = $attributes['prices'];
                    unset($attributes['prices']);

                    foreach ($prices as $packid => $classprices) {

                        foreach ($classprices as $classid => $price) {

                            ClientSpecialPrice::firstOrNew([
                                'client_id' => $NewClient->id,
                                'package_id' => $packid,
                                'vehicle_class_id' => $classid
                            ])->fill(['price' => $price])->save();
                        }
                    }



                });

            }


?>