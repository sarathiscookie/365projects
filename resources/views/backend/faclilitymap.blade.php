@extends('layouts.backend')

@section('title', 'Facility Map')

@section('content')
    <div class="content">
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

            <div id="map-canvas" style="width: 800px; height: 500px;">

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
    </div>
@endsection

@section('scripts')
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
        var map;
        var geocoder;
        var marker;
        var people = new Array();
        var latlng;
        var infowindow;

        $(document).ready(function() {
            ViewCustInGoogleMap();
        });

        function ViewCustInGoogleMap() {

            var mapOptions = {
                center: new google.maps.LatLng(50.1085461, 8.6463204),
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

            $.get('/facilitymap/show', function(people){
                for (var i = 0; i < people.geocoord.length; i++) {
                    geocoder = new google.maps.Geocoder();
                    infowindow = new google.maps.InfoWindow();
                    if ((people.geocoord[i].geocoord == null)) {
                        geocoder.geocode({ 'address': people.geocoord[i].street }, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                                marker = new google.maps.Marker({
                                    position: latlng,
                                    map: map,
                                    draggable: false,
                                    html: people.geocoord[i].geocoord,
                                    icon: "images/marker/" + people.geocoord[i].id + ".png"
                                });
                                google.maps.event.addListener(marker, 'click', function(event) {
                                    infowindow.setContent(this.html);
                                    infowindow.setPosition(event.latLng);
                                    infowindow.open(map, this);
                                });
                            }
                            else {
                                alert(people.geocoord[i].street + " -- " + people.geocoord[i].street + ". This address couldn't be found");
                            }
                        });
                    }
                    else {
                        var latlngStr = people.geocoord[i].geocoord.split(",");
                        var lat = parseFloat(latlngStr[0]);
                        var lng = parseFloat(latlngStr[1]);
                        latlng = new google.maps.LatLng(lat, lng);
                        marker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            draggable: false,                   // cant drag it
                            html: people.geocoord[i].geocoord    // Content display on marker click
                            //icon: "images/marker.png"       // Give our own image
                        });
                        //marker.setPosition(latlng);
                        //map.setCenter(latlng);
                        google.maps.event.addListener(marker, 'click', function(event) {
                            infowindow.setContent(this.html);
                            infowindow.setPosition(event.latLng);
                            infowindow.open(map, this);
                        });
                    }
                }
            });

        }

    </script>
@endsection
