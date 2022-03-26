<?php
include 'partials/_utility.php';
if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
}
if (isset($_POST['self'])) {
    if (isset($_POST['updateBtn'])) {
        updtRoute($_POST['id'], $_POST['value']);
    } elseif (isset($_POST['deleteBtn'])) {
        deltRoute($_POST['id']);
    }
    $condition1 = $_POST['id'] && $_POST['action'] == "Delete";
    $condition2 = $_POST['id'] && $_POST['action'] == "View";
    if ($condition1) {
        deltRoute($_POST['id']);
    }
    if ($condition2) {
        $ch = curl_init();
        $url = "https://kungadi.000webhostapp.com/Api/index.php?en=routes&op=getPathCoordinates";
        $data_array = array("path" => $_POST['path']);
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
        if (isset($decoded['code']) && $decoded['code'] == 200) {
            $data = $decoded['message'];
            include_once 'partials/_html_p1.php';
            echo "<title>Node</title>";
            include_once 'partials/_html_p2.php';
            echo "<body>";
            include_once 'partials/_nav.php';
            echo '<div id="admin-content">';
            include_once 'partials/_sidebar.php';
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

                #form-container {
                    width: 30%;
                    margin: auto 10px;
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
            <div class="admin-right">
                <div class="index-container text-center">
                    <p id="dataFromCURL">
                        <?php echo json_encode($data) ?>
                    </p>
                    <div id="map"></div>
                </div>
            </div>
            </div>
            </body>
<? }
    }
}
?>