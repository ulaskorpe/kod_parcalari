<?php

 $dosya = $request->file('profile_image');
                $dh= new DepartmentHelper();

                if (!empty($dosya)) {

                    $d_adi = $dosya->getClientOriginalName();
                    $uzanti = $dh->uzantiBul($d_adi);
                    if(in_array($uzanti,$this->izinliDizi)){
                      $path = storage_path("user_files/user_".$user->id."/");
                      $filename = "PF_".date('YmdHis').$dosya->getClientOriginalName();
                      $dosya->move($path, $filename);
                      $user->profile_image = "user_files/user_".$user->id."/".$filename;
                    }
                }
?>