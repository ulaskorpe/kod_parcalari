    public function getvehicles($company_id=1){
        $vehicles=Vehicle::with('vehiclemodel.vehiclebrand','vehiclemodel.vehicleclass')->where('company_id','=',$company_id)->get();
        $data="<option value=''></option>";
        foreach ($vehicles as $vehicle){
            $data.="<option value='".$vehicle->id."'>[".$vehicle->plate."] ".$vehicle->vehiclemodel->vehiclebrand->name." ".$vehicle->vehiclemodel->name."  (".$vehicle->vehiclemodel->vehicleclass->name.") </option>";
        }

        return $data;
    }




 function getVehicles(){

     $.get('driver/getvehicles/' + $('#company_id').val(), function (data) {
         $('#vehicle_id').html(data);

     });

 }
