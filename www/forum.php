<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BBBBS</title>

    <link rel="shortcut icon" href="image/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/对齐和文字样式.css">
    <link rel="stylesheet" type="text/css" href="css/带阴影的矩形.css">
    <link rel="stylesheet" type="text/css" href="css/带阴影的圆角矩形.css">

    <style type="text/css">
        body {
            /* CSS 设置背景图片 */
            background-image: url("image/background/bg_sea.webp");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        
        textarea {
            width: 100%;
            height: 120px;
            padding: 10x 10px;
            margin-right: 15px;
            margin-bottom: 5px;
            box-sizing: border-box;
            border-radius: 5px;
            border: rgb(155, 155, 155) 1px solid;
            background-color: #FFFFFF;
            font-size: 16px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            resize: none;
        }
        
        input[type=text] {
            width: 99.3%;
            height: 32px;
            margin-right: 25px;
            margin-bottom: 5px;
            margin-top: 10px;
            border-radius: 5px;
            border: rgb(155, 155, 155) 1px solid;
            background-color: #FFFFFF;
            font-size: 16px;
        }
        
        input[type=button] {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.7), rgba(225, 225, 225, 0.6));
            border: none;
            padding: 5px 10px;
            margin: 5px 5px;
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.2);
        }
        
        input[type=button]:hover {
            box-shadow: inset 2px 2px 5px 0px rgba(0, 0, 0, 0.2);
        }
        
        button {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.7), rgba(225, 225, 225, 0.6));
            border: none;
            padding: 5px 10px;
            margin: 5px 0px;
            text-align: center;
            text-decoration: none;
            border-radius: 25px;
            box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.2);
        }
        
        button:hover {
            box-shadow: inset 2px 2px 5px 0px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>


<body>
    <div class="container_post">
        <?php 
            $forum_name = $_GET['name'];
            session_start();
            // if(isset($_SESSION['username'])) {
            // if($_SESSION['admin'] == 1) {

            echo "<div><h1 style='color:#FFFFFF; font-size: 36px; text-shadow: 2px 2px 5px #00000033; text-align: left;'>".$forum_name."</h1></div>";
            
            session_start();

            $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
            if (!$con) {
                echo "<script language=javascript> 
                alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
                window.history.go(-1);
                </script>";
            }   

            mysqli_query($con, 'set names utf8;');
            $sql = "select `post_id`,`author`,`heading`,`content`,`replies`,`last_reply_time`,`forum_name`,`is_recommend`,`username` from `post`,`member` where `forum_name`='".$forum_name."' and `member`.`user_id`=`post`.`author` order by `last_reply_time` desc;";

            // echo $sql;

            $res = mysqli_query($con, "$sql");
            if (!$res) {
                echo "<script language=javascript> 
                alert('查询数据库失败！'.mysqli_error($con)); 
                </script>";
            }

            $res_num = mysqli_num_rows($res);
            // echo $res_num;

            if($res_num != 0) {
                $data_rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
                foreach ($data_rows as $row) {
                    // 截取掉内容的最后一个字
                    $content = mb_substr($row['content'], 0, -1, 'utf-8');
                    echo 
                        '<div class="post_box">'.
                        '<a href="post.php?forum='.$forum_name.'&id='.$row['post_id'].'">';
                    if ($row['is_recommend'] == 1) {
                        echo '<div style="font-size: larger; font-weight: bold; color: #003f46;">'.'【精品】'.$row["heading"].'</div>'.'</a>';
                    } else {
                        echo '<div style="font-size: larger; font-weight: bold; color: #003f46;">'.$row["heading"].'</div>'.'</a>';
                    }
                    
                    // 正文超过90字的就只显示前90个字    
                    if(mb_strlen($content) <= 90) {
                        echo '<div style="color: #000000">"'.$content.'……"</div>';
                    } else {
                        $short_content = mb_substr($content, 0, 90, 'utf-8');
                        echo '<div style="color: #000000">"'.$short_content.'……"</div>';
                    }  

                    echo '<div style="font-size: small; color: #000000AA">作者：'.$row['username'].'&nbsp&nbsp回复数: '.$row['replies'].', 上次更新时间: '.$row['last_reply_time'].'</div>';
                    if($_SESSION['admin'] == 1) {
                        // 显示管理按钮
                        echo '<a href="./db_operation/delete_post.php?id='.$row['post_id'].'"><button>删除</button></a>&nbsp';
                        if($row['is_recommend'] == 0) {
                            echo '<a href="./db_operation/change_recommend.php?id='.$row['post_id'].'&top=1"><button>设为精品</button></a>&nbsp';
                        } else {
                            echo '<a href="./db_operation/change_recommend.php?id='.$row['post_id'].'&top=0"><button>取消精品</button></a>&nbsp';
                        }
                        echo '<a href="./db_operation/mute.php?id='.$row['author'].'"><button>封禁该用户</button></a>';
                    }  
                    echo '</div>';
                }
            } else {
                // 结果为0时
                echo '<div class="post_box"><br>&nbsp这个版块还没有帖子……<br></div>';
            }            
            mysqli_free_result($res); 

            echo '<div class="post_box" style="grid-row: '.($res_num+2).'/'.($res_num+4).';">'.
                '<form action="./db_operation/new_post.php?name='.$forum_name.'" method="post">'.
                '<div style="font-size: larger; font-weight: bold; color: #003f46;">在本版面发帖：</div>'.
                '<input type="text" name="heading" placeholder=" 请输入帖子标题（不能为空）"><br>'.
                '<textarea name="content" defaultValue=" 请输入帖子内容（不能为空）"></textarea>'.
                '<button type="submit" name="ok">确认发表</button>&nbsp&nbsp&nbsp'.
                '<button formaction="forum_list.php" name="back_home">返回主页</button>'.
                '<nobr style="font-size:14px">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp当前登录：'.$_SESSION['username'].'&nbsp<a href="logout.php ">退出</a></nobr>'.
                '</form>'.
                '</div>';
        ?>

        <div style="position:relative; text-align: center; margin-top: 20px; color: #FFFFFF; font-size: small; text-shadow: 2px 2px 5px #00000088; ">
            Copyright © 2021 by WYX<br> All rights reserved.
        </div>
    </div>
</body>

</html>