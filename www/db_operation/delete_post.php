<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- <meta http-equiv="refresh" content="1;url=forum_list.php"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>删除帖子</title>
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

        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            window.history.go(-1);
            </script>";
        }   
        mysqli_query($con, 'set names utf8;');
    
        // 查版块名
        $sql = 'select * from `post` where `post_id`='.$post_id.';';
        $res = mysqli_query($con, "$sql"); 
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $forum_name = $row['forum_name'];
    
        // 删除帖子，改为调用存储过程的版本
        mysqli_query($con, 'SET @p0="'.$post_id.'";');
        mysqli_query($con, 'SET @p1="'.$forum_name.'";');
        $sql1 = 'CALL `delete_post`(@p0, @p1);';
        $res = mysqli_query($con, "$sql1");
    
        if(!$res) {
            echo "<script language=javascript> 
                alert('删除操作失败！'); 
                window.history.go(-1);
                </script>";
        } else {
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