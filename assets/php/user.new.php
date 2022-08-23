<?php


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        loadView();
        break;
    case "POST":
        require_once 'partials/_curl.php';
        $params = array(
            'name' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'phone' => $_POST['phone'],
        );

        //validatio missing

        //Curl to insert data
        $curl = new CURL('users', 'create', $params);
        $curl->ready();
        $result = $curl->execute();
        if (!$result) {
            $_SESSION['error'] = "Something went wrong. Try again.";
            loadView();
            return;
        }
        unset($_POST);
        $_SESSION['success'] = "User added successfully.";
        loadView();
        break;
}

function loadView($error_msg = ''):void
{
?>
<?php
include_once 'partials/header_1.php'; ?>
<title>New User</title>
<?php
include_once 'partials/header_2.php' ?>
<?php
include_once 'partials/nav.php'; ?>
<section id="dashboard-section">
    <?php
    include_once 'partials/sidebar.php' ?>
    <div class="content ">
        <form action="" method="POST" class="col-lg-4 col-md-8 col-sm-12 mx-auto bg-white shadow-lg mt-4"
              id="registerForm">
            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error']))
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            ?>
            <h2>Add a user.</h2>
            <div class="form-group col-lg-12 mb-1">
                <?php
                if (isset($error_msg['username'])) { ?>
                    <input type="text" name="username" class="form-control is-invalid p-2" id="username"
                           placeholder="Username">
                    <small class="form-text invalid-feedback"><?= $error_msg['username'] ?></small>
                    <?php
                } else { ?>
                    <input type="text" name="username" class="form-control p-2" id="username"
                           placeholder="Username">
                    <?php
                } ?>
            </div>
            <div class="form-group col-lg-12 mb-1">
                <?php
                if (isset($error_msg['phone'])) { ?>
                    <input type="text" name="phone" class="form-control is-invalid p-2" id="phone"
                           placeholder="Phone">
                    <small class="form-text invalid-feedback"><?= $error_msg['phone'] ?></small>
                    <?php
                } else { ?>
                    <input type="text" name="phone" class="form-control p-2" id="phone"
                           placeholder="Phone">
                    <?php
                } ?>
            </div>
            <div class="form-group col-lg-12 mb-1">
                <?php
                if (isset($error_msg['email'])) { ?>
                    <input type="email" name="email" class="form-control is-invalid p-2" id="email"
                           placeholder="Email">
                    <small class="form-text invalid-feedback"><?= $error_msg['email'] ?></small>
                    <?php
                } else { ?>
                    <input type="email" name="email" class="form-control p-2" id="email"
                           placeholder="Email">
                    <?php
                } ?>
            </div>
            <div class="form-group col-lg-12 mb-1">
                <?php
                if (isset($error_msg['password'])) { ?>
                    <input type="password" name="password" class="form-control is-invalid p-2" id="password"
                           placeholder="Password">
                    <small class="form-text invalid-feedback"><?= $error_msg['password'] ?></small>
                    <?php
                } else { ?>
                    <input type="password" name="password" class="form-control p-2" id="password"
                           placeholder="Password">
                    <?php
                } ?>
            </div>
            <div class="form-group col-lg-12 mb-1">
                <input type="submit" name="registerBtn" id="" value="Add" class="btn btn-outline-primary col-lg-12 p-2">
            </div>
        </form>
    </div>
    <?php
    include_once 'partials/adminFooter.php';
    }
    function redirect(){
        header("location:http://localhost/WebApp/assets/php/user.new.php");
    }

    ?>

