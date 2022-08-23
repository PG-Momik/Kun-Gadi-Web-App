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
        $result = getData($id);
        loadView(data: $result);
        break;
    case "POST":
        switch ([
            isset($_POST['viewBtn']),
            isset($_POST['updateBtn']),
            isset($_POST['deleteBtn'])
        ]) {
            case [1, 0, 0]:
                $id = $_GET['id'];
                $result = getData($id);
                loadView(data: $result);
                break;
            case [0, 1, 0]:
                $rid = $_GET['rid'];
                $id = $_GET['id'];
                $nodes = $_POST['nodes'] ?? header('location:error502.php');
                $path = $nodes;
                $params = array(
                    "id" => $id,
                    "path" => $path,
                    "routeNo" => $rid
                );
                $result = update($params);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    $_SESSION['success'] = "Route updated";
                    header("location:route.view.php?id={$id}&rid={$rid}");
                } else {
                    header('location:error500.php');
                }
                break;
            case [0, 0, 1]:
                $id = $_GET['id'];
                $result = delete($id);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    $_SESSION['success'] = "Route deleted successfully";
                    header('location:admin.routes.php');
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
        header('location:error502.php');
        break;
}

function loadView($data, $error = ''): void
{
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>Route</title>";
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
            <li class="index-label">New Marker</li>
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
    <div id="btn-group" class="my-2">
        <form action="" method="POST">
            <input type="button" value="Edit" id="changeBtn" class="btn btn-outline-primary btn-md btnStuff ">
            <input type="button" value="Clear" id="clearBtn" class="btn btn-outline-warning btn-md btnStuff ">
            <input type="submit" value="Delete" name="deleteBtn" id="deleteBtn"
                   class="btn btn-outline-danger btn-md btnStuff ">
        </form>
        <div id="count_container" class="row align-middle hidden">
            <div class="col-lg-6"></div>
            <h4 class="my-2 col-lg-6">Remaining markers: <span id="count_count">x</span></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 detail_card border">
            <h3 class="card_header">Old Nodes:</h3>
            <ol id="o_place" style="list-style: none">
                <?php
                renderList($data); ?>
            </ol>
        </div>
        <div id="newCard" class="col-lg-6 detail_card border hidden">
            <h3 class="card_header">New Nodes:</h3>
            <form action="" method="POST">
                <ol id="n_place">
                </ol>
                <div class="col-12 hidden" id="updateBtn">
                    <button class="btn btn-outline-success col-12" type="submit" name="updateBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    echo "</div>";
    echo "</section>";
    echo "</body>";
    echo "<script src='../js/route.js'></script>";
    echo '
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>' ?>
    <?php
    include_once 'partials/adminFooter.php';
}

function renderList(mixed $data): void
{
    $end = count($data['path']);
    $end = $end - 1;
    foreach ($data['path'] as $key => $node) {
        extract($node);
        echo "<li>";
        if ($key == 0) {
            echo "<h4>Start: <span class='oname'>{$name}</span></h4>";
        } elseif ($key == $end) {
            echo "<h4>End: <span class='oname'>{$name}</span></h4>";
        } else {
            echo "<h4>Next: <span class='oname'>{$name}</span></h4>";
        }
        echo "<div class='row'>
                <h6 class='col-6'>Lat: <p class='olat'>{$latitude}</p></h6>
                <h6 class='col-6'>Lng: <p class='olng'>{$longitude}</p></h6>
                </div>";
        echo "</li>";
    }
}

function getData($id)
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('routes', 'byId', $params);
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

function update(array $params): bool|string
{
    $curl = new CURL('routes', 'update', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function delete($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('routes', 'delete', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

?>