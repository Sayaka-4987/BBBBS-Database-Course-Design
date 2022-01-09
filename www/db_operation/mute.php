<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- <meta http-equiv="refresh" content="1;url=forum_list.php"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>封禁用户</title>
    <link rel="shortcut icon" href="../image/favicon.ico">
    <style type="text/javascript" src="./js/md5.min.js" language="JavaScript"></style>
    <style type="text/css">
        body {
            background-image: url("image/background/bg_sea.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style> 
</head>

<body>
<?php
    session_start();
    $check_admin = $_SESSION['admin'];
    $username = $_SESSION['username'];
    $uid = $_GET['id'];
    // echo $username.', '.$uid;

    if($check_admin != 1) {
        echo "<script language=javascript> 
        alert('您没有管理员操作权限！'); 
        window.history.go(-1);
        </script>";
    } else {
        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            window.history.go(-1);
            </script>";
        }   
        mysqli_query($con, 'set names utf8;');
    
        $sql1 = 'select xp,username from `member` where user_id='.$uid.';';
        // echo $sql1;
        $res1 =  mysqli_query($con, "$sql1");
        $row1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
        $old_rank = $row1['xp'];
        $mute_user = $row1['username'];
        // echo $old_rank;
    
        $sql2 = 'update `member` set xp=0 where user_id='.$uid.';';
        $res2 = mysqli_query($con, "$sql2");
    
        if(!$res2) {
            echo "<script language=javascript> 
                alert('封禁失败！'); 
                window.history.go(-1);
                </script>";
        } else {
            echo "<script language=javascript> 
            alert('管理员 ".$username." 已禁言用户 ".$mute_user."！'); 
            window.history.go(-1);
            </script>";   
        }   
        mysqli_close($con);  
    }
?>
</body>
</html>