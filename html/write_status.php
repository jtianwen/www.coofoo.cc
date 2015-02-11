<?php session_start(); ?>
<?php
    if(!$_SESSION["authenticated"])
    {
        $host = $_SERVER["HTTP_HOST"];
        header("Location: http://$host/html/login.php");
    }
?>
<?php require("../lib/statusheader.php"); ?>
<h2 class="title">记录coofoo微状态</h2>
<div class="content">
    <form action="../lib/statusToDB.php" method="post">
        <textarea name="text" class="status">
        </textarea>
        <br />
        <input type="submit" value="发布" />
    </form>
</div>
<?php require("../lib/footer.php"); ?>
