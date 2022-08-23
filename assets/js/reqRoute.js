let onames = document.getElementsByClassName("oname");
let olats = document.getElementsByClassName("olat");
let olngs = document.getElementsByClassName("olng");
let osize = onames.length;
let oldJsonArray = [];
for (let i = 0; i < osize; i++) {
    oldJsonArray[i] = {
        "name": onames[i].textContent,
        "lat": olats[i].textContent,
        "lng": olngs[i].textContent,
    };
}

let nnames = document.getElementsByClassName("nname");
let nlats = document.getElementsByClassName("nlat");
let nlngs = document.getElementsByClassName("nlng");
let nsize = nnames.length;
let newJsonArray = [];
for (let i = 0; i < nsize; i++) {
    newJsonArray[i] = {
        "name": nnames[i].textContent,
        "lat": nlats[i].textContent,
        "lng": nlngs[i].textContent,
    };
}

let map, newIcon, oldIcon;
let size = oldJsonArray.length;
let midPoint = Math.ceil(size / 2) - 1;
let forOldPath = [];
let forNewPath = [];
let i = 0;


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


    drawPath(forOldPath, "#FF0000", 10);
    drawPath(forNewPath, "#7CFC00",3);

}

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
