<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>登录页面</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .wrap{
            width: 800px;
            overflow: hidden;
            margin:50px auto;
            border: 1px solid #ccc;
            padding:50px;
            font-family:"Microsoft Yahei";
        }
        .wrap h1{
            font-weight:normal;
            margin-bottom:30px;
            font-size:20px;
            color:#009635;
        }
       
        .wrap p,.wrap div{
            margin-bottom:20px;
            line-height: 36px;
            overflow: hidden;
        }

        .wrap .left{
            width:60px;
            float: left;
        }
        .wrap p input{
            width:285px;
            height: 36px;
            line-height: 36px;
            border: 1px solid #ccc;
            float: left;
            padding-left: 5px;
            outline:none;
        }
        .wrap label{
            padding:0 30px 0 5px;
        }
        .error{
            color:red;
            margin-left: 10px;
            font-size:12px;
        }
        .submit{
            width:100px;
            height:30px;
            background: #009635;
            color:#fff;
            border:none;
            margin-left: 60px;
        }
         a{
            font:14px/50px "Microsoft Yahei";
            display: inline-block;
            margin-left: 20px;
            color:#333;
        }
    </style>

    </head>
    <body>
        <?php
            //错误提示
            $pswerr = $emailerr = '*';
			$selfpath = '';
            $selfpath = $_SERVER['PHP_SELF'];//获取本页面的路径
			
            //value值
            $email = $password = '';
            //转义符转换成html函数
            function htmlTransCharFn($data){    
                //1.（通过 PHP trim() 函数）去除用户输入数据中不必要的字符（多余的空格、制表符、换行）
                $data = trim($data);
                //2.（通过 PHP stripslashes() 函数）删除用户输入数据中的反斜杠（\）
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            //获取提交方式
            $method = $_SERVER['REQUEST_METHOD'];
            if($method == 'POST'){
				$email = htmlTransCharFn($_POST['email']);
				$password = htmlTransCharFn($_POST['password']);
				//正则匹配
				$emailmatch = !preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email);
				$passwordmatch = !preg_match('/^[a-zA-Z\d_]{8,}$/',$password);
		
				//判断
				if(empty($email)||empty($password)){
					//内容不能为空
					if(empty($email)){
						$emailerr = '邮箱不能为空';
					}
					if(empty($password)){
						$pswerr = '密码不能为空';
					}
				}else if($emailmatch||$passwordmatch){
					//判断是否输入正确
					if(!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email)){
						$emailerr = '邮箱格式不对';
					}
					if(!preg_match('/^[a-zA-Z\d_]{8,}$/',$password)){
						$pswerr = '密码最少8位，只能是字母和数字';
					}
				}else{
					//都正确的话，链接数据库，添加数据
					
					$mysql_database = 'userdata';//定义数据库名字
					$mysqulcon = mysql_connect('localhost','root','root');//链接数据库
					
					if(!$mysqulcon){
						die('Could not connect: ' . mysql_error());
					}
					
					mysql_select_db($mysql_database); //打开要操作的数据库
					
					//判断数据库中是否有此邮箱
					$sqlselemail = "select * from userform where email='$email'";
					$resultemail = mysql_query($sqlselemail);//执行sql语句
					$resultemaillen = mysql_num_rows($resultemail);//获取结果集中行的数目
					if($resultemaillen == 0){
						//邮箱错误
						$emailerr = '邮箱错误';
					}else{
						//用户名输入正确，判断密码是否正确
						$row = mysql_fetch_array($resultemail);//获取查找结果
						//获取用户名和密码
						$getemail = $row['email'];
						$getpassword = $row['password'];
						
						if($password != $getpassword){
							$pswerr = '密码输入错误';
						}else{
							//登录成功：将输入正确的用户名和密码存入session
							$_SESSION['email']=$getemail;
							
							
							echo '<script type="text/javascript">window.location.href="index.php";</script>';
						}
					}
					mysql_close($mysqulcon);
				}
			}
            
        ?>
        <div class="wrap">
            <h1>登录页面</h1>
            <form method="post" action="<?php echo htmlspecialchars($selfpath);?>">
                 <p>
                    <span class="left">邮箱：</span>
                    <input type="text" name="email" value="<?php echo $email;?>"/>
                    <span class="error"><?php echo $emailerr?></span>
                </p>
                <p>
                    <span class="left">密码：</span>
                    <input type="password" name="password" value="<?php echo $password;?>"/>
                    <span class="error"><?php echo $pswerr?></span>
                </p>
                <div>
                    <input type="submit" class="submit" value="登录"/>
                    <a href="register.php">没有账号，点击注册</a>
                </div>
                
            </form>
        </div>
        
    </body>
</html>