    frommarkerplace = fromautocomplete.getPlace();
            console.log(frommarkerplace);
            myLatLng = new google.maps.LatLng($('#coordinate_from_actb').val());
            //    map.panTo(48.1604766,16.381990900000005);
            //  startmarker.setPosition(48.1604766,16.381990900000005);
            var pos = $("#startlocation").val();
            map.panTo(pos);
            //  startmarker.setPosition(frommarkerplace.geometry.location);
            startmarker.setPosition(pos);
            startmarker.setVisible(true);
            $("#startlocation_placeid").val(frommarkerplace.place_id);
           // writeStartInfo(calcRoute);


            /*    map.panTo(myLatLng);
            startmarker.setPosition(myLatLng);
            startmarker.setVisible(true);

                     //      frommarkerplace = fromautocomplete.getPlace();
                           map.panTo($('#coordinate_from_actb').val());//frommarkerplace.geometry.location

                        var location=JSON.parse($('#coordinate_from_actb').val());
                        console.log(location);
                          //      map.panTo(location);
                                //map.center=location;
                                //startmarker.setPosition(frommarkerplace.geometry.location);
                              startmarker.setPosition(location);
                              startmarker.setVisible(true);
                           /*    $("#startlocation_placeid").val(frommarkerplace.place_id);

                        writeStartInfo(calcRoute); */




      var frominput = document.getElementById('from_actb');
            fromautocomplete = new google.maps.places.Autocomplete(frominput);
            fromautocomplete.addListener('changed', function () {
                fromTextChanged();
            });                        


  var latlng = new google.maps.LatLng(-24.397, 140.644);
    marker.setPosition(latlng);            


       //     $('#endlocation_geocode').on('change',toTextChanged);

        /*     var toinput = document.getElementById('to_actb');
             toautocomplete = new google.maps.places.Autocomplete(toinput);
             toautocomplete.addListener('place_changed', function () {
                 toTextChanged();

             });*/


             [{"address_components":[{"long_name":"211","short_name":"211","types":["street_number"]},{"long_name":"Favoritenstra\u00dfe","short_name":"Favoritenstra\u00dfe","types":["route"]},{"long_name":"Favoriten","short_name":"Favoriten","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Wien","short_name":"Wien","types":["locality","political"]},{"long_name":"Wien","short_name":"Wien","types":["administrative_area_level_1","political"]},{"long_name":"Austria","short_name":"AT","types":["country","political"]},{"long_name":"1100","short_name":"1100","types":["postal_code"]}],"formatted_address":"Favoritenstra\u00dfe 211, 1100 Wien, Austria","geometry":{"location":{"lat":48.1639016,"lng":16.3831412},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":48.16525058029151,"lng":16.3844901802915},"southwest":{"lat":48.16255261970851,"lng":16.3817922197085}}},"place_id":"ChIJuUAM6pWpbUcRGvKU-AhpIdw","types":["establishment","local_government_office","point_of_interest","police"]}]


[{"address_components":[{"long_name":"Manavgat","short_name":"Manavgat","types":["locality","political"]},{"long_name":"Manavgat","short_name":"Manavgat","types":["administrative_area_level_2","political"]},{"long_name":"Antalya","short_name":"Antalya","types":["administrative_area_level_1","political"]},{"long_name":"Turkey","short_name":"TR","types":["country","political"]},{"long_name":"07600","short_name":"07600","types":["postal_code"]}],"formatted_address":"Manavgat, 07600 Manavgat/Antalya, Turkey","geometry":{"bounds":{"northeast":{"lat":36.801766,"lng":31.483895},"southwest":{"lat":36.770443,"lng":31.413427}},"location":{"lat":36.786869,"lng":31.441282},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":36.801766,"lng":31.483895},"southwest":{"lat":36.770443,"lng":31.413427}}},"place_id":"ChIJqfdYVHxXwxQRQbcE80WC3QY","types":["locality","political"]}]


             "[{\"address_components\":[{\"long_name\":\"Beyo\\u011flu\",\"short_name\":\"Beyo\\u011flu\",\"types\":[\"political\",\"sublocality\",\"sublocality_level_1\"]},{\"long_name\":\"\\u00c7ukur Mahallesi\",\"short_name\":\"\\u00c7ukur Mahallesi\",\"types\":[\"administrative_area_level_4\",\"political\"]},{\"long_name\":\"Beyo\\u011flu\",\"short_name\":\"Beyo\\u011flu\",\"types\":[\"administrative_area_level_2\",\"political\"]},{\"long_name\":\"Istanbul\",\"short_name\":\"Istanbul\",\"types\":[\"administrative_area_level_1\",\"political\"]},{\"long_name\":\"Turkey\",\"short_name\":\"TR\",\"types\":[\"country\",\"political\"]},{\"long_name\":\"34435\",\"short_name\":\"34435\",\"types\":[\"postal_code\"]}],\"formatted_address\":\"Beyo\\u011flu, \\u00c7ukur Mahallesi, 34435 Beyo\\u011flu\\/Istanbul, Turkey\",\"geometry\":{\"location\":{\"lat\":41.036944,\"lng\":28.9775},\"location_type\":\"APPROXIMATE\",\"viewport\":{\"northeast\":{\"lat\":41.0453598,\"lng\":28.9935074},\"southwest\":{\"lat\":41.0285271,\"lng\":28.9614926}}},\"place_id\":\"ChIJpQvDR2e3yhQRGlDr5COmghk\",\"types\":[\"political\",\"sublocality\",\"sublocality_level_1\"]}]"




[{"address_components":[{"long_name":"Trabzon","short_name":"Trabzon","types":["locality","political"]},{"long_name":"Trabzon Merkez","short_name":"Trabzon Merkez","types":["administrative_area_level_2","political"]},{"long_name":"Trabzon","short_name":"Trabzon","types":["administrative_area_level_1","political"]},{"long_name":"Turkey","short_name":"TR","types":["country","political"]}],"formatted_address":"Trabzon, Trabzon Merkez\/Trabzon, Turkey","geometry":{"bounds":{"northeast":{"lat":41.01237,"lng":39.8101129},"southwest":{"lat":40.9735129,"lng":39.652407}},"location":{"lat":41.0026969,"lng":39.7167633},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":41.01237,"lng":39.8101129},"southwest":{"lat":40.9735129,"lng":39.652407}}},"partial_match":true,"place_id":"ChIJiezyawY8ZEARcSuMdMoKOcQ","types":["locality","political"]},{"address_components":[{"long_name":"Trabzon Merkez","short_name":"Trabzon Merkez","types":["colloquial_area","political"]},{"long_name":"Ortahisar","short_name":"Ortahisar","types":["administrative_area_level_2","political"]},{"long_name":"Trabzon","short_name":"Trabzon","types":["administrative_area_level_1","political"]},{"long_name":"Turkey","short_name":"TR","types":["country","political"]}],"formatted_address":"Trabzon Merkez, Ortahisar\/Trabzon, Turkey","geometry":{"bounds":{"northeast":{"lat":41.013473,"lng":39.8404351},"southwest":{"lat":40.779737,"lng":39.61783399999999}},"location":{"lat":40.9562156,"lng":39.73504020000001},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":41.013473,"lng":39.8404351},"southwest":{"lat":40.779737,"lng":39.61783399999999}}},"partial_match":true,"place_id":"ChIJaQgS0flHZEARRGeskdj41fo","types":["colloquial_area","political"]}]


"[{\"address_components\":[{\"long_name\":\"Trabzon\",\"short_name\":\"Trabzon\",\"types\":[\"locality\",\"political\"]},{\"long_name\":\"Trabzon Merkez\",\"short_name\":\"Trabzon Merkez\",\"types\":[\"administrative_area_level_2\",\"political\"]},{\"long_name\":\"Trabzon\",\"short_name\":\"Trabzon\",\"types\":[\"administrative_area_level_1\",\"political\"]},{\"long_name\":\"Turkey\",\"short_name\":\"TR\",\"types\":[\"country\",\"political\"]}],\"formatted_address\":\"Trabzon, Trabzon Merkez\\/Trabzon, Turkey\",\"geometry\":{\"bounds\":{\"northeast\":{\"lat\":41.01237,\"lng\":39.8101129},\"southwest\":{\"lat\":40.9735129,\"lng\":39.652407}},\"location\":{\"lat\":41.0026969,\"lng\":39.7167633},\"location_type\":\"APPROXIMATE\",\"viewport\":{\"northeast\":{\"lat\":41.01237,\"lng\":39.8101129},\"southwest\":{\"lat\":40.9735129,\"lng\":39.652407}}},\"partial_match\":true,\"place_id\":\"ChIJiezyawY8ZEARcSuMdMoKOcQ\",\"types\":[\"locality\",\"political\"]},{\"address_components\":[{\"long_name\":\"Trabzon Merkez\",\"short_name\":\"Trabzon Merkez\",\"types\":[\"colloquial_area\",\"political\"]},{\"long_name\":\"Ortahisar\",\"short_name\":\"Ortahisar\",\"types\":[\"administrative_area_level_2\",\"political\"]},{\"long_name\":\"Trabzon\",\"short_name\":\"Trabzon\",\"types\":[\"administrative_area_level_1\",\"political\"]},{\"long_name\":\"Turkey\",\"short_name\":\"TR\",\"types\":[\"country\",\"political\"]}],\"formatted_address\":\"Trabzon Merkez, Ortahisar\\/Trabzon, Turkey\",\"geometry\":{\"bounds\":{\"northeast\":{\"lat\":41.013473,\"lng\":39.8404351},\"southwest\":{\"lat\":40.779737,\"lng\":39.61783399999999}},\"location\":{\"lat\":40.9562156,\"lng\":39.73504020000001},\"location_type\":\"APPROXIMATE\",\"viewport\":{\"northeast\":{\"lat\":41.013473,\"lng\":39.8404351},\"southwest\":{\"lat\":40.779737,\"lng\":39.61783399999999}}},\"partial_match\":true,\"place_id\":\"ChIJaQgS0flHZEARRGeskdj41fo\",\"types\":[\"colloquial_area\",\"political\"]}]"             