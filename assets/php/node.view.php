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
        $node = getData($id);
        loadView(data: $node);
        break;
    case "POST":
        switch ([
            isset($_POST['viewBtn']),
            isset($_POST['updateBtn']),
            isset($_POST['deleteBtn'])
        ]) {
            case [1, 0, 0]:
                $id = $_GET['id'];
                $node = getData($id);
                loadView(data: $node);
                break;
            case [0, 1, 0]:
                $id = $_GET['id'] ?? header('location:error502.php');
                $name = $_POST['name'];
                $lng = $_POST['n_longitude'];
                $lat = $_POST['n_latitude'];
                $params = array(
                    "id" => $id,
                    "name" => $name,
                    "lng" => $lng,
                    "lat" => $lat
                );
                $result = update($params);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    $_SESSION['success'] = "Node updated.";
                    header("location:node.view.php?id={$id}");
                } else {
                    header('location:error500.php');
                }
                break;
            case [0, 0, 1]:
                $id = $_GET['id'];
                $result = delete($id);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    require_once 'partials/_sessionStart.php';
                    $_SESSION['success'] = "Node id: {$id} deleted.";
                    header("location:admin.nodes.php");
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


function loadView($data, $error_msg = ''): void
{
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>Node</title>";
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
        <div id="map" class="col-lg-8 bordered"></div>
        <div id="form-container" class="col-lg-4">
            <form action="" method="POST" id="oldForm">
                <h5><?= $data['name'] ?></h5>
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" id='id' name="id" class="form-control form-control-sm"
                           value="<?= $data['id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Latitude</label>
                    <input type="text" id='o_lat' name="o_lat" class="form-control form-control-sm"
                           value="<?= $data['latitude']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Longitude</label>
                    <input type="text" id='o_lng' name="o_lng" class="form-control form-control-sm"
                           value="<?= $data['longitude']; ?>" readonly>
                </div>
                <div class="mt-2">
                    <input type="submit" name="deleteBtn" id="deleteBtn" class="btn btn-outline-danger col-12"
                           value="Delete">
                </div>
            </form>
            <form action="" method="POST" class="hidden" id="newForm">
                <h5>New </h5>
                <div class="form-group">
                    <input type="text" id="n_name" name="name" class="form-control form-control-sm"
                           value="<?= $data['name']; ?>"
                           placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Latitude</label>
                    <input type="text" id="n_lat" name="n_latitude" class="form-control form-control-sm" value=""
                           placeholder="Click on map">
                </div>
                <div class="form-group">
                    <label for="">Longitude</label>
                    <input type="text" id="n_lng" name="n_longitude" class="form-control form-control-sm" value=""
                           placeholder="Click on map">
                </div>
                <div>
                    <input type="submit" id="n_btn" name="updateBtn" class="btn btn-outline-success mt-2 col-12"
                           value="Update">
                </div>
            </form>
            <div class="mt-2 row mx-0">
                <button type="button" name="editBtn" id="editBtn" class="btn btn-outline-primary col-lg-6 px-2">Edit
                </button>
                <button type="button" name="clearBtn" id="clearBtn" class="btn btn-outline-dark col-lg-6 px-2">Clear
                </button>
            </div>
        </div>
    </div>
    <?php
    echo "</div>";
    echo "</section>";
    echo "</body>";
    echo "<script src='../js/node.js'></script>";
    echo '
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly"
        defer>
    </script>';
    include_once 'partials/adminFooter.php';
}

function renderForm($data): void
{
    extract($data)
    ?>
    <form action="" method="POST"
          class="col-lg-4 col-md-8 col-sm-12 mx-auto bg-white shadow-lg mt-4"
          id="registerForm">
        <?php
        flashAlert(); ?>
        <h2><?= $name ?></h2>
        <div class="form-group col-lg-12 mb-2">
            <label for="">ID:</label>
            <input type="text" name='id' class="form-control" readonly value="<?= $id ?>">
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Role ID:</label>
            <input type="number" name='rid' class="form-control" min='1' max='3' value="<?= $role_id ?>">
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Username:</label>
            <?php
            if (isset($error_msg['username'])) {
                echo "<input type='text' name='username' class='form-control is-invalid p-2' id='username'
                            placeholder='Username' value='{$name}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['username']}</small>";
            } else {
                echo "<input type='text' name='username' class='form-control p-2' id='username'
                            placeholder='Username' value='{$name}'>";
            } ?>
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Phone:</label>
            <?php
            if (isset($error_msg['phone'])) {
                echo "<input type='text' name='phone' class='form-control is-invalid p-2' id='phone'
                           placeholder='Phone' value='{$phone}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['phone']}</small>";
            } else {
                echo "<input type='text' name='phone' class='form-control p-2' id='phone'
                           placeholder='Phone' value='{$phone}'>";
            } ?>
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Email:</label>
            <?php
            if (isset($error_msg['email'])) {
                echo "<input type='email' name='email' class='form-control is-invalid p-2' id='email'
                           placeholder='Email' value='{$email}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['email']}</small>";
            } else {
                echo "<input type='email' name='email' class='form-control p-2' id='email'
                           placeholder='email' value='{$email}'>";
            } ?>
        </div>
        <div class="form-group row mt-3">
            <div class="col-lg-6">
                <input type="submit" name="updateBtn" id="" value="Update" class="btn btn-outline-primary col-12">
            </div>
            <div class="col-lg-6">
                <input type="submit" name="deleteBtn" id="" value="Delete" class="btn btn-outline-danger col-12">
            </div>
        </div>
    </form>
    <?php
}

function getData($id)
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('nodes', 'byId', $params);
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

function promote($id): void
{
    if ($id == 1) {
        $_SESSION['error'] = "Cannot promote user further";
        header('location:admin.user.php');
    }
    $params = array(
        "id" => $id
    );
    $curl = new CURL('users', 'promote', $params);
    $curl->ready();
    $result = $curl->execute();
    $result = json_decode($result, true);
    if ($result['code'] == 200) {
        $_SESSION['success'] = "User promoted.";
        header('location:admin.user.php');
    } else {
        header('location:error502.php');
    }
}

function update(array $params): bool|string
{
    $curl = new CURL('nodes', 'update', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function delete($id): bool|string
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('nodes', 'delete', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}
