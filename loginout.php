<?php
//�˳���¼
function logout(){
	$_SESSION = array(); //���SESSIONֵ.  
	if(isset($_COOKIE[session_name()])){  //�жϿͻ��˵�cookie�ļ��Ƿ����,���ڵĻ���������Ϊ����.  
		setcookie(session_name(),'',time()-1,'/');  
	}  
	session_destroy();  //�����������sesion�ļ�
}  
logout();
echo "<script>window.location.href='index.php';</script>";
?>