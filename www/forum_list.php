<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎来到 BBBBS! </title>

    <link rel="shortcut icon" href="image/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/对齐和文字样式.css">
    <link rel="stylesheet" type="text/css" href="css/带阴影的矩形.css">
    <link rel="stylesheet" type="text/css" href="css/带阴影的圆角矩形.css">

    <style type="text/css">
        body {
            /* CSS 设置背景图片 */
            background-image: url("image/background/bg_mountain.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

    <script language=javascript>
        function myAlert(str) {    
            alert("" + str);
        }
    </script>
</head>


<body>
    <div class="container ">
        <div style="grid-column: 1/4; ">
            <h1 style="color:#FFFFFF; font-size: 36px; text-shadow: 2px 2px 5px #002C4DCC; ">BBBBS</h1>
        </div>
        <a href="forum.php?name=杂谈灌水">
            <button class="forum_box" style="background-color: #003366CC; ">
                <div class="forum_name" style="color:#FFFFFF; ">杂谈灌水</div>
            </button>
        </a>
        <a href="forum.php?name=资源分享">
            <button class="forum_box" style="background-color: #6699CCCC; ">
                <div class="forum_name">资源分享</div>
            </button>
        </a>
        <a href="my_space.php">
            <button class="forum_box" style="background-color: #669999CC; ">
                <div class="forum_name">个人中心</div>
            </button>
        </a>
        <a href="forum.php?name=李妍兵文学">
            <button class="forum_box" style="background-color: #FFBB99CC; ">
                <div class="forum_name">李妍兵文学</div>
            </button>
        </a>
        <button onclick="myAlert('本站用于BJTU数据库作业 \nGitHub: https://github.com/Sayaka-4987 \n微信号: A262asdf')" class="forum_box" style="background-color: #FFCCCCCC; ">
            <div class="forum_name">联系站长</div>
        </button>
        <button class="forum_box" style="background-color: #CCCCCCCC; ">
            <div style="position: relative; height: 100%; transform: translate(0%, 40%); ">
                <!-- 昵称显示 -->
                <?php
                    // 使用会话内存储的变量值之前必须先开启会话
                    session_start();

                    // 检查登录状态
                    if(isset($_SESSION['username'])) {
                        if($_SESSION['admin'] == 1) {
                            echo '当前在线：管理员'.$_SESSION['username'].'<br>';
                        }
                        else {
                            echo '当前在线：'.$_SESSION['username'].'<br>';
                        }
                        echo '<a href="logout.php ">退出</a>';
                    } else {
                        echo '游客您好，<a href="index.html">登录</a>后查看更多精彩内容！';
                    }
                ?>
            </div>
        </button>

        <div style="grid-column: 1/4; 
                    position:relative; 
                    text-align: center; 
                    color: #FFFFFF; 
                    font-size: small; 
                    text-shadow: 2px 2px 5px #00000088;">
            Copyright © 2021 by WYX<br> All rights reserved.
        </div>
    </div>
</body>

</html>