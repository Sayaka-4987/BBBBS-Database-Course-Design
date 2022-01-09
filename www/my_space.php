<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>个人中心</title>

    <link rel="shortcut icon" href="image/favicon.ico">

    <style type="text/css">
        @import url("css/带阴影的圆角矩形.css");
        @import url("css/对齐和文字样式.css");
        body {
            /* CSS 设置背景图片 */
            background-image: url("image/background/bg_tree.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

    <!-- <style type="text/javascript" src="./js/文字闪烁.js" language="JavaScript"></style> -->
</head>

<body>
    <?php 
        // 使用会话内存储的变量值之前必须先开启会话
        session_start();
        $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
        if (!$con) {
            echo "<script language=javascript> 
            alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
            window.history.go(-1);
            </script>";
        }   
        mysqli_query($con, 'set names utf8;');
        $sql1 = "select user_id, join_date, xp, is_admin from `member` where username ='".$_SESSION['username']."';";
        $res1 = mysqli_query($con, "$sql1");
        $row1 = mysqli_fetch_array($res1, MYSQLI_ASSOC);
        $uid = $row1['user_id'];
        $jdate = $row1['join_date'];
        $rank = $row1['xp'];
    ?>
    <div class="rounded_shadow_rectangle">
        <div class="text_left_align_margin40">
            <h1>修改密码</h1>
        </div>

        <div class="text_center_align_margin40">
            <?php 
                echo '<form action="./db_operation/change_password.php?id='.$uid.'" method="post">'
            ?>
                <table style="margin: 15px; width: 350px; padding: 0%;" border="0" cellspacing="0">
                    <tr>
                        <!-- 昵称显示 -->
                        <?php    
                            // 显示用户信息
                            if($_SESSION['admin'] == 1) {
                                echo '<td colspan="2"><div style="font-size: small; line-height: 160%;">当前登录用户：'.$_SESSION['username'].'&nbsp&nbsp&nbsp<a style="color:#c69222">▶管理员◀</a>&nbsp&nbsp&nbsp<a href="logout.php ">退出登录</a>'
                                .'<br>注册时间：'.$jdate.'，等级：Lv.'.$rank.'<br>'
                                .'<br></div></td>';
                            } else {
                                if (!$_SESSION['username']) {
                                    echo '<td colspan="2"><div style="font-size: small; line-height: 160%;">游客您好，<a href="index.html">登录</a>后查看更多精彩内容！'
                                    .'<br></div></td>';
                                } else {
                                    echo '<td colspan="2"><div style="font-size: small; line-height: 160%;">当前登录用户：'.$_SESSION['username'].'&nbsp&nbsp&nbsp<a href="logout.php ">退出登录</a>'
                                    .'<br>注册时间：'.$jdate.'，等级：Lv.'.$rank.'<br>'
                                    .'<br></div></td>';
                                }
                            }
                        ?>
                    </tr>
                    <tr>
                        <td>旧的密码：&nbsp&nbsp&nbsp&nbsp</td>
                        <td><input class="rounded_input" type="password" name="old_password" placeholder=" 请输入您的密码"></td>
                    </tr>
                    <tr>
                        <td>新的密码：&nbsp&nbsp&nbsp&nbsp</td>
                        <td><input class="rounded_input" type="password" name="new_password1" placeholder=" 请输入您的密码"></td>
                    </tr>
                    <tr>
                        <td>确认新密码：</td>
                        <td><input class="rounded_input" type="password" name="new_password2" placeholder=" 再次输入您的密码"></td>
                    </tr>
                </table>
                <button class="rounded_button" name="register">确定</button>
                <a href="forum_list.php">
                    <div class="rounded_button">返回</div>
                </a>
            </form>
        </div>
    </div>
</body>

</html>