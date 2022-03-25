<?php
include 'partials/_utility.php';
if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
} else {
    if (isset($_POST['self'])) {
        if (isset($_POST['updateBtn'])) {
            updtRoute($_POST['id'], $_POST['value']);
            return false;
        } elseif (isset($_POST['deleteBtn'])) {
            echo "where";
            deltRoute($_POST['id']);
            return false;
        }
    } else {
        $condition1 = $_POST['id'] && $_POST['action'] == "Delete";
        $condition2 = $_POST['id'] && $_POST['action'] == "View";
        if ($condition1) {
            deltRoute($_POST['id']);
            return false;
        } elseif ($condition2) {
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
            if ($decoded['code'] == 200) {
                $data = $decoded['message'];
                include_once 'partials/_html_p1.php';
                echo "<title>Route</title>";
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
                                <p id="dataFromCURL" class="hidden">
                                    <?php echo json_encode($data) ?>
                                </p>
                                <div id="map"></div>
                            </div>
                            <div class="mt-3" style="display: flex; justify-content: space-between">
                                <div id="btn-group">
                                    <form action="" method="POST">
                                        <input type="hidden" value="<?= $_POST['id'] ?>" id="id" name="id">
                                        <input type="button" value="Edit" id="changeBtn" class="btn btn-primary btn-md btnStuff ">
                                        <input type="button" value="Clear" id="clearBtn" class="btn btn-warning btn-md btnStuff ">
                                        <input type="hidden" name="self" id="" value="self">
                                        <input type="submit" value="Delete" name="deleteBtn" id="deleteBtn" class="btn btn-danger btn-md btnStuff ">
                                    </form>
                                </div>
                                <div id="count_container" class="align-middle hidden">
                                    <h4>Remaining markers: <span id="count_count">x</span></h4>
                                </div>
                            </div>
                            <div style="padding-left: 10px;">
                                <h2>Details</h2>
                                <div style="text-align: left;" class="row ">
                                    <div class="row">
                                        <div class="col-lg-6 detail_card border">
                                            <p class="card_header">Old Nodes:</p>
                                            <ol id="o_place"></ol>
                                        </div>
                                        <div class="col-lg-6 detail_card border hidden" id="hidden_place">
                                            <p class="card_header">New Nodes:</p>
                                            <ol id="n_place"></ol>
                                        </div>
                                    </div>
                                    <div id="updateContainer" class="row hidden">
                                        <div class="col-lg-6"></div>
                                        <form action="" method="POST" name="myForm" id="myForm" class="col-lg-6">
                                            <input type="hidden" name="self" id="" value="self">
                                            <input type="hidden" name="id" id="id" value="<?= $_POST['id'] ?>">
                                            <input type="hidden" name="value" id="value" value="">
                                            <input type="hidden" name="updateBtn" id="" value="updateBtn">
                                            <input type="submit" name="" id="uploadBtn" value="Update" class="btn btn-success btn-md btnStuff" style="width: 100%">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                <script src="../js/route.js"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly">
                </script>

                </html>
<?php
            } else {
                echo "here";
            }
        } else {
            echo "Err 400, Resource not found.";
        }
    }
}
