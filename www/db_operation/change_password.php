<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="refresh" content="0.5;url=../forum_list.php">
    <title>修改密码</title>
    <link rel="shortcut icon" href="../image/favicon.ico">
    <style type="text/javascript" src="../js/md5.min.js" language="JavaScript"></style>
    <style type="text/css">
        body {
            background-image: url("image/background/bg_tree.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style> 
</head>

<body>
<?php
    $uid = $_GET['id'];
    $old_password = md5($_POST['old_password']);
    $password1 = md5($_POST['new_password1']);
    $password2 = md5($_POST['new_password2']);

    // echo "'$uid', '$old_password', '$password1', '$password2'<br>";

    if ($password1 != $password2) {
        echo "<script language=javascript> 
        alert('两次密码输入不一致！'); 
        </script>";
    } else {
        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            </script>";
        } else {
            mysqli_query($con, 'set names utf8;');
            $sql1 = 'select user_mail from `member` where user_id = '.$uid.' and user_password = "'.$old_password.'";';

            $res1 = mysqli_query($con, "$sql1");
            $res1_num = mysqli_num_rows($res1);
            if ($res1_num < 1) {
                echo "<script language=javascript> 
                alert('旧密码输入错误！'); 
                </script>";
            } else {
                $sql2 = 'update `member` set user_password = "'.$password1.'" where user_id = '.$uid.'; ';
                // echo $sql2;
                $res2 = mysqli_query($con, "$sql2");
                if (!$res2) {
                    echo "<script language=javascript> 
                    alert('修改失败！'); 
                    </script>";
                } else {
                    echo "<script language=javascript> 
                    alert('修改成功，注意保护好您的新密码！'); 
                    </script>";
                }
            }            
        }        
    }    
    mysqli_close($con);
?>
</body>
</html>