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

