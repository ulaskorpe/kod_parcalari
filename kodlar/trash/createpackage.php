<?php

 $UserPackage=new UserPackage();


			$startmaplimit = $request['start-map-limit'];
			$endmaplimit = $request['end-map-limit'];
			$askstart = $request['start_location'] == "1";
			$askend = $request['end_location'] == "1";
			$prices = $request['prices'];
			$name = $request['name'];
            $is_private = ($request['is_private']) ? 1 : 0 ;

            $messages=[
                /*hata msgları
                        'start_at.required'=>'boş olmuyo',
                        'end_at.required'=>'bitiş tarihi boş olmaz',
                        'end_at.after'=>'bitiş başlangıçtan önce olmaz'*/
            ];

            $kontrol = Validator::make($request->all(),array(
                'name' => 'required|min:3'

            ),$messages);
          //  dd($request['is_private']);
            if($request['is_fixed']){
                $is_fixed=1 ;
                $duration=0;
                $min_price=$request['min_price'];
                if(empty($min_price)){
                    $kontrol->errors()->add('min_price','Minimum price should be defined for a fixed price package');////custom error msg
                }

            }else{
                $is_fixed=0;
                $duration=$request['duration'];
                $min_price=0;
                if(empty($duration)){
                    $kontrol->errors()->add('duration','Minimum duration should be defined for a non-fixed price package');////custom error msg
                }
            }

          if(count($kontrol->errors())){
              return redirect()->route('manager.package.create')->withErrors($kontrol)->withInput();

          }else {
              $Package = new Package();
              $Package->name = $name;
              $Package->is_fixed_price=$is_fixed;
              $Package->is_private=$is_private;
              $Package->start_location = $askstart;
              $Package->end_location = $askend;
              $Package->start_map_place = $startmaplimit;
              $Package->min_price=$min_price;
              $Package->duration=$duration;

              $Package->end_map_place = $endmaplimit;
              //	$Package->is_fixed_price = $request['prices'] == "0";
              //    $Package->is_private = $request['is_private'] == "0";
              $Package->save();

              foreach ($prices as $classid => $price) {

                  VehicleClassPrice::firstOrNew([
                      'package_id' => $Package->id,
                      'vehicle_class_id' => $classid
                  ])->fill(['price' => $price])->save();

              }

              if ($is_private) {
                  $private_users = $request['private_users'];
                  $dizi = array();
                  $i = 0;
                  foreach ($private_users as $user) {

                      $dizi[$i] = array('user_id' => $user, 'package_id' => $Package->id);
                      $i++;

                  }
                  $UserPackage->insert($dizi);

              }////is  private




              <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('package_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_packages');
    }
}


?>