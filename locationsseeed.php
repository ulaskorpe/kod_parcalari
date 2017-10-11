
        $Location = new  Location();
        $Location->lat = 48.1639016;
        $Location->lon = 16.3831412;
        $Location->address = 'Polizeiinspektion Favoritenstraße, Favoritenstraße, Vienna, Austria';
        $Location->place_id = 'ChIJuUAM6pWpbUcRGvKU-AhpIdw';//$faker->linuxPlatformToken;
        $Location->save();

        $Location = new Location();
        $Location->lat = 48.1604766;
        $Location->lon = 16.3819909;
        $Location->address = 'Favoriten, Vienna, Austria';
        $Location->place_id = 'ChIJ1enZ4YgHbUcR59kO2oYuir8';//$faker->linuxPlatformToken;
        $Location->save();

        $endLocation = new  Location();
        $endLocation->lat = 48.1997418;
        $endLocation->lon = 16.2679321;
        $endLocation->address = 'Penzing, Vienna, Austria';// $faker->address;
        $endLocation->place_id = 'ChIJqbFtTRIIbUcRxUMIEXpOlRQ';// $faker->linuxPlatformToken;
        $endLocation->save();
