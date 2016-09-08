<?php

//后台权限控制界面
//获取用户当前的动作请求
$act = isset($_POST['act']) ? $_POST['act'] : (isset($_GET['act']) ? $_GET['act'] : 'login');

//加载公共文件
include_once 'includes/init.php';

//判断用户请求动作
if($act == 'login'){
	//用户是想得到登录界面进行登录
	include_once ADMIN_TEMP . '/home_login.html';
}elseif($act == 'signin'){
	//用户已经做了登录操作，在提交用户信息进行验证
	//echo '登录验证';
	//接收用户信息
	$usernum = isset($_POST['usernum']) ? $_POST['usernum'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';


	//验证用户信息
	if(empty($usernum)||empty($password)){
		//用户信息不完整，返回到登录界面
		admin_redirect('home_privilege.php','账号和密码不能为空！',2);
	}


	//验证用户的有效性（登录）
	$student = new Student();
		
	$teacher = new Teacher();
		//var_dump($admin);
		
		//验证用户信息
	if($student = $student->checkStudentByNumAndPassword($usernum,$password)){
			
		//session_start();
		$_SESSION['user'] = $student;
		//登录成功，进入到系统首页
		admin_redirect('home.php','登录成功',0.1);
	}elseif($teacher = $teacher->checkTeacherByNumAndPass($usernum,$password)){
		$_SESSION['user'] = $teacher;
		admin_redirect('home.php?act=login','登录成功！',0.1);
			
	}else{
		//验证失败，用户名或者密码错误
		admin_redirect('home_privilege.php','账号或者密码错误',2);
	}
}elseif($act =='logout'){
	//用户退出系统
	//可以通过清空session和销毁session文件两种方式实现

	//销毁session
	//session_start();
	session_destroy();

	//清除cookie
	if(isset($_COOKIE['user_id'])){
		//删除cookie
		setcookie('user_id','',1);
	}

	//跳转到登录界面
	admin_redirect('home_privilege.php?act=login','退出成功',0.1);
}
//接收用于动作
//判断用户请求动作，如果用户动作为forgetpassword，则说明用户忘记密码，需要找回密码
if($act == 'forgetpassword'){
	include_once ADMIN_TEMP . '/home_chang_pass.html';
	
}
//接收用于动作
//判断用户请求动作，如果用户动作为get_new_pass，则说明用户发送账号，等待一个新的密码发送到用户邮箱
if($act == 'get_new_pass'){
	$usernum = isset($_POST['usernum']) ? $_POST['usernum'] : '';
	if(!$usernum){
		admin_redirect('home_privilege.php?act=forgetpassword','账号不能为空！',1);
	}
	$student = new Student();
	$teacher = new Teacher();
	//Student.class.php
	$studentInfo = $student->getStudentEmailByNum($usernum);
	$pass = $student->getRandChar();
	$stu_pass = SHA1($pass);
	//var_dump($usernum);
	//var_dump($stu_pass);
	//exit;
	if(!($student->updateStudentPassByNum($usernum,$stu_pass))){
		admin_redirect('home_privilege.php?act=forgetpassword','你的密码为原始密码！',1);
	}
	$subject = "HBL空闲课室预约系统";
	$bodyInfo = "你好，你的密码已经暂时修改为$pass" . "请尽快登录系统修改你的密码。";
	$email = $studentInfo['stu_email'];
	$redirect = "home_privilege.php?act=login";
	include_once ADMIN_ROOT . '/email.php';
	
}