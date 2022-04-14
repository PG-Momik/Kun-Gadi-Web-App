var ktm = {
  lat: 27.700769,
  lng: 85.30014,
};
var map, icon, poly;
var markerArray = [];
var nodeArray = [];
var forPath = [];
var click_count = 0,
  i = 0;
var count = document.getElementById("click_count");
var myForm = document.getElementById("actualForm");
var resetBtn = document.getElementById("resetBtn");
var backBtn = document.getElementById("backBtn");
var doneBtn = document.createElement("input");
doneBtn.setAttribute("type", "submit");
{
  /* <input type="submit" name="" id="uploadBtn" value="Update" class="btn btn-success btn-md btnStuff" style="width: 100%"> */
}
doneBtn.setAttribute("name", "add");
doneBtn.setAttribute("value", "Add Route");
doneBtn.classList.add("btn", "btn-md", "btn-success", "btnStuff");

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
  });
}

resetBtn.addEventListener("click", (e) => {
  clearMarker();
});
function placeMarkerAndPanTo(latLng, map) {
  poly.setMap(map);
  var path;
  path = poly.getPath();
  path.push(latLng);

  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
    animation: google.maps.Animation.DROP,
  });
  map.panTo(latLng);
  var node;
  node = {
    lat: marker.getPosition().lat(),
    lng: marker.getPosition().lng(),
  };

  markerArray.push(marker);
  nodeArray.push(node);
  makeInput(click_count, myForm, node.lat, node.lng);
}

function makeInput(i, parent, lat, lng) {
  count.textContent = i + 1;
  var div1 = document.createElement("div");
  var div2 = document.createElement("div");
  var div3 = document.createElement("div");
  var span1 = document.createElement("span");
  var inp1 = document.createElement("input");
  var p1 = document.createElement("p");
  var p2 = document.createElement("p");

  div1.classList.add("input-group", "input-group-sm", "row");
  div2.classList.add("col-lg-4");
  div2.style.display = "flex";
  div2.style.paddingRight = "4px";
  div3.classList.add("input-group-prepend");
  span1.classList.add("input-group-text", "inputLabel");

  if (i == 0) {
    span1.textContent = "Start";
  } else {
    if (i > 0 && i != 1) {
      document.getElementsByClassName("inputLabel")[i - 1].textContent =
        "Node " + i;
    }
    span1.textContent = "End";
  }
  inp1.setAttribute("type", "text");
  inp1.setAttribute("required", "true");

  inp1.classList.add("form-control", "inputName");
  inp1.setAttribute("placeholder", "Enter name here");
  inp1.style.height = "40px";

  p1.classList.add("form-control", "col-lg-4", "align-middle", "inputLat");
  p1.style.height = "40px";
  p1.style.padding = "8px";
  p1.textContent = lat;

  p2.classList.add("form-control", "col-lg-4", "align-middle", "inputLat");
  p2.style.height = "40px";
  p2.style.padding = "8px";
  p2.textContent = lng;
  div3.appendChild(span1);
  div2.appendChild(div3);
  div2.appendChild(inp1);
  div1.appendChild(div2);
  div1.appendChild(p1);
  div1.appendChild(p2);
  parent.appendChild(div1);
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
  myForm.innerHTML = "";
  poly = null;
  poly = new google.maps.Polyline({
    strokeColor: "#7CFC00",
    strokeOpacity: 1.0,
    strokeWeight: 3,
  });
}
