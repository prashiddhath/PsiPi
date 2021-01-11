<?php session_start(); ?>
<header>
 <img src="http://clabsql.clamv.jacobs-university.de/~jwhiteley/img/logo.png?v=<?php echo date('his'); ?>" alt="logo">
 <h1>PsiPi: Quanta to Cosmos in a Click</h1>
 <div class="topBar">
   <a href = "http://clabsql.clamv.jacobs-university.de/~jwhiteley/mainPage.php">Home</a>
   <a href = "http://clabsql.clamv.jacobs-university.de/~jwhiteley/imprint.php">Imprint</a>
   <a href = "#">Support Us</a>
   <a href = "#">Help & FAQs</a>
   <a href = "#">About Us</a>
   <a href = "http://clabsql.clamv.jacobs-university.de/~jwhiteley/demoPage.php">Demo</a>
   <a href = "http://clabsql.clamv.jacobs-university.de/~jwhiteley/Login.php">Maintenance</a>
   <?php
    if(isset($_SESSION['logged_in'])) {
      echo "<a href = 'http://clabsql.clamv.jacobs-university.de/~jwhiteley/Logout.php'>Logout</a>";
    }
   ?>
 </nav>
</header>
