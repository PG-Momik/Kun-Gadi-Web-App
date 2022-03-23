<?php
include 'partials/_utility.php';

if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
} else {
    if (isset($_POST['self']) && isset($_POST['updateBtn']) || (isset($_POST['action']) && $_POST['action'] == "Approve")) {
        updtRRoute($_POST['id'], $_POST['rid']);
    } elseif ((isset($_POST['self']) && isset($_POST['deleteBtn'])) || (isset($_POST['action']) && $_POST['action'] == "Delete")) {
        deltRRoute($_POST['id']);
    } else {
        acknoweledgeThis($_POST['id'], $_POST['sid']);
        $old = getCoordinateValue($_POST['o_path']);
        $new = getCoordinateValue($_POST['n_path']);
        if (!(isset($old) && isset($new) && $old['code'] == 200 && $new['code'] == 200)) {
            echo "Err:Something went wrong.";
            return false;
        }
        include_once 'partials/_html_p1.php';
        echo "<title>Request</title>";
        include_once 'partials/_html_p2.php';
        echo "<body>";
        include_once 'partials/_nav.php';
?>
        <style>
            #comp-container {
                display: flex;
            }

            #map {
                height: 420px;
                width: 100%;
                border: 1px solid black;
            }

            .detail_card {
                padding: 10px;
                border: 1px solid black;
                background: #272727;
                margin-bottom: 8px;
            }

            .detail_card>ol {
                padding: 0px;
                list-style: none;
                background: white;
                padding: 6px;
            }

            .card_header {
                border-radius: 12px;
                margin-top: 5px;
                padding: 4px 0px;
                color: #27adf2;
                font-weight: 900;
                font-size: 20px;
            }
        </style>
        <div id="admin-content">
            <?php include_once 'partials/_sidebar.php'; ?>
            <div class="admin-right">
                <div class="index-container text-center">
                    <p id="oldFromCURL" class="hidden">
                        <?php echo json_encode($old['message']) ?>
                    </p>
                    <p id="newFromCURL" class="hidden">
                        <?php echo json_encode($new['message']) ?>
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
                </div>
                <br>
                <div style="padding-left: 10px;">
                    <h2>Details</h2>
                    <div style="text-align: left;" class="row ">
                        <div class="row">
                            <div class="col-lg-6 detail_card border">
                                <p class="card_header">Old Nodes:</p>
                                <ol id="o_place"></ol>
                            </div>
                            <div class="col-lg-6 detail_card border">
                                <p class="card_header">Suggested Nodes:</p>
                                <ol id="n_place"></ol>
                            </div>
                        </div>
                        <div id="updateContainer" class="row">
                            <div class="col-lg-6"></div>
                            <form action="" method="POST" name="myForm" id="myForm" class="col-lg-6">
                                <input type="hidden" name="self" id="" value="self">
                                <input type="hidden" name="id" id="id" value="<?= $_POST['id'] ?>">
                                <input type="hidden" name="rid" id="rid" value="<?= $_POST['rid'] ?>">
                                <input type="submit" name="updateBtn" id="uploadBtn" value="Approve" class="btn btn-success btn-md btnStuff" style="width: 100%">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        <script src="../js/reqRoute.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly" defer></script>

        </html>


<?php
    }
}
function getCoordinateValue($path)
{
    $ch = curl_init();
    $base_url = "https://kungadi.000webhostapp.com/Api/index.php?";
    $url = $base_url . "en=routes&op=getPathCoordinates";
    $data_array = array("path" => $path);
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
    return json_decode($resp, true);
}
function acknoweledgeThis($id, $state_id)
{
    if ($state_id != 1) {
        $ch = curl_init();
        $ch = curl_init();
        $base_url = "https://kungadi.000webhostapp.com/Api/index.php?";
        $url = $base_url . "en=contribute_route&op=acknowledgeContribution";
        $data_array = array("id" => $id);
        $data = json_encode($data_array);
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: : application/json'),
        );
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);
    }
}

?>