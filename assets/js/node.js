// let map;
// let markers = [];
// var count = 1;

// var n_lat;
// var n_lng;

// var olat = "<?= $node['longitude'] ?>";
// var olng = "<?= $node['latitude'] ?>";

// var nlat, nlng;
// var newIcon;

// function initMap() {
//   var options = {
//     zoom: 18,
//     center: {
//       lat: Number(olat),
//       lng: Number(olng),
//     },
//   };

//   map = new google.maps.Map(document.getElementById("map"), options);
//   oldMarker(
//     {
//       lat: Number(olat),
//       lng: Number(olng),
//     },
//     0
//   );
//   map.addListener("click", (e) => {
//     var nlat = e.latLng.lat();
//     var nlng = e.latLng.lng();
//     if (count == 1) {
//     } else {
//       clearMarker();
//     }
//     count++;
//     newMarker(
//       {
//         lat: Number(nlat),
//         lng: Number(nlng),
//       },
//       1
//     );
//   });

//   newIcon = {
//     url: "../images/geoIcon.png", // url
//     scaledSize: new google.maps.Size(50, 50),
//   };
// }

// function oldMarker(position, flag) {
//   const marker = new google.maps.Marker({
//     position,
//     map,
//   });
//   markers[0] = marker;
// }

// function newMarker(position, flag) {
//   const marker = new google.maps.Marker({
//     position,
//     map,
//     icon: newIcon,
//   });
//   markers[1] = marker;
//   n_lat = document.getElementById("n_lat");
//   n_lng = document.getElementById("n_lng");
//   n_lat.value = position.lat;
//   n_lng.value = position.lng;
// }

// function clearMarker() {
//   markers[1].setMap(null);
// }

// var editBtn = document.getElementById("editBtn");
// var resetBtn = document.getElementById("resetBtn");
// editBtn.addEventListener("click", (e) => {
//   var changeForm = document.getElementsByClassName("smoll-form")[1];
//   changeForm.classList.toggle("hidden");
//   if (editBtn.innerText == "Edit") {
//     editBtn.innerText = "Off";
//   } else {
//     editBtn.innerText = "Edit";
//   }
// });
// resetBtn.addEventListener("click", (e) => {
//   clearMarker();
//   document.getElementById("n_lat").value = "";
//   document.getElementById("n_lng").value = "";
// });

var data = document.getElementById("dataFromCURL");
var jsonArray = data.textContent;
jsonArray = JSON.parse(jsonArray);

let map;
let markers = [];
var count = 1;

var n_lat;
var n_lng;

var olat = jsonArray.longitude;
var olng = jsonArray.latitude;

var nlat, nlng;
var newIcon;

function initMap() {
  var options = {
    zoom: 18,
    center: {
      lat: Number(olat),
      lng: Number(olng),
    },
  };

  map = new google.maps.Map(document.getElementById("map"), options);
  oldMarker(
    {
      lat: Number(olat),
      lng: Number(olng),
    },
    0
  );
  map.addListener("click", (e) => {
    var nlat = e.latLng.lat();
    var nlng = e.latLng.lng();
    if (count == 1) {
    } else {
      clearMarker();
    }
    count++;
    newMarker(
      {
        lat: Number(nlat),
        lng: Number(nlng),
      },
      1
    );
  });

  newIcon = {
    url: "../images/geoIcon.png", // url
    scaledSize: new google.maps.Size(25, 40),
  };
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
  markers[1] = marker;
  n_lat = document.getElementById("n_lat");
  n_lng = document.getElementById("n_lng");
  n_lat.value = position.lat;
  n_lng.value = position.lng;
}

function clearMarker() {
  markers[1].setMap(null);
}

var editBtn = document.getElementById("editBtn");
var resetBtn = document.getElementById("clearBtn");
editBtn.addEventListener("click", (e) => {
  var changeForm = document.getElementsByClassName("smoll-form")[1];
  changeForm.classList.toggle("hidden");
  if (editBtn.innerText == "Edit") {
    editBtn.innerText = "Off";
  } else {
    editBtn.innerText = "Edit";
  }
});
resetBtn.addEventListener("click", (e) => {
  clearMarker();
  document.getElementById("n_lat").value = "";
  document.getElementById("n_lng").value = "";
});
