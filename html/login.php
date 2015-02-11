<?php
    // enable sessions
    session_start();
	
    require("../etc/configuration.php");

    // if username and password were submitted, check them
    if (isset($_POST["user"]) && isset($_POST["pass"]))
    {
        // connect to database
        if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
       
        // select database
        if (mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");
        
        // prepare SQL
        $sql = sprintf("SELECT 1 FROM users WHERE user='%s' AND pass=AES_ENCRYPT('%s', '%s')",
                       mysql_real_escape_string($_POST["user"]),
                       mysql_real_escape_string($_POST["pass"]),
                       mysql_real_escape_string($_POST["pass"]));

        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not query database");
		
        // check whether we found a row
        if (mysql_num_rows($result) == 1)
        {
            // remember that user's logged in
            $_SESSION["authenticated"] = true;

            $host = $_SERVER["HTTP_HOST"];
            header("Location: http://$host/index.php") or die("hello ".$host);
            exit;
        }
        else
        {
            echo"<script>alert('wrong username or wrong pass!')</script>";
        }
    }
	require("../lib/header.php"); 
?>
<h2 class="title">登录</h2>
<div class="content">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
      <table>
        <tr>
          <td>用户名：</td>
          <td>
            <input name="user" type="text" /></td>
        </tr>
        <tr>
          <td>密码：</td>
          <td><input name="pass" type="password" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" value="登录" /></td>
        </tr>
      </table>      
    </form>
</div>
<?php require("../lib/footer.php"); ?>
