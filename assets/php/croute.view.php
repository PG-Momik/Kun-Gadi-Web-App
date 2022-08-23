<?php

require_once 'partials/_sessionStart.php';
require_once 'partials/_flashAlert.php';
require_once 'partials/_curl.php';


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $id = $_GET['id'] ?? null;
        if ($id == null) {
            header('location:error502.php');
        }
        $data = getData($id);
        if ($data['sid'] == 3) {
            review($id);
            $data = getData($id);
        }
        loadView(data: $data);
        break;
    case "POST":
        switch ([isset($_POST['viewBtn']), isset($_POST['approveBtn']), isset($_POST['deleteBtn'])]) {
            case [1, 0, 0]:
                $id = $_GET['id'] ?? null;
                if ($id == null) {
                    header('location:error502.php');
                }
                $route = getData($id);

                if ($route['sid'] == 3) {
                    review($id);
                    $route = getData($id);
                }
                loadView(data: $route);
                break;
            case [0, 1, 0]:
                $id = $_GET['id'];
                $sid = getData($id)['sid'];
                if ($sid == 3) {
                    review($id);
                }
                $result = approve($id);
                $arr = explode(',', $result);
                $codeArr = explode(":", $arr[0]);
                $code = $codeArr[1];
                if($code == 200) {
                    $_SESSION['success'] = "Route request id: {$id} approved";
                    header('location:admin.croutes.php');
                }else{
                    header('location:error502.php');
                }
                break;
            case [0, 0, 1]:
                $id = $_GET['id'];
                $result = delete($id);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    require_once 'partials/_sessionStart.php';
                    $_SESSION['success'] = "Route request id: {$id} deleted.";
                    header("location:admin.croutes.php");
                } else {
                    header('location:error500.php');
                }
                break;
            default:
                break;
        }
        break;
    default;
        break;
}


function loadView($data): void
{
    extract($data);
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>Route Request</title>";
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
    <div id="row" class="row">
        <div class="col-lg-1"></div>
        <div id="map" class="col-lg-10 bordered"></div>
        <div class="col-lg-1"></div>
    </div>
    <h4 class="mt-4">Details</h4>
    <div class="row">
        <div class="col-lg-6 detail_card border">
            <h5 class="card_header">Old Nodes:</h5>
            <ol id="o_place" style="list-style: none">
                <?php
                renderList($nPath, 'oname', 'olat', 'olng'); ?>
            </ol>
        </div>
        <div id="newCard" class="col-lg-6 detail_card border">
            <h5 class="card_header">New Nodes:</h5>
            <form action="" method="POST">
                <ol id="n_place" class='col-lg-12' style="list-style: none">
                    <?php
                    renderList($crPath, 'nname', 'nlat', 'nlng'); ?>
                </ol>
                <ol class="mx-4">
                    <button type="submit" class="btn btn-outline-success col-lg-12" name="approveBtn">Approve</button>
                </ol>
            </form>
        </div>
    </div>

    <?php
    echo "</div>";
    echo "</section>";
    echo "</body>";
    echo "<script src='../js/reqRoute.js'></script>";
    echo '
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>' ?>
    <?php
    include_once 'partials/adminFooter.php';
}

function getData($id)
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeRoute', 'byId', $params);
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

function review($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeRoute', 'review', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function approve($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeRoute', 'approve', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function delete($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('contributeRoute', 'delete', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function renderList($path, $classN, $classLat, $classLng): void
{
    $end = count($path);
    $end = $end - 1;
    foreach ($path as $key => $node) {
        extract((array)$node);
        echo "<li>";
        if ($key == 0) {
            echo "<h5>Start: <span class=\"$classN\">{$name}</span></h5>";
        } elseif ($key == $end) {
            echo "<h5>End: <span class=\"$classN\">{$name}</span></h5>";
        } else {
            echo "<h5>Next: <span class=\"$classN\">{$name}</span></h5>";
        }
        echo "<div class='row'>
                <h6 class='col-6'>Lat: <p class=\"$classLat\">{$latitude}</p></h6>
                <h6 class='col-6'>Lng: <p class=\"$classLng\">{$longitude}</p></h6>
                </div>";
        echo "</li>";
    }
}
