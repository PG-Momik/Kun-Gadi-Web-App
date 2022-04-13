var data = document.getElementById("dataFromCURL");
var jsonArray = data.textContent;
jsonArray = JSON.parse(jsonArray);
var map, newIcon, infoWindow, poly;
var new_markers = [];
var size = jsonArray.length;
var midPoint = Math.ceil(size / 2) - 1;
var forPath = [];
var i,
  click_count = 0;

var changeBtn,
  clearBtn,
  updateBtn,
  o_place,
  n_place,
  hidden_place,
  count_container,
  count_count,
  updateContainer;
var val;
var secondJsonArray = [];
changeBtn = document.getElementById("changeBtn");
clearBtn = document.getElementById("clearBtn");
deleteBtn = document.getElementById("deleteBtn");
o_place = document.getElementById("o_place");
hidden_place = document.getElementById("hidden_place");
n_place = document.getElementById("n_place");
count_container = document.getElementById("count_container");
count_count = document.getElementById("count_count");
updateContainer = document.getElementById("updateContainer");
updateBtn = document.getElementById("uploadBtn");
count_count.textContent = size;

changeBtn.addEventListener("click", () => {
  count_container.classList.toggle("hidden");
  hidden_place.classList.toggle("hidden");
  updateContainer.classList.toggle("hidden");
});

clearBtn.addEventListener("click", () => {
  clearMarker();
});

uploadBtn.addEventListener("click", (e) => {
  e.preventDefault();
  val = document.getElementById("value");
  val.value = JSON.stringify(secondJsonArray);
  document.forms["myForm"].submit();
});

function initMap() {
  var options = {
    zoom: 13,
    center: {
      lat: Number(jsonArray[midPoint].lat),
      lng: Number(jsonArray[midPoint].lng),
      disableDefaultUI: false,
    },
  };

  map = new google.maps.Map(document.getElementById("map"), options);
  poly = new google.maps.Polyline({
    strokeColor: "#7CFC00",
    strokeOpacity: 1.0,
    strokeWeight: 3,
  });

  //marksers for static route
  for (i = 0; i < size; i++) {
    addMarker(
      {
        lat: Number(jsonArray[i].lat),
        lng: Number(jsonArray[i].lng),
      },
      jsonArray[i].name
    );
    makePath({
      lat: Number(jsonArray[i].lat),
      lng: Number(jsonArray[i].lng),
    });
  }

  //infowindow for first
  showInfo(jsonArray[0].name, jsonArray[0].lat, jsonArray[0].lng);
  //infowindow for last
  showInfo(
    jsonArray[size - 1].name,
    jsonArray[size - 1].lat,
    jsonArray[size - 1].lng
  );
  //draws path for static route
  drawPath(forPath);
  newIcon = {
    url: "../images/geoIcon.png", // url
    scaledSize: new google.maps.Size(25, 40),
  };
  //does onclick things on map
  map.addListener("click", (e) => {
    click_count = click_count + 1;
    if (click_count <= size) {
      count_count.textContent = size - click_count;
      placeMarkerAndPanTo(e.latLng, map);

    }
  });

  //shows old nodes
  showOldDetail(jsonArray);
}

function makePath(coodinate) {
  forPath.push(coodinate);
}

function drawPath(forPath) {
  const flightPath = new google.maps.Polyline({
    path: forPath,
    geodesic: true,
    strokeColor: "#FF0000",
    strokeOpacity: 1.0,
    strokeWeight: 2,
  });
  flightPath.setMap(map);
}

function showInfo(name, lat, lng) {
  var tag = new google.maps.InfoWindow({
    content: name,
  });
  tag.setOptions({
    position: {
      lat: Number(lat),
      lng: Number(lng),
    },
  });
  tag.open({
    anchor: new google.maps.Marker({
      position: {
        lat: Number(lat),
        lng: Number(lng),
      },
      map,
      clickable: true,
    }),
    map,
  });
}

function addMarker(position, name) {
  const marker = new google.maps.Marker({
    position,
    map,
    title: name,
    animation: google.maps.Animation.DROP,
  });
  marker.addListener("click", () => {
    map.setZoom(16);
    map.setCenter(marker.getPosition());
    showInfo(name, position.lat, position.lng);
  });
}

function placeMarkerAndPanTo(latLng, map) {
  poly.setMap(map);
  var path = poly.getPath();
  path.push(latLng);

  var n_marker = new google.maps.Marker({
    position: latLng,
    map: map,
    icon: newIcon,
    animation: google.maps.Animation.DROP,
  });
  map.panTo(latLng);
  secondJsonArray.push({
    name: jsonArray[click_count - 1].name,
    lat: n_marker.getPosition().lat(),
    lng: n_marker.getPosition().lng(),
  });
  new_markers.push(n_marker);
  console.log(click_count);
  console.log(jsonArray.length);
  console.log(jsonArray[click_count-1].name);
  showNewDetail(click_count, jsonArray[click_count-1].name, secondJsonArray[click_count-1].lat,secondJsonArray[click_count-1].lng);
}

function clearMarker() {
  console.log(new_markers);
  for (i = 0; i < new_markers.length; i++) {
    new_markers[i].setMap(null);
  }
  count_count.textContent = size;
  click_count = 0;
  poly.setMap(null);
  poly = null;
  poly = new google.maps.Polyline({
    strokeColor: "#7CFC00",
    strokeOpacity: 1.0,
    strokeWeight: 3,
  });
  document.getElementById("n_place").innerHTML = " ";
  secondJsonArray = [];
}

function showOldDetail(place){
  var o_place_container = document.getElementById("o_place");
  for (var i = 0; i < place.length; i++) {
    var li = document.createElement("li");
    li.style.fontSize = "1rem";
    var head;
    if (i == 0) {
      head =
          "<h4 style='margin-bottom: 0px; margin-top:8px'>Start:" +
          place[i].name +
          "</h4>";
    } else if (i == place.length - 1) {
      head =
          "<h4 style='margin-bottom: 0px; margin-top:8px'>End:" +
          place[i].name +
          "</h4>";
    } else {
      head =
          "<h6 style='margin-bottom: 0px; margin-top:8px'>Next:" +
          place[i].name +
          "</h6>";
    }
    var lat = "Lat: " + place[i].lat;
    var lng = "Lng: " + place[i].lng;
    li.innerHTML = head + lat + " " + lng;
    o_place_container.appendChild(li);
  }
}

function showNewDetail(click_count, name, lat, lng){
  var n_place_container = document.getElementById("n_place");
  var node;
  var lat = "Lat: " + lat;
  var lng = "Lng: " + lng;
  if(click_count == 1){
    node = "<h4 style=\"margin-top:8px; margin-bottom:0px;\">Start:"+name+"</h4>";
  }else if(click_count == jsonArray.length){
    node = "<h4 style=\"margin-top:8px; margin-bottom:0px;\">End:"+name+"</h4>";
  }else{
    node = "<h6 style=\"margin-top:8px; margin-bottom:0px;\">Next:"+name+"</h6>";
  }
  var li = document.createElement("li");
  li.innerHTML = node + lat+ lng;
  n_place_container.appendChild(li);
}