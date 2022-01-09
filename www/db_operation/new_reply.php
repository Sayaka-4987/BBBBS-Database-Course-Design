<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- <meta http-equiv="refresh" content="1;url=forum_list.php"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>发表回复</title>
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

    $username = $_SESSION['username'];
    $post_id = $_GET['id'];
    $content = $_POST['content'];
    // echo $post_id.', '.$content;

    $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
    if (!$con) {
        echo "<script language=javascript> 
        alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
        window.history.go(-1);
        </script>";
    }   
    mysqli_query($con, 'set names utf8;');

    // 查询当前在线的用户 user_id
    $sql1 = 'select `user_id` from `member` where username="'.$username.'";';
    //echo $sql1."<br>";
    $res1 = mysqli_query($con, "$sql1");
    $row1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
    $uid = $row1['user_id'];
    //echo $uid."<br>";

    // 查询当前用户等级
    $sql2 = 'select xp from `member` where user_id='.$uid.';';
    $res2 =  mysqli_query($con, "$sql2");
    $row2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);
    $rank = $row2['xp'];

    if ($rank <= 0) {
        // 用户被禁言的情况
        echo "<script language=javascript> 
            alert('您已经被禁言！现在为您跳转回上一页面……'); 
            window.history.go(-1);
            </script>";
    } else {
        // 插入回复表
        $sql3 = 'insert into `reply`'.
            '(`author`,`content`,`reply_time`,`post_id`)'.
            ' values ('.$uid.',"'.$content.'", now(), "'.$post_id.'");';
        $res3 = mysqli_query($con, "$sql3");    

        if(!$res3) {
            echo "<script language=javascript> 
                alert('回复失败！现在为您跳转回上一页面……'); 
                window.history.go(-1);
                </script>";
        } else {
            // 已经用触发器代替：
            // $sql3 = 'update `post` set `replies` = `replies` + 1 where `post_id`='.$post_id.';';
            // $res3 = mysqli_query($con, "$sql3");    
            // $sql4 = 'update `post` set `last_reply_time` = now() where `post_id`='.$post_id.';';
            // $res4 = mysqli_query($con, "$sql4");    
            echo "<script language=javascript> 
                alert('回复成功！现在为您跳转回上一页面……'); 
                window.history.go(-1);
                </script>";
        }
    }   
    mysqli_close($con);    
?>
</body>

</html>