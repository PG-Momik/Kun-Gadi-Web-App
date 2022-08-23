
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kun Gadi</title>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/4af8c17884.js" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
<header>
    <nav id="top-navbar">
        <div id="top-nav-brand">
            KUN GADI
        </div>
        <div id="top-nav-menu-container">
            <ol id="top-nav-menu">
                <li class="nav-item">
                    <a href="http://localhost/WebApp/index.php#main" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="http://localhost/WebApp/index.php#get-started" class="nav-link">Get Started</a>
                </li>
                <li class="nav-item">
                    <a href="http://localhost/WebApp/index.php#about-us" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['username'])) { ?>
                        <a href="http://localhost/WebApp/assets/php/panel.php" class="nav-link">
                            <?= $_SESSION['username'] ?>
                        </a>
                        <?php
                    } else { ?>
                        <a href="http://localhost/WebApp/assets/php/login.php" class="nav-link">Login</a>
                        <?php
                    } ?>
                </li>
            </ol>
        </div>
    </nav>
</header>
<!-- Section home -->
<section id="home">
    <div class="row">
        <div class="col-lg-6 textx">
            <h1>Ease your journey with our mobile app.</h1>
            <div>
                <button class="btn btn-dark btn-lg download-button"><i class="fab fa-apple"></i> Download</button>
                <button class="btn btn-outline-light btn-lg download-button"><i class="fab fa-google-play"></i>
                    Download</button>
            </div>
        </div>
        <div class="col-lg-6">
            <img class="title-image" src="./assets/images//app.png " alt="">
        </div>
    </div>
    </div>
</section>

<!-- Section Get Started -->
<section id="get-started">
    <div style="padding:40px">
        <h1>Get Started</h1>
        <br>
        <form action="assets/php/search.php">
            <div style="display:flex;">
                <input type="text" name="frm" id="input3" class="form-control" style="width: 25%; margin-left:25%; padding:10px 20px; border-radius:25px 0 0 25px; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc" placeholder="From">
                <input type="text" name="to" id="input4" class="form-control" style="width: 25%; margin-left:0; padding:10px 20px; border-radius:0 25px 25px 0 ; margin-top:4vh; margin-bottom:4vh;background:#dcdcdc" placeholder="To">
            </div>

            <button class="btn btn-md" style="width:30%; margin-left:35%; background:#27285c; color:white; border-radius:25px; padding:10px; font-size:1.4rem">Search
            </button>
        </form>
    </div>
</section>


<!-- Section About Us -->
<section id="about-us">
    <div style="padding: 40px">
        <h1>About us</h1>
        <p class="textz"> KunGadi is an easy to use travel assistance android application.
            Imagine you, a person who uses public transport as a medium of travel.
            Now imagine u need to go someplace you've never been. Rather than asking every other person for direction,
            download and use our application to avoid weird interaction and the feeling of shame.
            KunGadi uses bus route data to provide you with the best possible path of travel for public travel.</p>
    </div>
</section>
<footer class="page-footer" id="footer-id">
<!--    <div class="row footer-row">-->
<!--        <div class="col-md-6 col-sm-12">-->
<!--            <h3 class="">Find us at:</h3>-->
<!--            <ul class="find-us-at" style="">-->
<!--                <li>-->
<!--                    <a href="#"><i class="fa fa-facebook footer-icon"></i></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#"><i class="fa fa-twitter footer-icon"></i></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#"><i class="fa fa-google footer-icon"></i></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#"><i class="fa fa-youtube footer-icon"></i></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="#"><i class="fa fa-linkedin-square footer-icon"></i></a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="col-md-6 col-sm-12">-->
<!--            <h3 class="">Address:</h3>-->
<!--            <div class="">-->
<!--                <ul class="address">-->
<!--                    <li><i class="fa fa-map-marker" aria-hidden="true"></i>KhasiBazar, Kirtipur, Kathmandu</li>-->
<!--                    <li><i class="fa fa-map-marker" aria-hidden="true"></i>Bhotebal, Teku, Kathmandu</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="row copyright-bar">-->
<!--        <div class="col">-->
<!--            <p">Copyright &copy;2021. Designed by <u>Shreeju Pradhan</u>.</p>-->
<!--        </div>-->
<!--    </div>-->
</footer>
</body>
</html>
