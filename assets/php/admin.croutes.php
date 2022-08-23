<?php

require_once 'partials/_sessionStart.php';
require_once 'partials/_flashAlert.php';
require_once 'partials/_curl.php';

$url = $_SERVER["REQUEST_URI"];
$page = 1;
if ($_GET) {
    if (!$_GET['p'] == 0) {
        $page = $_GET['p'];
    }
}

$params = array('page' => $page);
$curl = new Curl('contributeRoute', 'getSome', $params);
$curl->ready();
$response = $curl->execute();
$response = json_decode($response, true);

if ($response['code'] == 500) {
    loadAdmin(page: 0, data: 0, numberOfPages: 0, error: true);
}
if ($response['code'] == 404) {
    loadAdmin(page: 0, data: 0, numberOfPages: 0, error: true);
}

$message = $response['message'];
$index = count($message) - 1;
$count = $message[$index]['count'];
$numberOfPages = ceil($count / 15);
array_pop($message);
loadAdmin(page: $page, data: $message, numberOfPages: $numberOfPages, error: false);

function loadAdmin($page, $data, $numberOfPages, $error = true,): void
{
    ?>
    <?php
    include_once 'partials/header_1.php'; ?>
    <title>Route Requests</title>
    <?php
    include_once 'partials/header_2.php' ?>
    <?php
    include_once 'partials/nav.php'; ?>
    <section id="dashboard-section">
        <?php
        include_once 'partials/sidebar.php' ?>
        <?php
        if ($error) {
            echo "Something went wrong. Try again.";
            return;
        }
        ?>
        <div class="content ">
            <nav aria-label="Page navigation example" class="row">
                <div class="col-lg-6 col-sm-12" style="padding:0px;padding-left: 10px; height:2.375rem">
                </div>
                <ul class="col-lg-6 col-sm-12 pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" tabindex=""
                           href="<?= "admin.croutes.php?p=" . ($page - 1); ?>">
                            Previous
                        </a>
                    </li>
                    <?php
                    for ($i = 1; $i <= $numberOfPages; $i++) {
                        ?>
                        <li class="page-item">
                            <a class="page-link" tabindex=""
                               href="<?= 'admin.croutes.php?p=' . $i ?>">
                                <?= $i; ?>
                            </a>
                        </li
                        <?php
                    } ?>

                    <li class="page-item">
                        <a class="page-link"
                           href="<?= "admin.croutes.php?p=" . ($page + 1); ?>">
                            Next </a>
                    </li>
                </ul>
            </nav>
            <div class="index-container text-center">
                <div>
                    <ol class="index-ol">
                        <li class="index-box unack"></li>
                        <li class="index-label">Unreviewed</li>
                        <li class="index-box ack"></li>
                        <li class="index-label">Reviewed</li>
                        <li class="index-box acc"></li>
                        <li class="index-label">Approved</li>
                    </ol>
                </div>
                <div class="filter-container align-middle">
                    <div>
                        <select class="form-select form-select-sm" aria-label=".form-select-lg example">
                            <option selected>Sort By</option>
                            <option value="name">Name</option>
                            <option value="role_id">Roles</option>
                        </select>
                    </div>
                    <div>
                        <select class="form-select form-select-sm" aria-label=".form-select-lg example">
                            <option selected>Order</option>
                            <option value="asc">Asc</option>
                            <option value="dsc">Dsc</option>
                        </select>
                    </div>
                    <a href="#" class="btn btn-sm btn-dark mb-3">Go</a>
                </div>
            </div>

            <?php flashAlert();?>

            <table class="table">
                <thead class=" table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Start-End</th>
                    <th scope="col">Submitted By</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $i => $row) {
                    showRows($i, $row);
                } ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php
} ?>


<?php
function showRows($i, $row)
{
    extract($row);

    if ($state_id == 1) {
        echo "<tr scope='row' class='align-middle acc' >";
    } elseif ($state_id == 2) {
        echo "<tr scope='row' class='align-middle ack'>";
    } else {
        echo "<tr scope='row' class='align-middle unack' >";
    }

    echo "<td class='col-md-1'>" . $i + 1 . "</td>";
    echo "<td class='col-md-4'>" . $start . "-" . $end . "</td>";
    echo "<td class='col-md-4'>" . $user . "</td>";
    echo "<td class='col-md-3'>";
    echo "<form action='croute.view.php?id={$id}' method='POST'>";
    echo "<input type='submit' class='btn btn-sm btn-primary mx-1' name='viewBtn' value='View'>";
    echo "<input type='submit' class='btn btn-sm btn-success mx-1' name='approveBtn' value='Approve'>";
    echo "<input type='submit' class='btn btn-sm btn-danger mx-1' name='deleteBtn' value='Delete'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}

?>