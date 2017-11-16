<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
    <meta charset="utf-8">
	<title>注册页面</title>
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
            font-size:20px;
			margin-bottom:30px;
			color:#009635;
		}
		.wrap textarea{
			width: 280px;
			height:90px;
			resize:none;
			float: left;
			border: 1px solid #ccc;
			padding:5px;
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
		div a{
            font:14px/50px "Microsoft Yahei";
            display: inline-block;
            margin-left: 20px;
            color:#333;
        }
		.privewImg{
			overflow:hidden;
			font-family:Microsoft Yahei;
		}
		.privewImg .left span{
			font-size:14px;
			color:#666;
			display:block;
		}
		.upload{
			width:140px;
			height:140px;
			border-radius:50%;
			position:relative;
			margin:20px 0;
			float:left;
			border:1px solid #ccc;
		}
		.upload img{
			position:absolute;
			top:0;
			left:0;
			width:100%;
			height:100%;
			border-radius:50%;
		}
		.upload input{
			position:absolute;
			top:0;
			left:0;
			width:100%;
			height:100%;
			opacity:0;
			border-radius:50%;
		}
		.privewImg .portraiterr{
			color:red;
			line-height:50px;
			font-size:14px;
			float:left;
			margin-left: 20px;
			line-height: 160px;
		}
	</style>

    </head>
    <body>
		<?php
			date_default_timezone_set('PRC');//防止data出warning
			//错误提示
			$nameerr = $pswerr =  $emailerr = $genderr  = $commenterr = '*';
			$portrait = 'portrait.jpg';
			$portraiterr = '可以是jpg和png格式，不能大于1M';
			$selfpath = $_SERVER['PHP_SELF'];//获取本页面的路径
			
			//value值
			$username = $password = $email = $comment = '';
			
			//测试数据
			$mysqlcon = '';

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
				//获取内容
				$email = htmlTransCharFn($_POST['email']);
				$password = htmlTransCharFn($_POST['password']);
				$username = htmlTransCharFn($_POST['username']);
				$comment = htmlTransCharFn($_POST['comment']);
				$gender = htmlTransCharFn($_POST['gender']);
				$file = $_FILES['portraitpath'];
				//正则匹配
				$emailmatch = !preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email);
				$passwordmatch = !preg_match('/^[a-zA-Z\d_]{8,}$/',$password);
				$usernamematch = !preg_match('/^[a-zA-Z0-9_-]{4,16}$/',$username);
				$commentmatch = strlen($comment)<5;
				
				//判断
				if(empty($email)||empty($password)||empty($username)||empty($comment)||$file["error"]){
					//内容不能为空
					if(empty($email)){
						$emailerr = '邮箱不能为空';
					}
					if(empty($password)){
						$pswerr = '密码不能为空';
					}
					if(empty($username)){
						$nameerr = '用户名不能为空';
					}
					if(empty($comment)){
						$commenterr = '评论内容不能为空';
					}
					if($file["error"]){
						$portraiterr = '上传错误';
					}
					
				}else if($emailmatch||$passwordmatch||$usernamematch||$commentmatch){
					//判断是否输入正确
					if(!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email)){
						$emailerr = '邮箱格式不对';
					}
					if(!preg_match('/^[a-zA-Z\d_]{8,}$/',$password)){
						$pswerr = '密码最少8位，只能是字母和数字';
					}
					if(!preg_match('/^[a-zA-Z0-9_-]{4,16}$/',$username)){
						$nameerr = '用户名必须4-16位，可以包含字母，数字，下划线，减号';
					}
					if(strlen($comment)<5){
						$commenterr = '评论内容不能少于5个字符';
					}
					
				}else{
					//图片处理：控制上传文件的类型，大小 1M之内  1M=1024k=1048576字节
					if(($file["type"]=="image/jpeg" || $file["type"]=="image/png") && $file["size"]<1048576){
						//找到文件存放的位置
						$portraitname = date("Ymd").$file["name"];
						$filename = "images/".$portraitname;

						//转换编码格式
						$filename = iconv("UTF-8","gb2312",$filename);
						
						//判断文件是否存在
						if(file_exists($filename)){
							echo "该文件已存在！";
						}else{
							//保存文件
							move_uploaded_file($file["tmp_name"],$filename);
							$portrait = $portraitname;
						}
					}
					else{
						if($file["type"]!="image/jpeg" && $file["type"]!="image/png"){
							$portraiterr = '图片格式不对';
						}else if($_FILES["portrait"]["size"]>1048576){
							$portraiterr = '图片不能大于1M';
						}
					}
					
					//都正确的话，链接数据库，添加数据
					$mysqlcon='';
					
					$id=1;		
					$mysql_database = 'userdata';//定义数据库名字
					$mysqulcon = mysql_connect('localhost','root','root');//链接数据库
					
					if(!$mysqulcon){
						die('Could not connect: ' . mysql_error());
					}
					$mysqlcon = '成功';
					mysql_select_db($mysql_database); //打开要操作的数据库
					//判断用户名是否被使用 
					$sqlselname = "select * from userform where username='$username'";
					$resultname = mysql_query($sqlselname);//执行sql语句
					$resultnamelen = mysql_num_rows($resultname);//获取结果集中行的数目
					//判断邮箱是否被使用
					$sqlselemail = "select * from userform where email='$email'";
					$resultemail = mysql_query($sqlselemail);//执行sql语句
					$resultemaillen = mysql_num_rows($resultemail);//获取结果集中行的数目
					if($resultnamelen == 0 && $resultemaillen == 0){
						//没有被占用，添加数据
						//sql语句：添加数据
						$sqlinsert = "insert into userform(email, password, username, gender,comment,portrait,id)values('$email','$password','$username','$gender','$comment','$portrait','$id')";
						//执行语句操作
						mysql_query($sqlinsert);
						
						//注册成功：将输入正确的用户名和密码存入session
						$mysqlcon = '注册成功';
						
						$_SESSION['email']=$email;
						
						echo '<script type="text/javascript">window.location.href="index.php";</script>';
					
					}else{
						//用户名或者邮箱已被占用
						if($resultnamelen != 0){
							$nameerr = '该用户名已被占用';
						}
						if($resultemaillen != 0){
							$emailerr = '该邮箱已被占用';
						}
					}
					mysql_close($mysqulcon);
				}
			}
		?>
		<div class="wrap">
			<h1>注册页面</h1>
			<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($selfpath);?>">
				<p>数据库：<?php echo $mysqlcon;?></p>
	           <p>
					<span class="left">邮箱：</span>
					<input type="text" name="email" value="<?php echo $email;?>"/>
					<span class="error"><?php echo $emailerr;?></span>
				</p>
	            <p>
					<span class="left">密码：</span>
					<input type="password" name="password" value="<?php echo $password;?>"/>
					<span class="error"><?php echo $pswerr;?></span>
				</p>
				
				 <p>
					<span class="left">昵称：</span>
					<input type="text" name="username" value="<?php echo $username;?>"/>
					<span class="error"><?php echo $nameerr;?></span>
				</p>
				<div>
					<span class="left">性别：</span>
					<input type="radio" name="gender" value="boy" id="boy" checked="checked"/> 
					<label for="boy">男</label>
					<input type="radio" name="gender" value="girl" id="girl"/>
					<label for="girl">女</label>
				</div>
				<div class="privewImg">
					<span class="left">头像：</span>
					<div class="upload">
						<img src="images/<?php echo $portrait;?>" id="imgPortrait"/>
						<input type="file" name="portraitpath" id="changeBtn"/>
					</div>
					<span class="portraiterr"><?php echo $portraiterr;?></span>
				</div>
				<p>
					<span class="left">简介：</span>
					<textarea name="comment" value="<?php echo $comment;?>"><?php echo $comment;?></textarea>
					<span class="error"><?php echo $commenterr;?></span>
				</p>
	            <div>
	            	<input type="submit" class="submit" value="注册"/>
	            	<a href="login.php">已有账号，点击登录</a>
	            </div>
				
	        </form>
		</div>
        <script>
		//预览
		document.getElementById('changeBtn').addEventListener('change', function() { 
			 var _this = this;
			 var oImg = document.getElementById('imgPortrait');
			 var file  = _this.files[0];
			 //保证上传的图片 而且 图片小于1m
			 if((file.type == "image/jpeg" || file.type == "image/png") && file.size < 1048576){
				 var reader = new FileReader();
				 reader.onloadend = function () {
					 console.log(reader.result);
					 oImg.src = reader.result;
				 }
				 if (file) {
				    reader.readAsDataURL(file);
				 } else {
				    oImg.src = "";
				 }
			 }else{
				 if(file.type != "image/jpeg" && file.type != "image/png"){
					 alert('图片格式不对');
				 }else if(file.size > 1048576){
					 alert('图片不能大于1M');
				 }
			 }
			
		}, false); 

	</script>
    </body>
</html>