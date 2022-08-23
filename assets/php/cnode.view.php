<?php

require_once 'partials/_sessionStart.php';
require_once 'partials/_flashAlert.php';
require_once 'partials/_curl.php';

function review($id): bool|string
{
    $params = array(
        "id"=>$id
    );
    $curl =  new CURL('contributeNode', 'review', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $id = $_GET['id'] ?? null;
        if ($id == null) {
            header('location:error502.php');
        }
        $node = getData($id);
        if($node['sid']==3){
            review($id);
            $node = getData($id);
        }
        loadView(data: $node);
        break;
    case "POST":
        switch ([
            isset($_POST['viewBtn']),
            isset($_POST['approveBtn']),
            isset($_POST['deleteBtn'])
        ]) {
            case [1, 0, 0]:
                $id = $_GET['id'] ?? null;
                if ($id == null) {
                    header('location:error502.php');
                }
                $node = getData($id);
                if($node['sid']==3){
                    review($id);
                    $node = getData($id);
                }
                loadView(data: $node);
                break;
            case [0, 1, 0]:
                $id = $_GET['id'] ?? header('location:error502.php');
                $sid = getData($id)['sid'];
                if($sid == 3){
                    review($id);
                }
                $result = approve($id);
                $result = json_decode($result, true);
                if($result['code'] == 200){
                    $_SESSION['success'] = "Node Approved.";
                    header("location:admin.cnodes.php");
                }else{
                    header("location:error502.php");
                }
                break;
            case [0, 0, 1]:
                $id = $_GET['id'];
                $result = delete($id);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    require_once 'partials/_sessionStart.php';
                    $_SESSION['success'] = "Node request id: {$id} deleted.";
                    header("location:admin.cnodes.php");
                } else {
                    header('location:error500.php');
                }
                break;
            default:
                header('location:error502.php');
                break;
        }
        break;
    default:
        header('location:error501.php');
        break;
}

function loadView($data, $error_msg = ''): void
{
    $maxError = 0.005;
    extract($data);
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>Node Request</title>";
    include_once 'partials/header_2.php';
    include_once 'partials/nav.php';
    echo "<section id='dashboard-section'>";
    include_once 'partials/sidebar.php';
    echo "<div class='content'>"; ?>
    <div>
        <ol class="index-ol">
            <li class="index-box">
                <img src="../images/geoIcon.png" alt="New marker icon." style=" height:inherit">
            </li>
            <li class="index-label">Suggested Marker</li>
            <li class="index-box">
                <img src="../images/oldIcon.png" alt="Old marker icon." style=" height:inherit">
            </li>
            <li class="index-label">Old Marker</li>
        </ol>
    </div>
    <?php
    flashAlert(); ?>
    <div class="row">
        <div class="px-2 col-lg-8">
            <div id="map" class=""></div>
        </div>
        <div id="form-container" class="align-top col-lg-4 bg-light shadow-lg py-3">
            <form action="" id="oldForm" name="oldForm" method="POST" class="row mx-2">
                <h5><?= $node ?></h5>
                <h6>Old:</h6>
                <label for="">Latitude</label>
                <input class="form-control col my-2" type="text" name="lat" id="olat" readonly
                       value="<?= $oldLat ?>">
                <label for="">Longitude</label>
                <input class="form-control col my-2" type="text" name="lng" id="olng" readonly
                       value="<?= $oldLng ?>">
            </form>
            <form action="" id="newForm" name="newForm" method="POST" class="row mx-2">
                <h6>Suggested:</h6>
                <label for="">Latitude</label>
                <input class="form-control col my-2" type="text" name="lat" id="nlat" readonly
                       value="<?= $newLat ?>">
                <label for="">Longitude</label>
                <input class="form-control col my-2" type="text" name="lng" id="nlng" readonly
                       value="<?= $newLng ?>">
                <p class="my-2">Error (Lat: <?= $errorLat ?> <b>&</b> Lng : <?= $errorLng ?>)</p>
                <br>
                <?php
                if ($errorLat > 0.005 || $errorLng > 0.005) {
                    echo "<small class='alert-danger p-2 mb-2 ml-2 mr-2'> Error exceeds maximum of {$maxError}</small>";
                } else {
                    echo "<small class='alert-success p-2 mb-2'> Error subceeds maximum of {$maxError} </small>";
                }
                ?>

                <button type="submit" class="btn btn-outline-success" name="approveBtn">Approve</button>
            </form>
        </div>
    </div>


    <?php
    echo "</div>";
    echo "</section>";
    echo "</body>";
    echo "<script src='../js/reqNode.js'></script>";
    echo '
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>';
    include_once 'partials/adminFooter.php';
}

function getData($id)
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeNode', 'byId', $params);
    $curl->ready();
    $result = $curl->execute();
    if (!$result) {
        header('location:error400.php');
    }
    $result = json_decode($result, true);
    if ((int)$result['code'] == 404 || $result['code'] == 400) {
        header('location:error404.php');
    }
    if ($result['code'] == 500) {
        header('location:error500.php');
    }
    return $result['message'][0];
}

function approve($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeNode', 'approve', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function delete($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeNode', 'delete', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}
