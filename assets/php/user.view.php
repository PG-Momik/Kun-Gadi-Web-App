<?php

require_once 'partials/_sessionStart.php';
require_once 'partials/_flashAlert.php';
require_once 'partials/_curl.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $id = $_GET['id'] ?? null;
        if ($id == null) {
            header('location:error502.php');
        }
        $user = getData($id);
        loadView(user: $user);
        break;
    case "POST":
        switch ([
            isset($_POST['viewBtn']),
            isset($_POST['promoteBtn']),
            isset($_POST['updateBtn']),
            isset($_POST['deleteBtn'])
        ]) {
            case [1, 0, 0, 0]:
                $id = $_GET['id'];
                $user = getData($id);
                loadView($user);
                break;
            case [0, 1, 0, 0]:
                $id = $_GET['id'];
                $data = getData($id);
                if($data['role_id']>1) {
                    $result = promote($id);
                    var_dump($result);
                    if ($result['code'] == 200) {
                        $_SESSION['success'] = "User promoted.";
                        header('location:admin.users.php');
                    }
                }else{
                        $_SESSION['error'] = "User already has max privellages";
                        header('location:admin.users.php');
                }
                break;
            case [0, 0, 1, 0]:
                $id = $_POST['id'];
                $params = array(
                    "id" => $_POST['id'],
                    "rid" => $_POST['rid'],
                    "name" => $_POST['username'],
                    "phone" => $_POST['phone'],
                    "email" => $_POST['email'],
                );
                $result = update($params);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    $_SESSION['success'] = "User info updated.";
                    header("location:user.view.php?id={$id}");
                } else {
                    header('location:error500.php');
                }
                break;
            case [0, 0, 0, 1]:
                $id = $_GET['id'];
                $result = delete($id);
                $result = json_decode($result, true);
                if ($result['code'] == 200) {
                    require_once 'partials/_sessionStart.php';
                    $_SESSION['success'] = "User id: {$id} deleted.";
                    header("location:admin.users.php");
                } else {
                    header('location:error500.php');
                }
                break;
            default:
                header('location:error502.php');
                break;
        }
        break;
    default:
        header('location:error502.php');
        break;
}

function renderForm($user): void
{
    extract($user)
    ?>
    <form action="" method="POST"
          class="col-lg-4 col-md-8 col-sm-12 mx-auto bg-white shadow-lg mt-4"
          id="registerForm">
        <?php
        flashAlert(); ?>
        <h2><?= $name ?></h2>
        <div class="form-group col-lg-12 mb-2">
            <label for="">ID:</label>
            <input type="text" name='id' class="form-control" readonly value="<?= $id ?>">
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Role ID:</label>
            <input type="number" name='rid' class="form-control" min='1' max='3' value="<?= $role_id ?>">
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Username:</label>
            <?php
            if (isset($error_msg['username'])) {
                echo "<input type='text' name='username' class='form-control is-invalid p-2' id='username'
                            placeholder='Username' value='{$name}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['username']}</small>";
            } else {
                echo "<input type='text' name='username' class='form-control p-2' id='username'
                            placeholder='Username' value='{$name}'>";
            } ?>
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Phone:</label>
            <?php
            if (isset($error_msg['phone'])) {
                echo "<input type='text' name='phone' class='form-control is-invalid p-2' id='phone'
                           placeholder='Phone' value='{$phone}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['phone']}</small>";
            } else {
                echo "<input type='text' name='phone' class='form-control p-2' id='phone'
                           placeholder='Phone' value='{$phone}'>";
            } ?>
        </div>
        <div class="form-group col-lg-12 mb-2">
            <label for="">Email:</label>
            <?php
            if (isset($error_msg['email'])) {
                echo "<input type='email' name='email' class='form-control is-invalid p-2' id='email'
                           placeholder='Email' value='{$email}'>";
                echo "<small class='form-text invalid-feedback'>{$error_msg['email']}</small>";
            } else {
                echo "<input type='email' name='email' class='form-control p-2' id='email'
                           placeholder='email' value='{$email}'>";
            } ?>
        </div>
        <div class="form-group row mt-3">
            <div class="col-lg-6">
                <input type="submit" name="updateBtn" id="" value="Update" class="btn btn-outline-primary col-12">
            </div>
            <div class="col-lg-6">
                <input type="submit" name="deleteBtn" id="" value="Delete" class="btn btn-outline-danger col-12">
            </div>
        </div>
    </form>
    <?php
}

function loadView($user, $error_msg = ''): void
{
    require_once 'partials/_sessionStart.php';
    include_once 'partials/header_1.php';
    echo "<title>User</title>";
    include_once 'partials/header_2.php';
    include_once 'partials/nav.php';
    echo "<section id='dashboard-section'>";
    include_once 'partials/sidebar.php';
    echo "<div class='content'>";
    renderForm($user);
    echo "</div>";
    echo "</section>";
    include_once 'partials/adminFooter.php';
}

function getData($id)
{
    $params = array(
        "id" => $id
    );
    $curl = new CURL('users', 'byId', $params);
    $curl->ready();
    $result = $curl->execute();
    if (!$result) {
        header('location:error400.php');
    }
    $result = json_decode($result, true);
    if ((int)$result['code'] == 404 || $result['code'] == 400) {
        header('location:error404.php');
    }
    if ($result['code'] == 500) {
        header('location:error500.php');
    }
    return $result['message'];
}

function promote($id)
{

    $params = array(
        "id" => $id
    );
    $curl = new CURL('users', 'promote', $params);
    $curl->ready();
    $result = $curl->execute();
    $result = json_decode($result, true);
    return $result;
}

function update(array $params): bool|string
{
    $curl = new CURL('users', 'update', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}

function delete($id): bool|string
{
    $params = array(
        'id' => $id
    );
    $curl = new CURL('users', 'delete', $params);
    $curl->ready();
    $result = $curl->execute();
    return $result;
}
