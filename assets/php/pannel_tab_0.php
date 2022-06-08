<?php include_once 'partials/_html_p1.php'; ?>
<title>Dashboard</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
<?php include_once 'partials/_html_p2.php'; ?>
<?php include_once 'partials/_sessionStart.php'; ?>
<?php

$ch =  curl_init();
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
$url  = "https://kungadi.000webhostapp.com/Api/index.php?en=user&op=getDashboardInfo";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);
curl_close($ch);
$decoded = json_decode($resp, true);
?>


<body>
  <?php include_once 'partials/_nav.php'; ?>
  <div id="admin-content">
    <?php include_once 'partials/_sidebar.php'; ?>
    <?php if ($decoded['code'] == 200) {
      $data = $decoded['message'];
    ?>
      <div class="admin-right">
        <p id="dataFromCURL" class="hidden">
          <?php echo json_encode($data) ?>
        </p>
        <!-- row1   -->
        <div class="row">
          <!-- bar -->
          <div class="col-lg-6">
            <h2>User Stats</h2>
            <canvas id="chart_one"></canvas>
          </div>
          <div class="col-lg-6 row">
            <!-- batta1 -->
            <div class="col-lg-12 mb-2">
              <div class="card">
                <div class="card-header">
                  <h3> Node Stats</h3>
                </div>
                <div class="card-body">
                  <p class="card-text">Number of accepted Nodes: <span id="no_of_nodes" class="ali_thulo"></span></p>
                </div>
              </div>
            </div>
            <!-- batta2 -->
            <div class="col-lg-12 mb-2">
              <div class="card">
                <div class="card-header">
                  <h3>Route Stats</h3>
                </div>
                <div class="card-body">
                  <p class="card-text">Number of accepted Routes: <span id="no_of_routes" class="ali_thulo"></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-6  text-center">
            <h3>Node contributions</h3>
            <canvas id="chart_two" style="padding:5vw"></canvas>
          </div>
          <div class="col-lg-6  text-center">
            <h3>Route contribitons</h3>
            <canvas id="chart_three" style="padding:5vw"></canvas>
          </div>

        </div>
      </div>
    <?php } else {
      echo "Something went wrong. Please try again.";
    }
    ?>
  </div>
</body>
<script src="../js/dashboard.js"></script>
<style>
  .ali_thulo {
    font-size: 1.8rem;
    font-weight: 700;
  }
</style>

</html>