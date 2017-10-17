@include("components.address_select2", ["id"=>"address","name"=>"address",
                                                                            "autocomplete_url"=>"/common/autocomplate/select2",
                                                                            "modelname"=>\App\Models\Location::class,
                                                                            "functionname"=>"getAddress",
                                                                            "getCoordinates"=>true
                                                                         ])


     @include("components.address_select2", ["id"=>"address","name"=>"address",
                                                                             "autocomplete_url"=>"/common/autocomplate/select2",
                                                                             "modelname"=>\App\Models\Location::class,
                                                                             "functionname"=>"getAddress",
                                                                             "getCoordinates"=>true,
                                                                             "value"=>$model->address,


                                                                          ])

controller ::::: 

use App\Helpers\LocationHelper\LocationHelper;

$client->address = LocationHelper::getPlaceId($request->input('address'),$request->input('coordinate_address'),$request->input('text_address'));

use App\Helpers\LocationHelper\LocationHelper;


                                                    @include("components.address_select2", ["id"=>"from_actb","name"=>"from_actb",
                                                                            "autocomplete_url"=>"/common/autocomplate/select2",
                                                                            "modelname"=>\App\Models\Location::class,
                                                                            "functionname"=>"getAddress",
                                                                            "getCoordinates"=>true
                                                                         ])

    <input id="from_actb" class="form-control" name="from_actb" value="{{ old('from_actb') }}">


startlocation_geocode
startlocation
startlocation_placeid