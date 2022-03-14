<?php
include 'partials/_utility.php';
if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
} else {
    if (isset($_POST['self'])) {
        if (isset($_POST['updateBtn'])) {
            updtNode($_POST['n_id'], $_POST['n_name'], $_POST['n_longitude'], $_POST['n_latitude']);
            return false;
        } else {
            deltNode($_POST['id']);
            return false;
        }
    } else {
        $condition1 = $_POST['id'] && $_POST['action'] == "Delete";
        $condition2 = $_POST['id'] && $_POST['action'] == "View";
        if ($condition1) {
            deltNode($_POST['id']);
            return false;
        } elseif ($condition2) {
            $ch = curl_init();
            $url = "https://kungadi.000webhostapp.com/Api/index.php?en=node&op=getById";
            $data_array = array("id" => $_POST['id']);
            $data = json_encode($data_array);
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-Type: : application/json'),
            );
            curl_setopt_array($ch, $options);
            $resp = curl_exec($ch);
            curl_close($ch);
            $decoded = json_decode($resp, true);
            if ($decoded['code'] == 200) {
                $data = $decoded['message'];
                include_once 'partials/_html_p1.php';
                echo "<title>Node</title>";
                include_once 'partials/_html_p2.php'; ?>

                <body>
                    <?php include_once 'partials/_nav.php'; ?>
                    <div id="admin-content">
                        <?php include_once 'partials/_sidebar.php'; ?>
                        <style>
                            #comp-container {
                                display: flex;
                            }

                            #map {
                                height: 420px;
                                width: 70%;
                                border: 1px solid black;
                            }

                            #form-container {
                                width: 30%;
                                margin: auto 10px;
                            }
                        </style>
                        <div class="admin-right">
                            <div class="index-container text-center">
                                <p id="dataFromCURL" class="hidden">
                                    <?php echo json_encode($data) ?>
                                </p>
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
                            </div>

                            <div id="comp-container">
                                <div id="map"></div>
                                <div id="form-container">
                                    <form action="" class="smoll-form">
                                        <h5><?= $data['name'] ?></h5>
                                        <div class="form-group">
                                            <label>ID</label>
                                            <input type="text" name="id" class="form-control form-control-sm" readonly value="<?= $data['id'] ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Latitude</label>
                                            <input type="text" name="o_latitude" class="form-control form-control-sm" readonly value="<?= $data['longitude'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Longitude</label>
                                            <input type="text" name="o_longitude" class="form-control form-control-sm" readonly value="<?= $data['latitude'] ?>">
                                        </div>
                                    </form>
                                    <br>
                                    <form action="" method="POST" class="smoll-form hidden">
                                        <h5>New </h5>
                                        <input type="hidden" id="n_id" name="n_id" value="<?= $data['id'] ?>" readonly>
                                        <input type="hidden" id="n_name" name="n_name" value="<?= $data['name'] ?>" readonly>
                                        <input type="hidden" id="n_self" name="self">

                                        <div class="form-group">
                                            <label for="">Latitude</label>
                                            <input type="text" id="n_lat" name="n_latitude" class="form-control form-control-sm" value="" placeholder="Click on map">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Longitude</label>
                                            <input type="text" id="n_lng" name="n_longitude" class="form-control form-control-sm" value="" placeholder="Click on map">
                                        </div>
                                        <div>
                                            <input type="submit" id="n_btn" name="updateBtn" class="btn btn-success btn-sm mt-2" value="Update">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" name="updateBtn" id="editBtn" class="btn btn-primary btn-md">Edit</button>
                                <button type="button" name="clearBtn" id="clearBtn" class="btn btn-warning btn-md">Clear</button>
                                <button type="button" name="deleteBtn" id="deleteBtn" class="btn btn-danger btn-md">Delete</button>
                            </div>
                        </div>

                    </div>
                </body>
                <script src="../js/node.js"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly" defer>
                </script>

                </html>
<?php
            }
        } else {
            echo "Err 400, Resource not found.";
        }
    }
}
