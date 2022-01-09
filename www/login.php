<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="refresh" content="0.5;url=forum_list.php">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>用户登录</title>
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

    $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
    if (!$con) {
        echo "<script language=javascript> 
        alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
        window.history.go(-1);
        </script>";
    }   

    if(!isset($_SESSION['username'])) {
        // 如果用户未登录，即未设置 $_SESSION['username'] 时，执行以下代码
        $usermail = $_POST['mail'];
        $pwd = md5($_POST['password']);
        $save_session = $_POST['is_save'];

        mysqli_query($con, 'set names utf8;');
        $sql = "select * from `member` where `user_mail`="."'".$usermail."'".
              " and `user_password`='".$pwd."';";

        $res = mysqli_query($con, "$sql");
        if (!$res) {
            echo "<script language=javascript> 
            alert('查询数据库失败！'.mysqli_error($con)); 
            </script>";
        }

        $res_num = mysqli_num_rows($res);

        if ($res_num != 0) {
            // 数据库有该用户信息，登录成功
            $row = mysqli_fetch_array($res);
            $username = $row['username'];

            // 长期保存登录状态
            $_SESSION['username'] = $row['username'];
            $_SESSION['admin'] = $row['is_admin'];
            
            echo "<script language=javascript> 
            alert('登录成功，欢迎 $username ！'); 
            </script>";
        }
        else {
            echo "<script language=javascript> 
            alert('该用户不存在，正在为您跳转注册页面……'); 
            window.location.href='new_member.html';
            </script>";
        }    
    } else { 
        // 已有 $_SESSION['username'] 时
        $username = $_SESSION['username'];
        echo "<script language=javascript> 
            alert('您已经成功登录，欢迎 $username ！'); 
            </script>";
    }    

    mysqli_close($con);
?>
</body>
</html>