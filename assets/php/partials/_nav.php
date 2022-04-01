<?php if (session_status() === PHP_SESSION_NONE) {
  session_start();
}else{
}
?>
<nav id="top-navbar">
  <!-- Brand -->
  <div id="top-nav-brand">
    KUN GADI
  </div>

  <!-- Nav links -->
  <div id="top-nav-menu-container">
    <ol id="top-nav-menu">
      <li class="nav-item">
        <a href="http://localhost/Kun-Gadi/WebApp/index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/Kun-Gadi/WebApp/index.php#get-started" class="nav-link">Get Started</a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/Kun-Gadi/WebApp/index.php#about-us" class="nav-link">About Us</a>
      </li>
      <?php if (isset($_SESSION['username'])) { ?>
      <li class="nav-item">
        <a href="http://localhost/Kun-Gadi/WebApp/assets/php/pannel_tab_0.php"
          class="nav-link"><?php echo $_SESSION['username'] ?></a>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <a href="http://localhost/Kun-Gadi/WebApp/assets/php/login.php" class="nav-link">Login</a>
      </li>
      <?php } ?>
    </ol>
  </div>

</nav>