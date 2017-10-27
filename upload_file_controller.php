<?php

    public function uploadfile(Request $request)
    {



        dd($request);
        $user =User::find($request->user_id);//User::find($gelenler->input('user_id'));
        $file_id = $request->input('file_id');

        $userFile = new UserFile();
        $izinliDizi = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt', 'png',"jpg","jpeg");
        $messages = [
            /*hata msgları
                    'start_at.required'=>'boş olmuyo',
                    'end_at.required'=>'bitiş tarihi boş olmaz',
                    'end_at.after'=>'bitiş başlangıçtan önce olmaz'*/
        ];
        $kontrol = Validator::make($request->all(), array(//'description' => 'required'
        ), $messages);
        $dh= new DepartmentHelper\DepartmentHelper();
        if (empty($file_id)) {/////create
            $dosyalar = $request->file('files');
            if (!empty($dosyalar)) {
                $user=User::find($request->user_id);

                foreach ($dosyalar as $dosya) {
                    $d_adi = $dosya->getClientOriginalName();
                    $uzanti = $dh->uzantiBul($d_adi);
                    if (in_array($uzanti, $izinliDizi)) {
                       $path = storage_path("user_files/user_" .$request->user_id. "/");
                       echo $path;
                        $filename = Carbon::Now()->format('YmdHis')."_".$dosya->getClientOriginalName();
                        $dosya->move($path, $filename);

                        $description = (!empty($request->input('description'))) ?
                        $request->input('description') : date('d.m.Y') . ' dated file for ' .$user->fullname() . ":" . $d_adi;
                        $newFile = new UserFile();
                        $newFile->description = $description;
                        $newFile->user_id = $request->user_id;
                        $newFile->file = $path . $filename;
                        $newFile->date = Carbon::now();
                        $newFile->save();

                    }else{

                        $kontrol->errors()->add('file', $d_adi . '.' . $uzanti . '  ,  ' . __('personel_form.file_error'));////custom error msg
                        return redirect()->route('manager.department.files.create', array('user_id' => $request->user_id))->withErrors($kontrol)->withInput();


                    }

                }
            }
            /// echo "yok";

        }else{/////update
            $file = $userFile->where('id', '=', $file_id)->first();
            $eski_dosya_adi = $file->file;
            $dosya_adi = '';

                $dosyalar = $request->file('files');
                if (!empty($dosyalar)) {
                    foreach ($dosyalar as $dosya) {
                        $d_adi = $dosya->getClientOriginalName();
                        $uzanti = $dh->uzantiBul($d_adi);
                        $d_adi = str_replace('.' . $uzanti, '', $d_adi);
                        $dosya_adi = $this->fixetiket($d_adi) . "_" . rand(1000, 99999) . "." . $uzanti;
                        if (in_array($uzanti, $izinliDizi)) {
                            Storage::put($dosya_adi, file_get_contents($dosya));

                        }

                    }///foreach
                    $description = (!empty($request->input('description'))) ? $request->input('description') : date('d.m.Y') . ' dated file for ' . $user->name . ' ' . $user->last_name . ":" ;
                } else {
                    $dosya_adi = $eski_dosya_adi;
                    $description = (!empty($request->input('description'))) ? $request->input('description') : date('d.m.Y') . ' dated file for ' . $user->name . ' ' . $user->last_name . ":" . $file->file;
                }////dosya gelmiş

                $userFile->where('id', '=', $file_id)->update(['description' => $description, 'file' => $dosya_adi]);



        }

        return redirect()->route('manager.department.files', array('id' => $request->user_id));
        //// dd($izinliDizi);
    }/////uploadfile


      public function create_eski($user_id = 0,Request $request)
    {
        $user =User::find($user_id);


        if ($request->isMethod('post')) {


            $rules = [
                'amount' => 'required',
                'expense_type' => 'required',
                'expense_title' => 'required',
                'expense_date' => 'required|before:tomorrow',
                // 'expense_document' => 'mimes:doc,docx,xls,xlsx,pdf,txt,png,jpg,jpeg'
            ];
            $this->validate($request, $rules );


            \DB::transaction(function () use ($request) {

                dd($request);

                $dh= new DepartmentHelper\DepartmentHelper();
                    $dosyalar = $request->file('files');
                    if (!empty($dosyalar)) {
                        $user=User::find($request->user_id);
                        foreach ($dosyalar as $dosya) {
                            $d_adi = $dosya->getClientOriginalName();
                            $uzanti = $dh->uzantiBul($d_adi);
                            if (in_array($uzanti, $this->izinliDizi)) {
                                $path = storage_path("user_files/user_" . $request->user_id . "/");
                                $filename = Carbon::Now()->format('YmdHis') . "_" . $dosya->getClientOriginalName();
                                $dosya->move($path, $filename);

                                $user=User::find($request->input('user_id'));

                                $description = (!empty($request->input('description'))) ?
                                $request->input('description') : date('d.m.Y') . ' dated file for ' . $user->fullname() . ":" . $d_adi;

                                $newFile = new UserFile();
                                $newFile->description = $description;
                                $newFile->user_id = $request->user_id;
                                $newFile->file = $path . $filename;
                                $newFile->date = Carbon::now();
                                $newFile->save();

                            }

                        }
                    }
            });

            return 'ok';
        }////post

            //return $user_->id;
        return view('themes.' . static::$tf . '.manager.department.files.create', array( 'user' => $user));


    }

?>