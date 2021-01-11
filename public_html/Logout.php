<?php
    session_start();
    unset($_SESSION['logged_in']);
    header("Location: http://clabsql.clamv.jacobs-university.de/~jwhiteley/mainPage.php");
?>
