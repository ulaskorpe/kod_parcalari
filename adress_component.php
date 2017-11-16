
 
@php
    $modelname=$modelname?$modelname:\App\Models\Location::class;
    $value=(isset($value))?$value:0;
    $hint=(isset($value['hint'])) ? $value['hint'] : "";
@endphp


<input type="hidden" id="params-{{$id}}">
<input type="hidden" id="place_id-{{$id}}" name="place_id-{{$id}}" value="">
<input type="hidden" id="geocode-{{$id}}" name="geocode-{{$id}}" value="">
<input type="hidden" id="location-{{$id}}" name="location-{{$id}}" value="">
<select id="{{$id}}" name="{{$name}}" class="form-control">
    @if($value>0)
        @if(is_array($value))
            <option value="{{$value['id']}}"> {{$value['text']}}</option>
        @else
            <option value="{{$value}}"> {{$value}}</option>
        @endif
    @endif
    {{--@if(isset($model))
        @if(count($model)>0)
            @foreach($model as $m)
                <option value="{{$m->id}}" {{ old($name,isset($value)?$value:0)==$m->id?'selected=selected':'' }}>
                    {{$m->text}}
                </option>
            @endforeach
        @endif
    @endif--}}
</select>

<label for="address_note-{{$id}}">Address Hint</label>
<img src="https://vignette1.wikia.nocookie.net/ichc-channel/images/7/70/Powered_by_google.png/revision/latest?cb=20160331203712" style="height: 20px; float: right">
<textarea id="address_note-{{$id}}" name="address_note-{{$id}}" class="form-control">{{$hint}}</textarea>
@section("scripts")
    <script type="text/javascript">
        var selectdata{{$id}};
        var firstposition = "";
        var select2_{{$id}}= $('#{{$id}}').select2({
            placeholder: "{{__('department.please_select')}}",
            minimumInputLength: 2,
            ajax: {
                url: ' {!! $autocomplete_url !!}',
                dataType: 'json',
                delay: 600,
                data: function (params) {
                    return {
                        q: firstposition != "" ? firstposition : $.trim(params.term),
                        params: $("#params-{{$id}}").val(),
                        modelname: "{!! str_replace('\\','\\\\',$modelname)!!}",
                        functionname: '{{$functionname}}'
                    };
                },
                processResults: function (data) {
                    selectdata{{$id}}= data
                    return {
                        results: data
                    };
                },
                cache: true
            }
        }).change(function () {
            var adress_selecet_id = $("#{{$id}}  option:selected").val();
            var result_selected = $.grep(selectdata{{$id}}, function (event) {
                return event.id == adress_selecet_id;
            });
            $("#place_id-{{$id}}").val(result_selected[0].place_id);

            $("#geocode-{{$id}}").val(result_selected[0].geocode);
            $("#location-{{$id}}").val(result_selected[0].location).trigger('change');
            getBoundaries(result_selected[0].location, result_selected[0].place_id)

            $.get("/common/location/addressnote?location_id=" + adress_selecet_id).done(function (data) {
                $('#address_note-{{$id}}').val(data);
            }).fail({!! config("view.ajax_error") !!});

        });

        $('#address_note-{{$id}}').focusout(function () {
            var location_id = $("#{{$id}}  option:selected").val();
            if (location_id > 0) {
                var address_note = $("#address_note-{{$id}}").val();
                $.post("/common/location/addressnote", {_token: '{{csrf_token()}}', location_id: location_id, address_note: address_note}).done(function (data) {
                    toastr.options.positionClass = "toast-container toast-bottom-full-width";
                    toastr["success"]("Address hint is updated");
                }).fail({!! config("view.ajax_error") !!});
            } else {
                toastr.options.positionClass = "toast-container toast-bottom-full-width";
                toastr["error"]("Please select an address to add address hint");
            }

        });

        function getBoundaries(location_input_val, place_id) {

            $.get("/common/location/placebound?place_id=" + place_id).done(function (data) {
                if (data == "ok") {

                } else {
                    var lat_lng = new google.maps.LatLng(JSON.parse(location_input_val));
                    var boundaries_place_ids = [];
                    geocoder.geocode({'latLng': lat_lng}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            for (var i = 0; i < results.length; i++) {
                                boundaries_place_ids.push(results[i].place_id)
                            }
                        }
                        $.post("/common/location/placebound", {_token: '{{csrf_token()}}', place_id: place_id, bound: boundaries_place_ids}).done(function (data) {

                        }).fail({!! config("view.ajax_error") !!});
                    });

                }
            }).fail({!! config("view.ajax_error") !!})


        }

    </script>
@append                           


/////////////////////////////////////usage in blade///////////////////////////////


                               @if($client->address_id>0)
                                @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                                 "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'
                                 ,"value"=>['id'=>$client->address_id,'text'=>$client->address->address,'hint'=>$client->address->address_note]
                                   ])
                                    @else
                                    @include("components.select2_address",["id"=>"address_id","name"=>"address_id",
                       "autocomplete_url"=>"/common/autocomplate/select2","modelname"=>\App\Models\Location::class,"functionname"=>'Address'])
                                @endif