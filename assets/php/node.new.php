<?php

require_once 'partials/_curl.php';
require_once 'partials/_sessionStart.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        loadView();
        break;
    case "POST":
        $name =  $_POST['name'];
        $lat= $_POST['lat'];
        $lng = $_POST['lng'];
        $params = array(
            "name"=>$name,
            "lng"=>$lng,
            "lat"=>$lat,
        );
        $result = add($params);
        $result = json_decode($result, true);
        if($result['code'] == 200){
            $_SESSION['success'] = "{$name} added as a node.";
            header('location:admin.nodes.php');
        }else{
            header('location:error502.php');
        }
        break;
    default:
        break;
}


function loadView($error_msg = '')
{
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>New node</title>";
    include_once 'partials/header_2.php';
    include_once 'partials/nav.php';
    echo "<section id='dashboard-section'>";
    include_once 'partials/sidebar.php'; ?>
    <div class='content-like'>
            <h4>Plot Node:</h4>
        <div id="row" class="row">
            <div id="map" class="col-lg-8"></div>
            <div id="detailContainer" class="col-lg-4 px-4">
                <form action="" id="actualForm" name="actualForm" method="POST" class="row">
                    <label for="">Name:</label>
                    <input class="form-control col-12 my-2" type="text" name="name" id="node"
                           placeholder="Enter name here">
                    <label for="">Latitude</label>
                    <input class="form-control col-12 my-2" type="text" name="lat" id="lat" readonly
                           placeholder="Latitude appears here">
                    <label for="">Longitude</label>
                    <input class="form-control col-12 my-2" type="text" name="lng" id="lng" readonly
                           placeholder="Longitude appears here">
                    <input type="submit" name="addBtn" id="addBtn" value="Add Node"
                           class="btn btn-outline-success btn-md btnStuff col-lg-12 col-sm-12 mt-5">
                    <button type="button" name="resetBtn" id="resetBtn" class="btn btn-outline-dark my-2 col-lg-12">Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
    </section>
    </body>
    <script src='../js/nodeNew.js'></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>;
    <?php
    include_once 'partials/adminFooter.php';
}

function add(array $params): bool|string
{
    $curl = new CURL('nodes', 'create', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}


?>



