@if(isset($model))
<div class="col-md-6">
    <label for="clientStartDriection">{{__('orders.start_location')}}  </label>
    <select id="clientStartDriection" name="clientStartDriection" class="form-control">
        <option value="0"></option>
        @foreach($model as $m)
            <option value="{{$m->id}}" {{ old('clientStartDriection')==$m->id?'selected=selected':'' }}>
                {{$m->address}}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-6">
    <label for="clientEndDriection">{{__('orders.end_location')}}  </label>
    <select id="clientEndDriection" name="clientEndDriection" class="form-control">
        <option value="0"></option>
        @foreach($model as $m)
            <option value="{{$m->id}}" {{ old('clientEndDriection')==$m->id?'selected=selected':'' }}>
                {{$m->address}}
            </option>
        @endforeach
    </select>
</div>
@endif

    <script type="text/javascript">
        $(function () {
            var clientStartDriection = $('#clientStartDriection').select2({
                placeholder: "Please select start a direction."
            });
            var clientEndDriection = $('#clientEndDriection').select2({
                placeholder: "Please select end a direction."
            });
            clientStartDriection.on('change', function () {
                var data = $("#clientStartDriection option:selected").text();
                $("#start_location").val(data.trim());
                $('#start_location').prop('readonly', true);
                var order_location_id = $("#clientStartDriection option:selected").val();
                getClientStartDirectionDetail(order_location_id);

            });
            clientEndDriection.on('change', function () {
                var data = $("#clientEndDriection option:selected").text();
                $("#end_location").val(data.trim());
                $('#end_location').prop('readonly', true);
                var order_location_id = $("#clientEndDriection option:selected").val();
                getClientEndDirectionDetail(order_location_id);
            });


        });

        function getClientStartDirectionDetail(location_id) {
            $.get('/manager/order/getdirectiondetail/' + location_id, function (data) {
                var obj = jQuery.parseJSON( data );
                $("#start_location_geocode").val(obj.geocode);
                $("#start_location_placeid").val(obj.place_id);
                $("#start_location_lat").val(obj.lat);
                $("#start_location_lon").val(obj.lon);

            });
        }

        function getClientEndDirectionDetail(location_id) {
            $.get('/manager/order/getdirectiondetail/' + location_id, function (data) {
                var obj = jQuery.parseJSON( data );
                $("#end_location_geocode").val(obj.geocode);
                $("#end_location_placeid").val(obj.place_id);
                $("#end_location_lat").val(obj.lat);
                $("#end_location_lon").val(obj.lon);
            });
        }
    </script>
