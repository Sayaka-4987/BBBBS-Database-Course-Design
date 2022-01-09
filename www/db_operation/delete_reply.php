<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>删除回复</title>
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
        $reply_id = $_GET['id'];

        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            window.history.go(-1);
            </script>";
        }   
        mysqli_query($con, 'set names utf8;');
    
        // 查 post_id
        $sql = 'select * from `reply` where `reply_id`='.$reply_id.';';
        $res = mysqli_query($con, "$sql"); 
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $post_id = $row['post_id'];
    
        $sql1 = 'delete from `reply` where `reply_id`='.$reply_id.';';
        $res = mysqli_query($con, "$sql1");
        if(!$res) {
            echo "<script language=javascript> 
                alert('删除操作失败！'); 
                window.history.go(-1);
                </script>";
        } else {
            // 已经用触发器代替：
            // $sql3 = 'update `post` set `replies` = `replies` - 1 where `post_id`='.$post_id.';';
            // $res3 = mysqli_query($con, "$sql3"); 
            echo "<script language=javascript> 
                alert('删除成功！正在跳转回上一页面……'); 
                window.history.go(-1);
                </script>";
        }
        mysqli_close($con);
    }
?>
</body>
</html>