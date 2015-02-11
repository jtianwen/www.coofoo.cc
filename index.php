<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>天涯云水路漫漫</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="css/mystyle.css" />
    </head>
    <body>
        <div class="header">
            <h1>天涯云水-coofoo空间</h1>
            <p style="font-size: 16px; ">
                <?php 
                    if($_SESSION["authenticated"])
                        echo "已登录 "."<a style='color: #FFFFFF;' href='html/logout.php'>退出</a>";
                    else
                        echo "未登录 "."<a style='color: #FFFFFF;' href='html/login.php'>登录</a>";
                ?>
            </p>
        </div>
        <h2 class="title">coofoo博客</h2>
        <div class="content">
            <ul>
                <li><a href="blog/005.php">微信公众平台开发：初体验</a></li>
                <li><a href="blog/004.php">在浏览器输入网址，Enter之后发生了什么？</a></li>
                <li><a href="blog/003.php">k-近邻算法应用之手写数字识别</a></li>
                <li><a href="blog/002.php">k-近邻算法以及算法实例</a></li>
                <li><a href="blog/001.php">电脑杀毒记</a></li>
            </ul>
        </div>
        <h2 class="title">coofoo微状态</h2>
        <div class="content">
        <?php
            if($_SESSION["authenticated"])
                echo "<a href='html/write_status.php'>添加微状态</a>";
			require("etc/configuration.php");
            require("lib/indexstatus.php");
        ?>
        </div>
        <div class="footer">
            天涯云水-CooFoo空间 email:jtianwen2014@163.com
        </div>
    </body>
</html>
