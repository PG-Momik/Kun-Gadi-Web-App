let nlat = document.getElementById('nlat').value;
let nlng = document.getElementById('nlng').value;
let olat = document.getElementById('olat').value;
let olng = document.getElementById('olng').value;

console.log(olat);
console.log(olng);
let map, newIcon;
let markers = [];

var count = 1;



function initMap() {
  var options = {
    zoom: 17,
    center: {
      lat: Number(olat),
      lng: Number(olng),
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
