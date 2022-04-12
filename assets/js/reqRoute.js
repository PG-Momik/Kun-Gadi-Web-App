var data = document.getElementById("oldFromCURL");
var oldJsonArray = data.textContent;
var data = document.getElementById("newFromCURL");
var newJsonArray = data.textContent;
var o_place = document.getElementById("o_place");
var n_place = document.getElementById("n_place");

oldJsonArray = JSON.parse(oldJsonArray);
newJsonArray = JSON.parse(newJsonArray);

console.log(oldJsonArray);
console.log(newJsonArray);

var map, newIcon, oldIcon, infoWindow, poly, newPoly;
var old_markers = [];
var new_markers = [];
var size = oldJsonArray.length;
var midPoint = Math.ceil(size / 2) - 1;
var forOldPath = [];
var forNewPath = [];

var i = 0;



function initMap() {
    var options = {
        zoom: 13,
        center: {
            lat: Number(oldJsonArray[midPoint].lat),
            lng: Number(oldJsonArray[midPoint].lng),
            disableDefaultUI: false,
        },
    };

    map = new google.maps.Map(document.getElementById("map"), options);

    newIcon = {
        url: "../images/geoIcon.png",
        scaledSize: new google.maps.Size(25, 40),
    };
    oldIcon = {
        url: "../images/oldIcon.png",
        scaledSize: new google.maps.Size(30, 50),
    };

    //markers for static route
    for (i = 0; i < size; i++) {
        addOldMarker(
            {
                lat: Number(oldJsonArray[i].lat),
                lng: Number(oldJsonArray[i].lng),
            },
            oldJsonArray[i].name,
            oldIcon
        );

        makeOldPath({
            lat: Number(oldJsonArray[i].lat),
            lng: Number(oldJsonArray[i].lng),
        });
    }

    for(i=0;i<newJsonArray.length;i++){
        addNewMarker(
            {
                lat: Number(newJsonArray[i].lat),
                lng: Number(newJsonArray[i].lng),
            },
            newJsonArray[i].name,
            newIcon
        );

        makeNewPath({
            lat: Number(newJsonArray[i].lat),
            lng: Number(newJsonArray[i].lng),
        });
    }


    // showInfo(oldJsonArray[0].name, oldJsonArray[0].lat, oldJsonArray[0].lng);
    // showInfo(oldJsonArray[size - 1].name, oldJsonArray[size - 1].lat, oldJsonArray[size - 1].lng);

    drawPath(forOldPath, "#FF0000", 10);
    drawPath(forNewPath, "#7CFC00",3);

}

showDetail("o_place", oldJsonArray);
showDetail("n_place", newJsonArray);

function makeOldPath(coodinate) {
    forOldPath.push(coodinate);
}


function makeNewPath(coodinate) {
    forNewPath.push(coodinate);
}

function drawPath(forPath, color, width) {
    const flightPath = new google.maps.Polyline({
        path: forPath,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,
        strokeWeight: width,
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


function addOldMarker(position, name, ic) {
    const marker = new google.maps.Marker({
        position,
        map,
        icon:ic,
        animation: google.maps.Animation.DROP,
    });
    marker.addListener("click", () => {
        marker.setIcon(oldIcon);
        map.setZoom(16);
        map.setCenter(marker.getPosition());
        showInfo(name, position.lat, position.lng);
    });
}


function addNewMarker(position, name, ic) {
    const marker = new google.maps.Marker({
        position,
        map,
        icon:ic,
        animation: google.maps.Animation.DROP,
    });
    scaledSize = new google.maps.Size(50, 58);
    marker.addListener("click", () => {
        marker.setIcon(newIcon);
        map.setZoom(16);
        map.setCenter(marker.getPosition());
        showInfo(name, position.lat, position.lng);
    });
}

function showDetail(id, array){
    var container = document.getElementById(id);
    for(i=0;i<array.length; i++){
        var li  = document.createElement("li");
        var node;
        var lat = "Lat: " + array[i].lat;
        var lng = "Lng: " + array[i].lng;
        if(i == 0){
            node = "<h4 style=\"margin-top:8px; margin-bottom:0px;\">Start:"+array[i].name+"</h4>";
        }else if(i == array.length-1){
            node = "<h4 style=\"margin-top:8px; margin-bottom:0px;\">End:"+array[i].name+"</h4>";
        }else{
            node = "<h6 style=\"margin-top:8px; margin-bottom:0px;\">Next:"+array[i].name+"</h6>";
        }
        li.innerHTML = node + lat+ lng;
        container.appendChild(li);
    }
}