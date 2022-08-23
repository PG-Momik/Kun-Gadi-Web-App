<?php

require_once 'partials/_curl.php';
require_once 'partials/_sessionStart.php';
require_once 'partials/_flashAlert.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        loadView();
        break;
    case "POST":
        $routeNo = $_POST['routeNo'];
        $nodes = $_POST['nodes'];
        $params = array(
            "routeNo" => $routeNo,
            "path" => $nodes
        );

        $curl = new CURL('routes', 'create', $params);
        $curl->ready();
        $result = $curl->execute();
        $result = json_decode($result, true);
            if ($result == null) {
                $_SESSION['error'] = "Could not create route.";
                header('location:route.new.php');
            }
        if ($result['code'] == 200) {
            $_SESSION['success'] = "New route created.";
            header("location:route.new.php");
        } else {
            header('location:error500.php');
        }

        break;
    default:
        break;
}

function loadView($error_msg = '')
{
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>New route</title>";
    include_once 'partials/header_2.php';
    include_once 'partials/nav.php';
    echo "<section id='dashboard-section'>";
    include_once 'partials/sidebar.php'; ?>
    <div class='content-like'>
        <div class="index-container text-center">
            <h4>Start Plotting:</h4>
            <h4>Number of nodes: <span id="click_count">0</span></h4>
        </div>
        <?php
        flashAlert(); ?>
        <div class="row">
            <div class="col-lg-1"></div>
            <div id="map" class="col-lg-10"></div>
            <div class="col-lg-1"></div>
        </div>
        <div class="my-2 row">
            <div class="col-lg-1"></div>
            <button class=" col btn btn-outline-dark" id="clearBtn">Clear Map</button>
            <div class="col-lg-1"></div>
        </div>
        <div class="row my-2">
            <div class="col-lg-1"></div>
            <form action="" method="POST" class="col" id="myForm">

                <div>
                    Enter Route Number
                    <input type="number" name="routeNo" min="0" style="border:1px solid black; padding:4px" required>
                </div>

                <div id="nodesOl">

                </div>
                <div class="row justify-content-center my-2">
                    <button type="submit" class="btn btn-outline-success col-lg-6 hidden" name="addBtn" id="addBtn">Add
                        Route
                    </button>
                </div>
            </form>
            <div class="col-lg-1"></div>
        </div>
    </div>
    </section>
    </body>
    <script src='../js/routeNew.js'></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>;
    <?php
    include_once 'partials/adminFooter.php';
}
