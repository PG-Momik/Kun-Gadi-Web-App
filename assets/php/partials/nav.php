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
                        <a href="admin.panel.php" class="nav-link">Profile</a>
                        <?php
                    } else { ?>
                        <a href="login.php" class="nav-link">Login</a>
                        <?php
                    } ?>
                </li>
            </ol>
        </div>
    </nav>
</header>