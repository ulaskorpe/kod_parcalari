  <script type="text/javascript">

        $('#change_password').submit(function (e) {
            e.preventDefault();
            save();
        });

        function save() {
            $("#loading").show();

            $.post('/change-password', $('#change_password').serialize(), function (data) {

                $("#loading").hide();
                swal("{{__('clients.client_is_created')}}", "{{__('clients.client_is_created')}}", "success");
                location.reload();

            }).fail({!! config("view.ajax_error")!!});
        }

    </script>



    <?php

  if ($request->isMethod('post')) {

            $rules = [

                'old_password' => 'required',
                'password' => 'required|min:6',
                'password_again' => 'required',
            ];

            if (!Hash::check($request->input('old_password'), $user->password)) {
                $data['message'] =  " Please enter your current password";
                return response($data, 422);
            }

            if ($request->input('password') != $request->input('password_again')) {
                $data['message'] =  " Please enter your new password again";
                return response($data, 422);
            }

            $this->validate($request, $rules);


            \DB::transaction(function () use ($request, $user) {

                $user->password = Hash::make($request->input('password'));
                $user->save();

               return "ok";
            });
        }////post
    ?>