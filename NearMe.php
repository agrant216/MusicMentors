
<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
    <script src="assets\js\vendor\jquery.js"></script>
  </head>
  <body>
    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 11
        });
        console.log(map);
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            var home = new google.maps.Marker({
              position: pos,
              map: map,
              title: 'home'
            });

            infoWindow.setContent('<b>My Location</b>');
            infoWindow.open(map, home);
            home.addListener('click', function() {
              infoWindow.open(map, home);
            });
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, map);

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(centerControlDiv);

      $.ajax({
          url:'assets/Markers.json',
          type:'HEAD',
          error: function()
          {
            //file not exists
          },
          success: function()
          {
            setMarkers(map);
          }
        });
    }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
      function createMarker(map,pos,info){
        var infowindow = new google.maps.InfoWindow({
          content: info
        });

        var marker = new google.maps.Marker({
          position: pos,
          map: map,

        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
      function CenterControl(controlDiv, map) {
          // Set CSS for the control border.
          var controlUI = document.createElement('div');
          controlUI.style.backgroundColor = '#fff';
          controlUI.style.border = '2px solid #fff';
          controlUI.style.borderRadius = '3px';
          controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
          controlUI.style.cursor = 'pointer';
          controlUI.style.marginBottom = '18px';
          controlUI.style.textAlign = 'center';
          controlUI.title = 'Click to Refresh Appointment Markers';
          controlDiv.appendChild(controlUI);

          // Set CSS for the control interior.
          var controlText = document.createElement('div');
          controlText.style.color = 'rgb(25,25,25)';
          controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
          controlText.style.fontSize = '16px';
          controlText.style.lineHeight = '38px';
          controlText.style.paddingLeft = '5px';
          controlText.style.paddingRight = '5px';
          controlText.innerHTML = 'Refresh Markers';
          controlUI.appendChild(controlText);

          // Setup the click event listeners: simply set the map to Chicago.
          controlUI.addEventListener('click', function() {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                }
                $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "includes/ajax/getMarkers.php", //Relative or absolute path to response.php file
                  data: pos,
                  success: function(data) {
                    console.log(data);
                    setMarkers(map);
                  },
                  error: function(ts) { alert(ts.responseText);}
                });
              });
              }

          });
        }
        function setMarkers(map){
          $.getJSON( "assets/Markers.json", function( data ) {
              //var markers = [];
              $.each( data, function( key, val ) {
                var pos = {lat:parseFloat(val["lat"]),lng:parseFloat(val["lng"])};
                createMarker(map,pos,val["marker"]);
              });
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApgsOVdVnT6BvjyR_baJ4-70YRn6YrERU&callback=initMap">
    </script>
  </body>
</html>
