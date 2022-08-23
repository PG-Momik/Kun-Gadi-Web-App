


var ktm = {
  lat: 27.700769,
  lng: 85.30014,
};
var resetBtn = document.getElementById("resetBtn");

var markers;
var marker;
function initMap() {
  var options = {
    zoom: 15,
    center: {
      lat: Number(ktm.lat),
      lng: Number(ktm.lng),
      disableDefaultUI: false,
    },
  };

  map = new google.maps.Map(document.getElementById("map"), options);
  map.addListener("click", (e) => {
    placeMarker(e.latLng);
  });
}

function placeMarker(location) {
  if (marker) {
    marker.setPosition(location);
  } else {
    marker = new google.maps.Marker({
      position: location,
      map: map,
    });
    markers = marker;
  }
  document.getElementById("lat").value = location.lat().toString();
  document.getElementById("lng").value = location.lng().toString();
}

resetBtn.addEventListener("click", () => {
  for (i = 0; i < 1; i++) {
    markers.setMap(null);
  }
  marker = false;
});
