<?php
require_once 'partials/_sessionStart.php';

$error_msg = array();
function redirectDashboard(): void
{
    header("location:admin.panel.php");

}

function validatePhone(mixed $phone)
{
    return null;
}

function validatePassword(mixed $password)
{
    return null;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        isset($_SESSION["isLoggedIn"]) ? redirectDashboard() : loadLogin();
        break;
    case "POST":
        isset($_SESSION['isLogin']) ? redirectDashboard() : null;
        $phone = empty($_POST["phone"]) ? $error_msg['phone'] = "Phone cannot be empty." : $_POST["phone"];
        $password = empty($_POST['password']) ? $error_msg['password'] = "Password cannot be empty" : $_POST["password"];
        if (!empty($error_msg)) {
            loadLogin($error_msg);
            return;
        }

        $error_msg['phone'] = validatePhone($phone);
        $error_msg['password'] = validatePassword($password);
        if ($error_msg['phone'] !== null || $error_msg['password'] !== null) {
            loadLogin($error_msg);
            return;
        }

        require_once 'partials/_curl.php';
        $params = array(
            'phone'=>$phone,
            'password'=>$password
        );
        $curl = new CURL('users', 'login', $params);
        $curl->ready();
        $response = $curl->execute();
        $response = json_decode($response, true);

        if($response == null || $response['code'] == 404){
            $error_msg['phone'] = "Phone number not in use.";
            loadLogin($error_msg);
        }
        if($response['code'] == 200){
            $message = $response['message'];
            if(password_verify($password, $message['password'])){
                $_SESSION['username'] = $message['name'];
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['id'] = $message['id'];
                redirectDashboard();
            }
        }
        loadLogin();
        break;
    default:
        echo "Invalid request made.";
        break;
}
?>




<?php function loadLogin($error_msg=''): void
{?>
    <?php include_once 'partials/header_1.php';?>
    <title>Login</title>
    <link rel="stylesheet" href="login.php">
    <?php include_once 'partials/header_2.php'?>
    <?php include_once 'partials/nav.php'?>
    <section class="container-fluid pt-5">
        <div id="login-container">

            <form action="" method="POST" class="col-lg-4 col-md-8 col-sm-12 mx-auto shadow-this" id="loginForm">
                <h2 class="mt-4">Admin Login</h2>

                <div class="form-group col-lg-12 mb-1">
                    <?php
                    if (isset($error_msg['phone'])) { ?>
                        <input type="text" name="phone" class="form-control is-invalid" id="phoneField"
                               placeholder="Phone number here.">
                        <small class="form-text invalid-feedback"><?= $error_msg['phone'] ?></small>
                        <?php
                    } else { ?>
                        <input type="text" name="phone" class="form-control " id="phoneField"
                               placeholder="Phone number here.">
                        <small class="form-text text-muted">We do not share your phone number.</small>
                        <?php
                    } ?>
                </div>
                <div class="form-group col-lg-12 mb-1">
                    <?php
                    if (isset($error_msg['password'])) { ?>
                        <input type="password" name="password" class="form-control is-invalid" id="passwordField"
                               placeholder="Password here.">
                        <small class="form-text invalid-feedback"><?= $error_msg['password'] ?></small>
                        <?php
                    } else {
                        ?>
                        <input type="password" name="password" class="form-control" id="passwordField"
                               placeholder="Password here.">
                        <small class="form-text text-muted">Passwords are encrypted.</small>
                        <?php
                    } ?>
                </div>
                <div class="form-group row  mx-1 mb-1">
                    <input type="submit" name="loginBtn" id="loginBtn" value="Login" class="btn">
                </div>
                <div class="col-lg-12">
                    <p class="redirectLink text-black-50">New Here?<a href="register.php" >Click here.</a></p>
                </div>
            </form>
            <br>
        </div>
    </section>
    <?php include_once 'partials/footer.php'?>
<?php }?>