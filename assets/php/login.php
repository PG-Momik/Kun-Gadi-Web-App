<?php
if(isset($_POST['login'])){
    session_start();
    $_SESSION['username']="Momik";
    header("Location:http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_0.php");
}else{
?>



<?php include_once 'partials/_html_p1.php'; ?>
<title>Login</title>
<?php include_once 'partials/_html_p2.php'; ?>
<?php include_once 'partials/_nav.php' ?>
<link rel="stylesheet" type="text/css" href="../css/login.css">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container"
        style="padding-top:15px;background: white;width:40%; margin-left:30%; margin-top:10vh;box-shadow:5px 10px">
        <div class="row">
            <div>
                <div class="page-header">
                    <h2>Admin Login</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>
                    <input style="width: 70%; margin-left:15%" type="Submit" class="form-group btn btn-primary"
                        name="login" value="Submit">
                    <br>
                </form>
            </div>
        </div>
    </div>
</body>
<style>
    body {
        height: 800px;
        background-color: #000000;
        background-image: linear-gradient(315deg, #000000 0%, #414141 74%);
    }
</style>

</html>
<?php include_once 'partials/_footer.php' ?>
<?php }?>