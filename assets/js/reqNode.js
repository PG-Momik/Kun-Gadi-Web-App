var data = document.getElementById("dataFromCURL");
var jsonArray = data.textContent;
jsonArray = JSON.parse(jsonArray);
let map, newIcon;
let markers = [];

var count = 1;

var olat = jsonArray.o_lat;
var olng = jsonArray.o_lng;

var nlat = jsonArray.n_lat;
var nlng = jsonArray.n_lng;

function initMap() {
  var options = {
    zoom: 17.5,
    center: {
      lat: (Number(olat) + Number(nlat)) / 2,
      lng: (Number(olng) + Number(nlng)) / 2,
    },
  };

  map = new google.maps.Map(document.getElementById("map"), options);
  oldMarker({
    lat: Number(olat),
    lng: Number(olng),
  });

  newIcon = {
    url: "../images/geoIcon.png", // url
    scaledSize: new google.maps.Size(25, 40),
  };
  newMarker({
    lat: Number(nlat),
    lng: Number(nlng),
  });
}

function oldMarker(position, flag) {
  const marker = new google.maps.Marker({
    position,
    map,
  });
  markers[0] = marker;
}

function newMarker(position, flag) {
  const marker = new google.maps.Marker({
    position,
    map,
    icon: newIcon,
  });
}

document.getElementById("backBtn").addEventListener("click", (e) => {
  history.back();
});
