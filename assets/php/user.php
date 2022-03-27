<?php
include 'partials/_utility.php';

if (!isset($_SESSION['admin'])) {
    echo "Err:404, No permission to view.";
    return false;
} else {
    if (isset($_POST['self'])) {
        if (isset($_POST['updateBtn'])) {
            updtUser($_POST['id'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['role_id']);
        } elseif (isset($_POST['deleteBtn'])) {
            deltUser($_POST['id']);
        } else {
            echo '<script>';
            echo 'window.location = "' . $_SESSION['prev_url'] . '"';
            echo '</script>';
        }
    } else {
        $condition1 = $_POST['id'] && $_POST['action'] == "Delete";
        $condition2 = $_POST['id'] && $_POST['action'] == "Promote";
        $condition3 = $_POST['id'] && $_POST['action'] == "View";
        if ($condition1) {
            deltUser($_POST['id']);
            return false;
        } elseif ($condition2) {
            promUser($_POST['id']);
            return false;
        } elseif ($condition3) {
            $ch = curl_init();
            $url = "https://kungadi.000webhostapp.com/Api/index.php?en=user&op=getById";
            $data_array = array(
                "id" => $_POST['id'],
            );
            $data = json_encode($data_array);
            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-Type: : application/json')
            );
            curl_setopt_array($ch, $options);
            $resp = curl_exec($ch);
            curl_close($ch);
            $decoded = json_decode($resp, true);
            $user = $decoded['message'];

            include_once 'partials/_html_p1.php';
            echo "<title>User</title>";
            include_once 'partials/_html_p2.php';
?>

            <body>
                <?php include_once 'partials/_nav.php'; ?>
                <div id="admin-content">
                    <?php include_once 'partials/_sidebar.php'; ?>
                    <div class="admin-right">

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">User ID</label>
                                <input type="text" name="id" class="form-control" value="<?= $user['id'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= $user['phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Role</label>
                                <select class="form-select form-select-md" aria-label=".form-select-lg example" name="role_id">
                                    <option selected>Select Role</option>
                                    <option value="1">Master</option>
                                    <option value="2">Admin</option>
                                    <option value="3">User</option>
                                </select>
                            </div>
                            <br>
                            <input type="hidden" name="self">
                            <button type="submit" name="updateBtn" class="btn btn-primary">Update</button>
                            <button type="submit" name="backBtn" class="btn btn-warning">Back</button>
                            <button type="submit" name="deleteBtn" class="btn btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </body>

            </html>
<?php
        }
    }
}
?>