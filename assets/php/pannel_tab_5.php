<?php include_once 'partials/_html_p1.php'; ?>
<title>Route Requests</title>
<?php include_once 'partials/_html_p2.php'; ?>
<?php include_once 'partials/_sessionStart.php'; ?>
<?php

$ch =  curl_init();
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
$url  = "https://kungadi.000webhostapp.com/Api/index.php?en=contribute_route&op=read_XContributions" . "&page=" . $page;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch);

?>

<body>
    <?php include_once 'partials/_nav.php'; ?>
    <div id="admin-content">
        <?php include_once 'partials/_sidebar.php'; ?>
        <div class="admin-right">

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="<?php
                                if ($page == 1) {
                                    echo "page-item disabled";
                                } else {
                                    echo "page-item";
                                }
                                ?>">
                        <a class="page-link" tabindex="" href="<?= "http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_5.php?page=" . ($page - 1); ?>">
                            Previous
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">
                            Page <?= $page ?>
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?= "http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_5.php?page=" . ($page + 1); ?>"> Next </a>
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

            <table class="table text-center">
                <thead>
                    <tr id="tblHead" class="align-middle">
                        <th scope="col">#</th>
                        <th scope="col">Start - End</th>
                        <th scope="col">Submitted By</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($e = curl_error($ch)) {
                        echo $e;
                    } else {
                        $decoded =  json_decode($resp, true);
                        if ($decoded['code'] == 200) {
                            for ($i = 1; $i <= sizeof($decoded["message"]); $i++) {
                                showRow(
                                    $i,
                                    $decoded['message'][$i - 1]['id'],
                                    $decoded['message'][$i - 1]['route_id'],
                                    $decoded['message'][$i - 1]['start'],
                                    $decoded['message'][$i - 1]['end'],
                                    $decoded['message'][$i - 1]['user'],
                                    $decoded['message'][$i - 1]['state_id'],
                                    $decoded['message'][$i - 1]['o_path'],
                                    $decoded['message'][$i - 1]['n_path']
                                );
                            }
                        } else {
                            echo $decoded["message"];
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
function showRow($i, $id, $route_id, $start, $end, $user, $state_id, $o_path, $n_path)
{
    if ($state_id == "1") {
        echo "<tr scope='row' class='align-middle acc'  >";
    } elseif ($state_id == "2") {
        echo "<tr scope='row' class='align-middle ack' >";
    } else {
        echo "<tr scope='row' class='align-middle ' >";
    }
    $route = $start . " - " . $end;
    echo "<th scope='row' class='col-md-1'>" . $i . "</th>";
    echo "<td class='col-md-4'>" . $route . "</td>";
    echo "<td class='col-md-4'>" . $user . "</td>";
    echo "<td class='col-md-3'>";
    echo "<form action='requestRoute.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='hidden' name='rid' value='$route_id'>";
    echo "<input type='hidden' name='sid' value='$state_id'>";
    echo "<input type='hidden' name='o_path' value='$o_path'>";
    echo "<input type='hidden' name='n_path' value='$n_path'>";

    echo '<input type="submit" class="btn btn-sm btn-primary buttonStuff" name="action" value="View" />';
    echo '<input type="submit" class="btn btn-sm btn-success buttonStuff" name="action" value="Approve" />';
    echo '<input type="submit" class="btn btn-sm btn-danger buttonStuff" name="action" value="Delete" />';
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}
?>