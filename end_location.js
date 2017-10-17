var end_location_input = document.getElementById('end_location');
                 var end_autocomplete = new google.maps.places.Autocomplete(end_location_input);
                 end_autocomplete.addListener('place_changed', function () {
                     var place = end_autocomplete.getPlace();
                     $("#end_location_placeid").val(place.place_id);
                     $("#end_location_lat").val(place.geometry.location.lat());
                     $("#end_location_lon").val(place.geometry.location.lng());
                     geocoder.geocode({'latLng': place.geometry.location}, function (results, status) {
                         if (status === google.maps.GeocoderStatus.OK) {
                             $("#end_location_postalcode").val(postalCodeFromJson(results));
                             $("#end_location_geocode").val(JSON.stringify(results));
                         }
                     });
                 });


myLatLng = new google.maps.LatLng({lat: 48.1604766, lng: 16.381990900000005});
            map.panTo(myLatLng);
            startmarker.setPosition(myLatLng);
            startmarker.setVisible(true);                 





 function some_function(arg1, arg2, callback) {
  // this generates a random number between
  // arg1 and arg2
  var my_number = Math.ceil(Math.random() * (arg1 - arg2) + arg2);
  // then we're done, so we'll call the callback and
  // pass our result
  callback(my_number);
}
// call the function
some_function(5, 15, function(num) {
  // this anonymous function will run when the
  // callback is called
  console.log("callback called! " + num);
});


function abc(param){
 console.log("callback called! " + num);
}