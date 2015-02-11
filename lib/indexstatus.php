<?php
        // connect to database
        if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
       
        // select database
        if (mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");
        
        // prepare SQL
        $sql = sprintf("SELECT * FROM status order by time desc limit 20");

        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not query database");
		
        if (mysql_num_rows($result) >= 1)
        {
            echo "<ul>";
            while($row = mysql_fetch_assoc($result))
            {
                echo "<li>【".$row["time"]."】</li>";
                echo $row["content"];
            }
            echo "</ul>";
        }
?>
