<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>首页</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        .wrap{
            width: 500px;
            margin:50px auto;
            font-family: Microsoft Yahei;
        }
        .left{
            float: left;
        }
      
       
        .wrap .user{
            overflow: hidden;
            margin-bottom:20px;
        }
        .user .left{
            width:140px;
			height:140px;
			border-radius:50%;
        }
        .user .right{
            float: left;
            margin-left: 20px;
            width:340px;
        }
        .user h3{
            font-size:30px;
            font-weight: normal;
            margin-top: 20px;
        }
        .user p{
            font-size:14px;
            line-height:24px;
            margin-top: 12px;
            color:#666;
        }
        .user .btn{
            margin-top: 20px;
        }
         .user .btn a{
            font:14px/50px "Microsoft Yahei";
            display: inline-block;
            margin-right: 20px;
            text-decoration: none;
            color:#fff;
            height:36px;
            line-height: 36px;
            padding:0 30px;
            background:#00a2a2;
        }
		.show{
			display:block;
		}
		.hide{
			display:none;
		}
		.content{
			font-size: 12px;
			text-decoration: none;
			line-height:30px;
		}
		.content a{
			color:blue;
		}
    </style>
</head>
<body>
    <?php
        $comment = '';
		$username = '未登录';
		$portrait = 'portrait.jpg';
		$commentClass = 'hide';
		$btnClass = 'show';
		
		//$commentEle = '<p class="comment">$comment</p>';
        
		//判断是否登录成功方法
		function is_login(){
			//session里面是否有email
			if(isset($_SESSION['email'])){
				return true;
			}
			return false;
		}
		
		
		if(is_login()){
			//如果已经登录   显示用户名和简介
			$email = $_SESSION['email'];
			$commentClass = 'show';
			$btnClass = 'hide';
			//获取用户头像和简介内容
			$mysql_database = 'userdata';//定义数据库名字
			$mysqulcon = mysql_connect('localhost','root','root');//链接数据库
			
			if(!$mysqulcon){
				die('Could not connect: ' . mysql_error());
			}
			
			mysql_select_db($mysql_database); //打开要操作的数据库
			
			$sqlselemail = "select * from userform where email='$email'";
			
			$resultemail = mysql_query($sqlselemail);//执行sql语句
			$row = mysql_fetch_array($resultemail);//获取查找结果
			
			$username = $row['username'];//获取用户名
			$comment = $row['comment'];//获取评论内容
			$portrait = $row['portrait'];//获取用户头像
			
		}else{
			//如果没有登录  显示登录和注册按钮
			$username = '未登录';
			$commentClass = 'hide';
			$btnClass = 'show';
		}
		
	?>

    <div class="wrap">
        <div class="user">
            <img src="images/<?php echo $portrait;?>" class="left" />
            <div class="right">
                <h3 class="username"><?php echo $username;?></h3>
				<div class="content <?php echo $commentClass?>">
					<p class="comment"><?php echo $comment;?></p>
					<a href="loginout.php">退出登录</a>
				</div>
                <div class="btn <?php echo $btnClass?>">
                    <a href="register.php">注册</a>
                    <a href="login.php">登录</a>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>
<!-- <script type="text/javascript">window.location.href='';</script>   -->