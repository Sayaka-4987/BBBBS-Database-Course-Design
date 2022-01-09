<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="refresh" content="0.5;url=index.html"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>账号注册中...</title>
    <link rel="shortcut icon" href="../image/favicon.ico">
    <style type="text/javascript" src="../js/md5.min.js" language="JavaScript"></style>
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
    $usermail = $_POST['mail'];
    $username = $_POST['username'];
    $pwd1 = md5($_POST['password1']);
    $pwd2 = md5($_POST['password2']);

    // echo "'$usermail', '$username', '$pwd1', '$pwd2'<br>";

    if ($pwd1 != $pwd2) {
        echo "<script language=javascript> 
        alert('两次密码输入不一致！'); 
        window.history.go(-1);
        </script>";
    } else {
        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            </script>";
        }   
    
        mysqli_query($con, 'set names utf8;');
        $sql = "insert into `member`(user_mail, username, user_password, join_date, xp, is_admin) values ('"
        .$usermail."','"
        .$username."','"
        .$pwd1."',now(), 1, 0);";
    
        // echo $sql."<br>";
    
        $res = mysqli_query($con, "$sql");
        if (!$res) {
            echo "<script language=javascript> 
            alert('注册失败！'.mysqli_error($con)); 
            </script>";
        } else {
            echo "<script language=javascript> 
            alert('注册成功，现在跳转到论坛内容页……'); 
            window.location.href='forum_list.php';
            </script>";
        }
    }
    mysqli_close($con);
?>
</body>
</html>