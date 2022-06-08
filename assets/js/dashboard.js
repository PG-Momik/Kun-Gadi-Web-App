var data = document.getElementById("dataFromCURL");
var jsonArray = data.textContent;
jsonArray = JSON.parse(jsonArray);
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
