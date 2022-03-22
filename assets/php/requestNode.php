<?php

include 'partials/_utility.php';
if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
} else {
    if (isset($_POST['updateBtn']) && isset($_POST['self'])) {
        apprNode($_POST['n_id'], $_POST['c_id'], $_POST['s_id']);
        return false;
    } else {
        $condition3 = $_POST['action'] == "Delete" ? true : false;
        $condition2 = $_POST['action'] == "Approve" ? true : false;
        $condition1 = $_POST['action'] == "View" ? true : false;
        if ($condition3) {
            deltNReq($_POST['id']);
            return false;
        } elseif ($condition2) {
            apprNode($_POST['id'], $_POST['cid'], $_POST['sid']);
            return false;
        } elseif ($condition1) {
            $ch = curl_init();
            $url = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_node&op=readContributionsById";
            $data_array = array(
                "id" => $_POST['id'],
                "admin" => true,
            );
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
                $data = $decoded['message'][0];
                include_once 'partials/_html_p1.php';
                echo "<title>Request</title>";
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
                                        <li class="index-label">Suggested Marker</li>
                                        <li class="index-box">
                                            <img src="../images/oldIcon.png" alt="Old marker icon." style=" height:inherit">
                                        </li>
                                        <li class="index-label">Old Marker</li>
                                    </ol>
                                </div>
                                <div>
                                </div>
                            </div>

                            <div id="comp-container">
                                <div id="map"></div>
                                <div id="form-container" class="align-top">

                                    <h4><?= $data['name'] ?></h4>
                                    <h5>Old</h5>
                                    <p class="form-group">
                                        Latitude:
                                        <input type="text" id="o_lat" name="o_lat" class="form-control form-control-sm" value="<?= $data['o_lat'] ?>">
                                    </p>
                                    <p class="form-group">
                                        Longitude:
                                        <input type="text" id="o_lng" name="n_lng" class="form-control form-control-sm" value="<?= $data['o_lng'] ?>">
                                    </p>
                                    <h5>New</h5>
                                    <p class="form-group">
                                        Latitude:
                                        <input type="text" id="n_lat" name="n_lat" class="form-control form-control-sm" value="<?= $data['n_lat'] ?>">
                                    </p>
                                    <p class="form-group">
                                        Longitude:
                                        <input type="text" id="n_lat" name="n_lat" class="form-control form-control-sm" value="<?= $data['n_lng'] ?>">
                                    </p>
                                    <form action="" method="POST">
                                        <input type="hidden" name="n_id" id="" value="<?= $data['id'] ?>">
                                        <input type="hidden" name="c_id" id="" value="<?= $data['coordinate_id'] ?>">
                                        <input type="hidden" name="s_id" id="" value="<?= $data['state_id'] ?>">
                                        <input type="hidden" name="self" id="" value="<?= $data['id'] ?>">
                                        <input type="submit" name="updateBtn" class="btn btn-success btn-md" id="" value="Approve" style="width: 80%; margin: 0 10%">
                                    </form>
                                </div>
                            </div>
                            <div class="mt-1">
                                <button type="button" name="backBtn" id="backBtn" class="btn btn-danger btn-md">Back</button>
                            </div>
                        </div>
                    </div>
                    <script src="../js/reqNode.js"></script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly" defer>
                    </script>
                </body>

                </html>
<?php
            }
        } else {
            echo "Err 400, Resource not found.";
        }
    }
}
