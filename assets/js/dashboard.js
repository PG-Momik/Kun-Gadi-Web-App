getDashboardData();
function getDashboardData() {
    var xhr = new XMLHttpRequest();
    var url = 'http://localhost/NewGadi/index.php?en=users&op=getDashboardData';
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify({id:"1"}));
    // function execute after request is successful
    xhr.onreadystatechange = function () {
        let resp;
        if (this.readyState == 4 && this.status == 200) {
            resp = JSON.parse(this.responseText);
            if (resp.code == 200) {
                showDashboard(resp.message);
                return;
            }
            showError();
        }
    }
    // Sending our request
    xhr.send();
}

function showDashboard(jsonArray) {
    console.log(jsonArray);
    generateUserGraph(jsonArray.users, jsonArray.admins, jsonArray.masters);
    generateNodeContsGraph(
        jsonArray.contNUnreview,
        jsonArray.contNReview,
        jsonArray.contNApprove
    );
    generateRouteContsGraph(
        jsonArray.contRUnreview,
        jsonArray.contRReview,
        jsonArray.contRApprove
    );
    document.getElementById("no_of_nodes").textContent = jsonArray.nodes;
    document.getElementById("no_of_routes").textContent = jsonArray.routes;

    function generateUserGraph(nUser, nAdmin, nMaster) {
        let barGraph = document.getElementById("chart_one").getContext("2d");
        let usersChart = new Chart(barGraph, {
            type: "bar",
            data: {
                labels: ["User", "Admin", "Master"],
                datasets: [
                    {
                        label: "User Stat",
                        data: [nUser, nAdmin, nMaster],
                        backgroundColor: ["#fff", "#39adf5", "#ace1af"],
                        borderWidth: 1,
                        borderColor: "#272727",
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    }

    function generateNodeContsGraph(nUnreviewed, nReviewed, nApproved) {
        let donut_one = document.getElementById("chart_two").getContext("2d");
        let nodeContriution = new Chart(donut_one, {
            type: "doughnut",
            data: {
                labels: ["Unreviewed", "Reviewed", "Approved"],
                datasets: [
                    {
                        label: "User Stat",
                        data: [nUnreviewed, nReviewed, nApproved],
                        backgroundColor: ["#fff", "#39adf5", "#ace1af"],
                        borderWidth: 1,
                        borderColor: "#272727",
                    },
                ],
            },
            options: {},
        });
    }

    function generateRouteContsGraph(nUnreviewed, nReviewed, nApproved) {
        let donut_two = document.getElementById("chart_three").getContext("2d");
        let routeContriution = new Chart(donut_two, {
            type: "doughnut",
            data: {
                labels: ["Unreviewed", "Reviewed", "Approved"],
                datasets: [
                    {
                        label: "User Stat",
                        data: [nUnreviewed, nReviewed, nApproved],
                        backgroundColor: ["#fff", "#39adf5", "#ace1af"],
                        borderWidth: 1,
                        borderColor: "#272727",
                    },
                ],
            },
            options: {},
        });
    }
}

function showError(){
    console.log("error")
}