     
function getFromGoogle(term){
//'http://intersprint.dev/sonuc.php';//
var link = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='+term+'&key={{env('GOOGLE_API_KEY')}}';
           /* $.ajax({
                url:link,

                type: "GET",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                cache: false,
                crossDomain: true,
                success:function(data){
                    console.log(data);
                    // do stuff with json (in this case an array)
                    alert("Success");
                },
                error:function(data){
                    console.log(data.getAllResponseHeaders());
                    alert("Error");
                }
                });*/
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://maps.googleapis.com/maps/api/place/autocomplete/xml?input="+term+"&key={{env('GOOGLE_API_KEY')}}", true);
    xhr.onload = function () {
        console.log(xhr.responseText);
    };
    xhr.send();

}///



       /*
       //            orders.please_select        9747 Jaylan Lakes Apt. 880Hanschester, MA 34781
               function getAddress(){
       //            https://maps.googleapis.com/maps/api/place/autocomplete/json?input=antalya&key=AIzaSyCs04NeB3LlmwXTJ1m1q3aF4qmKURYAOcM

               $.get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' + $('#{{$id}}').val(), function (data) {

            var html = "";

            for (var i = 0; i < data.length; i++) {


                html += '<option value="' + data[i].id + '">' + data[i].name +' -  '+ data[i]['vehicleclass']['name'] +
                    '</option>';
            }

            $('#modelselect').html(html);

        });
         <script src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_API_KEY")}}&libraries=places&callback=test&input=antalya" async defer></script>
        */

        }