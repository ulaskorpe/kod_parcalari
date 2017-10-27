    function removeJob() {
        swal({
                title: "{{__('orders.are_you_sure')}}",
                text: "{{__('orders.job_will_be_deleted')}}",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "{{__('orders.delete_it')}}",
                cancelButtonText: "{{__('orders.cancel')}}!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.get('/common/order/delete/' + $('#jobid').val(), function (mdata) {
                        if (mdata == 'ok') {
                            swal("Deleted!", "Job is deleted.", "success");
                            location.reload();
                        }
                    }).fail(function () {
                        toastr.options.positionClass = "toast-container toast-bottom-full-width";
                        toastr["error"]("An Error Occurred !");
                    });

                } else {
                    swal("Cancelled", "There is no change!", "error");
                }
            });
    }