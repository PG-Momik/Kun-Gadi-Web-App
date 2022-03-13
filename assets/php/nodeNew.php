<?php
if (isset($_POST['addBtn'])) {
    include_once '../php/partials/_utility.php';
    createNode($_POST['node'], $_POST['lat'], $_POST['lng']);
}
include_once 'partials/_html_p1.php';
echo "<title>New Node</title>";
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
                <h4>Plot Node:</h4>
            </div>
            <div id="map"></div>
            <div class="mt-3">
                <button type="button" name="resetBtn" id="resetBtn" class="btn btn-warning btn-md">Reset</button>
                <button type="button" name="backBtn" id="backBtn" class="btn btn-danger btn-md" onclick="history.back()">Back</button>
            </div>
            <div id="detailContainer" class="mt-3">
                <form action="" id="actualForm" name="actualForm" method="POST" style="padding-left:12px; padding-right:12px">
                    <div class="row">
                        <input class="form-control col" type="text" name="node" id="node" placeholder="Enter name here">
                        <input class="form-control col" type="text" name="lat" id="lat" readonly placeholder="Latitude appears here">
                        <input class="form-control col" type="text" name="lng" id="lng" readonly placeholder="Longitude appears here">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <input type="submit" name="addBtn" id="addBtn" value="Addd Route" class="btn btn-success btn-md btnStuff col-lg-12 col-sm-12">
                        </div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src=" ../js/nodeNew.js">
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8pwb7nZMZCjhAwzTqBSvO1bWEa-NY0DE&callback=initMap&v=weekly">
</script>

</html>