<?php
//////observerda updated içinde
       if ($model->isDirty(["is_row_complated"])) {
            $mailsetting = new MailSettingHelper();
            $mailsetting->SendOrderCreateMail($model->id);

            }
////