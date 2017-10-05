       <input type="checkbox"
        data-toggle="toggle" id="is_client" name="is_client" 
        data-off="Not Client" data-on="Client"
        onchange="isClient();"/><input type="hidden" value="0" id="passenger_is_client" name="passenger_is_client">


         <input type="checkbox" data-toggle="toggle" id="travel_type" name="travel_type" data-on="{{__("orders.trip")}}"
                                                           data-off="{{__("orders.not_trip")}}"/>
                                                    <input type="hidden" name="is_trip" id="is_trip" value="0">


@include("components.toggle",["id"=>"passenger_is_client","name"=>"passenger_is_client","dataon"=>__('orders.client'),"dataoff"=>__('orders.not_client'),"function"=>"isClient(state)"])                                                    