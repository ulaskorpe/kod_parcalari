    <label for="user_id">{{__('Tasks.date_range')}}</label>
                            @include("components.datetime_range",[
                                                            "start_date_id"=>"start_at"
                                                            ,"start_date_name"=>"start_at"
                                                            ,"startdate"=>\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(-30)->toDateString()
                                                            ,"end_date_id"=>"end_at"
                                                            ,"end_date_name"=>"end_at"
                                                            ,"enddate"=>\Carbon\Carbon::parse(date('Y-m-d H:i'))->addDay(4)->toDateString()
                                                            ,"view"=>"true"
                                                            ])


        function deleteExpense(expenseId) {
            swal({
                    title: "Are you sure?",
                    text: "This type will be deleted",
                    type: "input",
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: "{{__('Expenses.yes_delete')}}",
                    cancelButtonText: "{{__('Expenses.no_cancel')}}",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    inputType:"password",
                    inputPlaceholder:"{{__('Expenses.auth_pw')}}"
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            data: {
                                '_token': '{{csrf_token()}}'
                                , 'expense_id':expenseId
                                , 'password':$('[type=password]').val()

                            },
                            url: '/manager/expenses/delete',
                            success: function (result) {
                                swal("Deleted!", "{{__('Expenses.expense_is_deleted')}}", "success");
                                location.reload();
                            }
                        }).fail(function (response) {
                            if (response.status === 422) {
                                toastr.options.positionClass = "toast-container toast-bottom-full-width";
                                toastr["error"](response.responseText);
                            }
                        });



                    } else {
                        swal("Cancelled", "{{__('Expenses.no_change')}}", "error");
                    }
                });
        }