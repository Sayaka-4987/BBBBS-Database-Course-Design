<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>设为精品帖</title>
    <link rel="shortcut icon" href="../image/favicon.ico">
    <style type="text/javascript" src="../js/md5.min.js" language="JavaScript"></style>
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
    if($check_admin != 1) {
        echo "<script language=javascript> 
        alert('您没有管理员操作权限！'); 
        window.history.go(-1);
        </script>";
    } else {
        $post_id = $_GET['id'];
        $is_recommend = $_GET['top'];
        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            window.history.go(-1);
            </script>";
        }   
        mysqli_query($con, 'set names utf8;');
    
        $sql = 'update `post` set `is_recommend`='.$is_recommend.' where `post_id`='.$post_id.';';
        // echo $sql;
    
        $res = mysqli_query($con, "$sql");
        if (!$res) {
            echo "<script language=javascript> 
            alert('操作失败！'); 
            window.history.go(-1);
            </script>";
        } else {
            echo "<script language=javascript> 
            alert('操作成功，现在跳转回上一页面……'); 
            window.history.go(-1);
            </script>";
        }
        mysqli_close($con);
    }
?>
</body>
</html>    