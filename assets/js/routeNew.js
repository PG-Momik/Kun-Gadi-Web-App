let ktm = {
  lat: 27.700769,
  lng: 85.30014,
};
let map, icon, poly;
let markerArray = [];
let nodeArray = [];
let forPath = [];
let click_count = 0,
  i = 0;
let count = document.getElementById("click_count");
let nodesOl = document.getElementById("nodesOl");
let addBtn = document.getElementById("addBtn");
let clearBtn = document.getElementById("clearBtn");



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
  poly = new google.maps.Polyline({
    strokeColor: "#7CFC00",
    strokeOpacity: 1.0,
    strokeWeight: 3,
  });
  map.addListener("click", (e) => {
    placeMarkerAndPanTo(e.latLng, map);
    if(click_count>1){
      addBtn.classList.remove("hidden");
    }
  });
}

clearBtn.addEventListener("click", (e) => {
  clearMarker();
});

function placeMarkerAndPanTo(latLng, map) {
  poly.setMap(map);
  let path;
  path = poly.getPath();
  path.push(latLng);

  let marker = new google.maps.Marker({
    position: latLng,
    map: map,
    animation: google.maps.Animation.DROP,
  });
  map.panTo(latLng);
  let node;
  node = {
    lat: marker.getPosition().lat(),
    lng: marker.getPosition().lng(),
  };

  markerArray.push(marker);
  nodeArray.push(node);
  makeInput(click_count, nodesOl, node.lat, node.lng);
}

function makeInput(i, parent, lat, lng) {

  count.textContent = i + 1;

  let div =  document.createElement("div");
  let div2 = document.createElement("div");
  let div3 = document.createElement("div");

  let inpName = document.createElement("input");
  let inpLat = document.createElement("input");
  let inpLng =  document.createElement("input");

  div.classList.add("my-2", "shadow-lg", "p-2");
  div2.classList.add("inputLabel");
  div3.classList.add("row", "mx-2");

  inpName.setAttribute("placeholder", "Enter name here");
  inpName.setAttribute("required", "true");
  inpName.setAttribute("name", `nodes[${i}][name]`);
  inpName.classList.add("form-control", "col");

  inpLat.setAttribute("required", "true");
  inpLat.setAttribute("name", `nodes[${i}][lat]`);
  inpLat.setAttribute("value", `${lat}`);
  inpLat.classList.add("form-control", "col");

  inpLng.setAttribute("required", "true");
  inpLng.setAttribute("name", `nodes[${i}][lng]`);
  inpLng.setAttribute("value", `${lng}`);
  inpLng.classList.add("form-control", "col");


  if (i == 0) {
    div2.textContent = "Start";
  } else {
    if (i > 0 && i != 1) {
      document.getElementsByClassName("inputLabel")[i - 1].textContent =
        "Node " + i;
    }
    div2.textContent = "End";
  }

  div3.appendChild(inpName);
  div3.appendChild(inpLat);
  div3.appendChild(inpLng);
  div.appendChild(div2);
  div.appendChild(div3)
  parent.appendChild(div);
  click_count = click_count + 1;
}

function clearMarker() {
  count.textContent = 0;
  for (i = 0; i < markerArray.length; i++) {
    markerArray[i].setMap(null);
  }
  click_count = 0;
  poly.setMap(null);
  markerArray = [];
  nodeArray = [];
  nodesOl.innerHTML = "";
  addBtn.classList.add("hidden");
  poly = null;
  poly = new google.maps.Polyline({
    strokeColor: "#7CFC00",
    strokeOpacity: 1.0,
    strokeWeight: 3,
  });
}
