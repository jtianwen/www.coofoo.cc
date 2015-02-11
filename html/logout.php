<?php 
    // enable sessions
    session_start();

    // delete cookies, if any
    setcookie("user", "", time() - 3600);
    setcookie("pass", "", time() - 3600);

    // log user out
    setcookie(session_name(), "", time() - 3600);
    session_destroy();

    $host = $_SERVER["HTTP_HOST"];
    header("Location: http://$host/index.php");
   // header("Location: http://localhost/tianwenhappy/1/index.php");
    exit;
?>
