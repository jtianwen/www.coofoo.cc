<?php
    require("../etc/configuration.php");

    if (isset($_POST["text"]))
    {
        // connect to database
        if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
       
        // select database
        if (mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");
        
        // prepare SQL
        $sql = sprintf("INSERT INTO status VALUES ('%s', CURRENT_TIMESTAMP)", mysql_real_escape_string($_POST["text"]));

        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not query database");
        $host = $_SERVER["HTTP_HOST"];
        header("Location: http://$host/index.php") or die("cannot jump to homepage");
        exit;
    }
?>
