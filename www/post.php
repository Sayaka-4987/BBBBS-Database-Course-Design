<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>帖子详情</title>

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
            height: 50px;
            padding: 10x 10px;
            margin-right: 15px;
            margin-bottom: 3px;
            margin-top: 5px;
            box-sizing: border-box;
            border-radius: 5px;
            border: rgb(155, 155, 155) 1px solid;
            background-color: #FFFFFF;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            resize: none;
        }
        
        input[type=text] {
            width: 99.3%;
            height: 32px;
            margin-right: 26px;
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
            session_start();

            $forum_name = $_GET['forum'];
            $post_id = $_GET['id'];
            // echo $forum_name.", ".$post_id;
            echo "<div><h1 style='color:#FFFFFF; font-size: 36px; text-shadow: 2px 2px 5px #00000033; text-align: left;'>".$forum_name."</h1></div>";
            

            $con = mysqli_connect('localhost','root','asdfghjkl','bbs');
            if (!$con) {
                echo "<script language=javascript> 
                alert('连接MySQL数据库失败！'.mysqli_connect_error()); 
                window.history.go(-1);
                </script>";
            }   

            mysqli_query($con, 'set names utf8;');
            $sql = "select `post_id`,`author`,`heading`,`content`,`replies`,`last_reply_time`,`forum_name`,`is_recommend`,`username` from `post`,`member` where `forum_name`='".$forum_name."' and `member`.`user_id`=`post`.`author` and `post`.`post_id`=".$post_id.";";

            // echo $sql;

            $res = mysqli_query($con, "$sql");
            if (!$res) {
                echo "<script language=javascript> 
                alert('查询数据库失败！'.mysqli_error($con)); 
                </script>";
            }

            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

            // 1 楼
            $grid_rows = 2;
            $grid_rows_diff = round(mb_strlen($row['content']) / 90);
            if($grid_rows_diff < 1) {
                $grid_rows_diff = 1;
            }

            echo 
            '<div class="post_box" style="grid-row:'.$grid_rows.'/'.($grid_rows + $grid_rows_diff).'">'.
            '<a href="post.php?forum='.$forum_name.'&id='.$row['post_id'].'">'.
            '<div style="font-size: larger; font-weight: bold; color: #003f46;">'.$row["heading"].'</div>'.
            '</a>'.
            '<div>1L：<br>'.$row['content'].'</div>'.
            '<div style="font-size: small; color:#000000AA;">作者：'.$row['username'].'</div>';
            
            $grid_rows += $grid_rows_diff;
            
            if($_SESSION['admin'] == 1) {
                echo '<a href="./db_operation/delete_post.php?id='.$row['post_id'].'"><button>删除</button></a>&nbsp';
                if($row['is_recommend'] == 0) {
                    echo '<a href="./db_operation/change_recommend.php?id='.$row['post_id'].'&top=1"><button>设为精品</button></a>&nbsp';
                } else {
                    echo '<a href="./db_operation/change_recommend.php?id='.$row['post_id'].'&top=0"><button>取消精品</button></a>&nbsp';
                }
                echo '<a href="./db_operation/mute.php?id='.$row['author'].'"><button>封禁该用户</button></a>';
            }  
            echo '</div>';

            // 其他回复
            $sql2 = 'select `reply_id`,`author`,`content`,`quote`,`reply_time`,`post_id`,`username` from `reply`,`member` where `member`.`user_id`=`reply`.`author` and `reply`.`post_id`='.$post_id.';';
            
            // echo $sql2;

            $res2 = mysqli_query($con, "$sql2");
            $reply_num = mysqli_num_rows($res2);
            $reply_rows = mysqli_fetch_all($res2, MYSQLI_ASSOC);
            $floor = 2; 
            foreach ($reply_rows as $reply) {
                // 按内容长度决定分配几行grid  
                $grid_rows_diff = round(mb_strlen($reply['content']) / 90);
                if($grid_rows_diff < 1) {
                    $grid_rows_diff = 1;
                }    
                echo 
                    '<div class="reply_box" style="grid-row:'.$grid_rows.'/'.($grid_rows + $grid_rows_diff).'">'.
                    '<div>'.$floor.'L：<br>'.$reply['content'].'</div>'.
                    '<div style="font-size: small; color:#000000AA;">作者：'.$reply['username'].'</div>';
                
                    $grid_rows += $grid_rows_diff;  

                if($_SESSION['admin'] == 1) {
                    echo '<a href="./db_operation/delete_reply.php?id='.$reply['reply_id'].'"><button>删除</button></a>&nbsp';
                    echo '<a href="./db_operation/mute.php?id='.$row['author'].'"><button>封禁该用户</button></a>';
                }  
                echo '</div>';
                $floor += 1;    
            }

            mysqli_free_result($res);
            mysqli_free_result($res2);

            echo '<div class="post_box" style="grid-row: '.($grid_rows).'/'.($grid_rows+1).';">'.
                '<form action="./db_operation/new_reply.php?id='.$post_id.'" method="post">'.
                '<div style="font-size: larger; font-weight: bold; color: #003f46;">回复本帖：</div>'.
                '<textarea name="content" defaultValue=" 请输入回复内容（不能为空）"></textarea>'.
                '<button type="submit" name="ok">确认发表</button>'.
                '<nobr style="font-size:14px">&nbsp&nbsp&nbsp当前登录：'.$_SESSION['username'].'&nbsp<a href="logout.php ">退出</a></nobr>'.
                '</form>'.
                '</div>';
        ?>

        <div style="position:relative; text-align: center; margin-top: 20px; color: #FFFFFF; font-size: small; text-shadow: 2px 2px 5px #00000088; ">
            Copyright © 2021 by WYX<br> All rights reserved.
        </div>
    </div>
</body>

</html>