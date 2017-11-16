<?php

//////observer
    public function saved($recourse)
    {
        SocketHelper::recoursecreated(Auth::id(),$recourse);

    }

    //////socket helper


        public static function recoursecreated($user_id,$recourse){

        $recourseHtml = " recourseHtml";
        $data = ['recourseHtml' => $recourseHtml,  'message' => $recourse->email];
        $data = \GuzzleHttp\json_encode($data);


        $redis = Redis::connection();
        $redis->publish('recourse-' . $user_id, $data);
    }


/////view blade 
?>

<script type="text/javascript">
       var socket = io.connect('{!! env("APP_URL") !!}:3000');


        socket.on('recourse-{{Auth::id()}}', function (data) {

            var obj = JSON.parse(data);
            $('#recourse_notifications').prepend(obj.recourseHtml);
            var count = $('#recourse_notification_counter').html();
            $('#recourse_notification_counter').html(parseInt(count)+1);
            $('#recourse_notification_counter2').html(parseInt(count)+1);

            $('#recourse_notification_list').trigger('click.bs.dropdown');//???

              toastr.options.positionClass = "toast-bottom-left";
                    toastr["info"](obj.message);
         });
        socket.emit('subscribe', 'recourse-{{Auth::user()->id}}');

        </script>


<button onclick="recourseekle()">Ekle</button>

<script>
    function recourseekle(){
        $.get('/manager/recourses/ekle', function (data) {
            console.log(data);
        });
    }

</script>



<?php

    public function recourseekle(){

        $faker = \Faker\Factory::create();

        $location = Location::where('id','>',0)->orderByRaw("RAND()")->first();
        $recourse = new \App\Models\Recourse();
        $recourse->name=$faker->name;
        $recourse->surname=$faker->lastName;
        $recourse->email=$faker->email;
        $recourse->phone="43-".rand(1000000,9999999);
        $recourse->user_note= $faker->sentences($nb = 3, $asText = true) ;
        $recourse->password=   Hash::make('secret');;
        $recourse->user_note= $faker->sentences($nb = 3, $asText = true) ;
        $recourse->vehicle_model=rand(1,7);
        $recourse->vehicle_km = rand(2,30)*1000;
        $recourse->vehicle_note= $faker->sentences($nb = 3, $asText = true) ;
        $recourse->plate = strtoupper($faker->randomLetter."-".rand(100,500).$faker->randomLetter.$faker->randomLetter);
        $recourse->company_name=$faker->company;
        $recourse->tax_no=rand(100000,300000);
        $recourse->company_address= $location->geocode;
        $recourse->address_id= $location->id;
        $recourse->license_files="[\"/home/vagrant/Code/web/storage/appeal-files/appeal_1IMG_20171101_104833.jpg\"]";
        $recourse->company_files="[\"/home/vagrant/Code/web/storage/appeal-files/appeal_1IMG_20171101_104810.jpg\"]";
        $recourse->personal_files="[\"/home/vagrant/Code/web/storage/appeal-files/appeal_1IMG_20171101_104810.jpg\"]";
        $recourse->vehicle_files="[\"/home/vagrant/Code/web/storage/appeal-files/appeal_1IMG_20171101_104808.jpg\"]";
        $recourse->save();

        return $recourse->id." eklendi";
    }

?>        