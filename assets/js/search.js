let jsonString = document.getElementById("hiddenP").innerHTML;
let arr = JSON.parse(jsonString);
let jsonArray = arr[0].path;
let size = jsonArray.length;
var map, poly;
var midPoint = Math.ceil(size / 2) - 1;
var forPath = [];
var i;
let start = arr[0].start;
let end = arr[0].end;
// let fare = (totalDistance(jsonArray)/8)*5;
let travelDistance = totalDistance(jsonArray);
let fare = ((travelDistance*10)/7);
let show = `Route from ${start.name} to ${end.name}.`;


let p = document.createElement("p");
p.innerHTML = `Travel Distance = ${Math.ceil(travelDistance)} Km | Expected Bus fare: Rs.${Math.ceil(fare)}`;
document.getElementById("searchResults").appendChild(p)


function totalDistance(nodes){
    let d;
    let td = 0;
    let x;
    let j = 1;

    for(x=0; x<(size-2); x++, j++){
        d = findDistance(nodes[x], nodes[j]);
        // console.log(d); to see KM
        td = td + d;
    }
    return td+2;
}
function findDistance(first, second){
    lon1 =  first.longitude * Math.PI / 180;
    lon2 = second.longitude * Math.PI / 180;
    lat1 = first.latitude* Math.PI / 180;
    lat2 = second.latitude * Math.PI / 180;

    // Haversine formula
    let dlon = lon2 - lon1;
    let dlat = lat2 - lat1;
    let a = Math.pow(Math.sin(dlat / 2), 2)
        + Math.cos(lat1) * Math.cos(lat2)
        * Math.pow(Math.sin(dlon / 2),2);

    let c = 2 * Math.asin(Math.sqrt(a));

    // Radius of earth in kilometers. Use 3956
    // for miles
    let r = 6371;

    // calculate the result
    return(c * r);
}

document.getElementById("showMsg").textContent = show;
function initMap() {
    var options = {
        zoom: 13,
        center: {
            lat: Number(jsonArray[midPoint].latitude),
            lng: Number(jsonArray[midPoint].longitude),
            disableDefaultUI: false,
        },
    };

    map = new google.maps.Map(document.getElementById("map"), options);
    poly = new google.maps.Polyline({
        strokeColor: "#7CFC00",
        strokeOpacity: 1.0,
        strokeWeight: 3,
    });

    for (i = 0; i < size; i++) {
        addMarker(
            {
                lat: Number(jsonArray[i].latitude),
                lng: Number(jsonArray[i].longitude),
            },
            jsonArray[i].name
        );
        makePath({
            lat: Number(jsonArray[i].latitude),
            lng: Number(jsonArray[i].longitude),
        });
    }
    showInfo(jsonArray[0].name, jsonArray[0].latitude, jsonArray[0].longitude);
    showInfo(
        jsonArray[size - 1].name,
        jsonArray[size - 1].latitude,
        jsonArray[size - 1].longitude
    );
    //draws path for static route
    drawPath(forPath);
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
function makePath(coodinate) {
    forPath.push(coodinate);
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



