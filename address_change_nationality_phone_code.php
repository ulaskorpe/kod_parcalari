   <script type="text/javascript">

    $('#address_id').on('change',function(){
            $.get('/find_country_code/'+$('#address_id').val(),function(data){
                $('#phone_number_country_code').val(data['phone_code']).trigger('change');
                $('#nationality_id').val(data['country_code']).trigger('change');
                }).fail({!! config("view.ajax_error") !!});
    });

    </script>



///////controller tarafı
<?php
        public function findCountryCode($location_id=0 ){
            $location=Location::find($location_id);
            $geocode=json_decode(str_replace("\\","",$location->geocode));
                $geoArray=$geocode->results[0]->address_components ;
                $countryCode="";
                foreach ($geoArray as $geo){
                   if($geo->types[0]=='country'){
                        $countryCode=$geo->short_name;
                       break;
                   }
                }
                $countryCodes = Cache::run(new PhoneCodeFunc());
                return  ['country_code'=>$countryCode,'phone_code'=>$countryCodes[$countryCode]];
    }
    ?>