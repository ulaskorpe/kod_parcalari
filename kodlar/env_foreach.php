insert into `clients` (`title`, `user_id`, `related_person`, `address_id`, `residential_id`, `postcode`, `place`, `updated_by`, `updated_at`, `created_at`) values (prof, 47, conan lastname, , AL, postcode, place, 2, 2017-10-24 11:09:49, 2017-10-24 11:09:49))",
    "exception"



      @foreach($envArray as $line)


                                <div class="row">
                                    <div class="col-md-3">{{$line['id']}}</div>
                                    <div class="col-md-3"><input type="text" class="form-control" name="{{$line['id']}}" id="{{$line['id']}}" value="{{$line['text']}}"></div>
                                    <div class="col-md-3"></div>
                                </div>
                            @endforeach
