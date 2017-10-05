<?php

        $role = Role::with('users')->find($role_id);
       if ($template_show == \Enum\ShowTemplates::PERSONAL_WITH_WORK_TEMPLATE) {//withtemplate

            $users_with_template = UserWorkTemplate::distinct()->select('user_id')->pluck('user_id');
            $users = $role->users()
                ->wherein('id', $users_with_template)
                ->get();

        } elseif ($template_show == \Enum\ShowTemplates::PERSONAL_WITHOUT_WORK_TEMPLATE) {///withouttemplate
            $users_with_template = UserWorkTemplate::distinct()->select('user_id')->pluck('user_id');
            $users = $role->users()
                ->wherenotin('id', $users_with_template)
                ->get();

        }else{
            $users = $role->users;
        }
?>