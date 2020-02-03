var map, infoWindow;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 49.210344, lng: 7.045779},
    zoom: 8
  });
  infoWindow = new google.maps.InfoWindow;

  var marker = new google.maps.Marker({
    map: map,
    label: 'P',
    position: {lat: 49.208713, lng: 7.045065}
});

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      map.setCenter(pos);

      var directionsDisplay;
      var directionsService = new google.maps.DirectionsService();
      var request = {
      origin: pos, 
      destination: new google.maps.LatLng(49.210344, 7.045779),
      travelMode: 'DRIVING'
      }
      
      directionsService.route(request, function(response, status) {
          if (status === 'OK') {
            var directionsRenderer = new google.maps.DirectionsRenderer;
            var directionsService = new google.maps.DirectionsService; 
            
            directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.setMap(map);
            directionsDisplay.setDirections(response);
            directionsDisplay.setPanel(document.getElementById('right-panel')); 
            // For each route, display summary information.
          } else {
              console.log('Directions request failed due to ' + status, response);
          }
      });

    }, function() {
      infoWindow.setPosition(pos);
      infoWindow.open(map);
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    infoWindow.setPosition(pos);
      infoWindow.open(map);
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}