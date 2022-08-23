<?php
require_once 'partials/_sessionStart.php';
loadAdmin();

function loadAdmin(): void{?>
    <?php include_once 'partials/header_1.php';?>
    <title>Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <script src = '../js/dashboard.js' defer></script>
    <?php include_once 'partials/header_2.php'?>
    <?php include_once 'partials/nav.php'; ?>
    <section id="dashboard-section">
        <?php include_once 'partials/sidebar.php'?>

        <div class="content">
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
    </section>
<?php }?>