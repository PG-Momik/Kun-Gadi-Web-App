<?php include_once 'partials/_html_p1.php'; ?>
<title>Nodes</title>
<?php include_once 'partials/_html_p2.php'; ?>
<?php include_once 'partials/_sessionStart.php'; ?>

<?php

$ch =  curl_init();
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
$url  = "https://kungadi.000webhostapp.com/Api/index.php?en=node&op=getXNode" . "&page=" . $page;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);


?>

<body>
    <?php include_once 'partials/_nav.php'; ?>
    <div id="admin-content">
        <?php include_once 'partials/_sidebar.php'; ?>
        <div class="admin-right">

            <nav aria-label="Page navigation example" class="row">
                <div class="col-lg-6 col-sm-12" style="padding:0px;padding-left: 10px; height:2.375rem">
                    <a href="nodeNew.php" class="btn btn-outline-success" style="text-decoration:none;">Create New <span class="btn btn-success" style="padding:0 8px ;margin:0;">+</span></a>
                </div>
                <ul class="col-lg-6 col-sm-12 pagination justify-content-end">
                    <li class="<?php
                                if ($page == 1) {
                                    echo "page-item disabled";
                                } else {
                                    echo "page-item";
                                }
                                ?>">
                        <a class="page-link" tabindex="" href="<?= "http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_2.php?page=" . ($page - 1); ?>">
                            Previous
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">
                            Page<?= $page ?>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?= "http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_2.php?page=" . ($page + 1); ?>">
                            Next </a>
                    </li>
                </ul>
            </nav>

            <div class="index-container">
                <div>
                    <ol class="index-ol">
                        <li class="index-box unack"></li>
                        <li class="index-label">Unacknowledged</li>
                        <li class="index-box ack"></li>
                        <li class="index-label">Acknowledge</li>
                        <li class="index-box acc"></li>
                        <li class="index-label">Accepted</li>
                    </ol>
                </div>

                <div class="filter-container align-middle">
                    <div>
                        <select class="form-select form-select-sm" aria-label=".form-select-lg example">
                            <option selected>Select Page</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        <select class="form-select form-select-sm" aria-label=".form-select-lg example">
                            <option selected>Sort By</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>

            </div>

            <table class="table text-center table-striped">
                <thead>
                    <tr id="tblHead" class="align-middle">
                        <th scope="col" class="1">#</th>
                        <th scope="col" class="4">Name</th>
                        <th scope="col" class="4">Coordinates</th>
                        <th scope="col" class="3">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($e = curl_error($ch)) {
                        echo $e;
                    } else {
                        $decoded =  json_decode($resp, true);
                        if ($decoded['code'] != 200) {
                            echo $decoded["message"];
                        } else {
                            for ($i = 0; $i < sizeof($decoded["message"]); $i++) {
                                showRow(
                                    $i + 1,
                                    $decoded['message'][$i]['id'],
                                    $decoded['message'][$i]['name'],
                                    $decoded['message'][$i]['longitude'],
                                    $decoded['message'][$i]['latitude']
                                );
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>

<?php
function showRow($i, $id, $node, $longitude, $latitude)
{
    $coords = "( " . $longitude . ", " . $latitude . " )";

    echo "<tr class='align-middle'>";
    echo "<th class='col-md-1'>" . $i . "</th>";
    echo "<td class='col-md-4'>" . $node . "</td>";
    echo "<td class='col-md-4'>" . $coords . "</td>";
    echo "<td class='col-md-3'>";
    echo "<form action='node.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo '<input type="submit" class="btn btn-sm btn-primary buttonStuff" name="action" value="View" />';
    echo '<input type="submit" class="btn btn-sm btn-danger buttonStuff" name="action" value="Delete" />';
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}


?>