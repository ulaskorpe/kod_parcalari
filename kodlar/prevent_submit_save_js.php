        $('#create_file').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            save(formData);
        });

        function save(formData) {
            $("#loading").show();
            $.ajax({
                type:'POST',
                url: '/manager/department/files/create',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    swal("{{__('vehicles.created')}}!", "{{__('vehicles.vehicle_class_is_created')}}!", "success");
                    location.reload();
                },
                error: function(data){
                    if (data.status === 422) {
                        var errors = data.responseJSON;
                        var errosHtml = "";
                        $.each(errors, function (key, value) {
                            var id = "#".concat(key);
                            $("#" + key).css("border", '1px solid red');
                            $("#" + key).effect("shake")
                            toastr.options.positionClass = "toast-container toast-bottom-full-width";
                            toastr["error"](value[0]);

                        });

                    }
                }
            });

        }



        kaycee.hessel@heaney.info