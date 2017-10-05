<?php

        if (isset($request["my_files"]) && is_array($request["my_files"])) {
            foreach ($request["my_files"] as $file) {

                $path = storage_path("user-files/driver/" . $Driver->id . "/");
                $filename = "EXPENSE_" . $file->getClientOriginalName();
                $file->move($path, $filename);
                $Expense->expense_document = $path . $filename;
            }
        }



        ///dead


          /*      $d_adi = $dosya->getClientOriginalName();
                $uzanti = $dh->uzantiBul($d_adi);
                $d_adi = str_replace('.' . $uzanti, '', $d_adi);
                $dosya_adi = $dh->fixetiket($d_adi) . "_" . rand(1000, 99999) . "." . $uzanti;
                Storage::put($dosya_adi, file_get_contents($dosya));
                UserInfo::where('user_id', '=', $user_id)->update(
                    ['photo' => $dosya_adi]
                );*/
?>