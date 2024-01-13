function initAutocomplete() {
    let lat = $('#latitude').val();
    let lng = $('#longitude').val();
    let map;
    if(lat !== '' && lng !== '') {
        lat = parseFloat(lat);
        lng = parseFloat(lng);

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: lat, lng: lng },
            zoom: 15,
            mapTypeId: 'roadmap',
        });

        new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map,
            title: $('#address').val(),
        });
    } else {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
            mapTypeId: 'roadmap',
        });
    }

    const input = document.getElementById('address');
    const searchBox = new google.maps.places.SearchBox(input);

    map.addListener('bounds_changed', () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

    searchBox.addListener('places_changed', () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        markers.forEach((marker) => {
            marker.setMap(null);
        });

        markers = [];

        const bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log('Returned place contains no geometry');
                return;
            }

            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };

            const position = place.geometry.location;
            const latitude = position.lat();
            const longitude = position.lng();

            $('#longitude').val(longitude);
            $('#latitude').val(latitude);

            markers.push(
                new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                })
            );

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });

        map.fitBounds(bounds);
    });
}

window.initAutocomplete = initAutocomplete;
