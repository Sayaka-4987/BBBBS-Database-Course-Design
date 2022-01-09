<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="refresh" content="0.5;url=forum_list.php">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户登出</title>
    <link rel="shortcut icon" href="image/favicon.ico">
    <style type="text/javascript" src="./js/md5.min.js" language="JavaScript"></style>
    <style type="text/css">
        body {
            background-image: url("image/background/bg_mountain.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style> 
</head>

<body>
<?php
    session_start();

    if(isset($_SESSION['username'])) {
        $_SESSION = array();

        //如果存在一个会话cookie，通过将到期时间设置为之前1个小时从而将其删除
        if(isset($_COOKIE[session_name()])){
            setcookie(session_name(),'',time()-3600);
        }

        setcookie('username','',time()-3600);
        setcookie('admin','',time()-3600);
        
        echo "<script language=javascript> 
            alert('已成功退出登录，正在跳转回论坛主页……'); 
            window.location.href='index.html';
            </script>";
            
        // 使用内置session_destroy()函数调用撤销会话
        session_destroy();
    }
?>
</body>
</html>