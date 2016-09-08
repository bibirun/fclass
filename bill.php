<?php

//获取用户当前的动作请求
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

//加载公共文件
include_once 'includes/init.php';

//判断用户请求动作
if($act == 'confirm'){
	if(!$_SESSION['user']){
		admin_redirect('home_privilege.php?act=login','请先登录！',1);
	}
	//获取用户名和账号
	$order_username = $_SESSION['user']['stu_name'];
	$order_usernum = $_SESSION['user']['stu_num'];
	//新建对象
	$order = new Order();
	//检查用户是否在这天内已经预定课室了，如果已经预定成果一次，则该用户账号不能再预约课室
	if($order->checkUserOrTwoTime($order_username,$order_usernum)){
		admin_redirect('user_center.php?act=booking_class','很抱歉！一个账号一天内只能预约一间课室。',2);
	}
	$class_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$class_id){
		admin_redirect('user_center.php?act=booking_class','请点击你想预约的课室！',1);
	}
	$area = new Area();
	
	$allClassInfo = $area->getAllAreaInfoById($class_id);
	//包含文件	
	//var_dump($allClassInfo);
	//exit;
	include_once ADMIN_TEMP . '/confirm-info.html';
}
//接收用户动作
//如果用户动作为confirm-bill,说明用户确认了预约的信息，点击提交。
if($act =='confirm-bill'){
	//接收从确认信息页面传入的数据
	$build_name = $_POST['build_name'];
	$build_num = $_POST['build_num'];
	$class_num = $_POST['class_num'];
	$class_type = $_POST['class_type'];
	$class_time = $_POST['class_time'];
	$order_date = $_POST['order_date'];
	$username = $_POST['username'];
	//从会话中获取用户账号
	$usernum = $_SESSION['user']['stu_num'];
	if($class_time=='07:00-07:45'){
		$class_time = '1';
		}elseif($class_time=='08:00-08:45'){
			$class_time = '2';
		}elseif($class_time=='08:55-09:40'){
			$class_time = '3';
		}elseif($class_time=='10:00-10:45'){
			$class_time = '4';
		}elseif($class_time=='10:55-11:40'){
			$class_time = '5';
		}elseif($class_time=='14:40-15:25'){
			$class_time = '6';
		}elseif($class_time=='15:35-16:20'){
			$class_time = '7';
		}elseif($class_time=='16:30-18:00'){
			$class_time = '8';
		}elseif($class_time=='20:00-21:30'){
			$class_time = '9';
		}else{
		$class_time ='';
	}
	if($class_type == '标准'){
		$class_type = 's';
	}else{
		$class_type = 'c';
	}
	//测试
	//var_dump($_POST);
	//exit;
	//新建Order类对象order
	$order = new Order();
	//插入数据，并使用返回值判断是否插入成功（返回受影响行数或FALSE）
	if($order->insertUserInfoToOrder($build_name,$build_num,$class_num,$class_type,$class_time,$order_date,$username,$usernum)){
		$area = new Area();
		//更新数据，并判断是否更新成功（返回受影响行数或FALSE）
		if($area->updateClassStatusByAll($build_name,$build_num,$class_num,$class_time)){
			admin_redirect('user_center.php?act=booking_class','你的预约已经成功提交，请留意邮箱通知！',1);
		}else{
			admin_redirect('bill.php?act=confirm-bill','你的预约申请提交失败，请重新提交！',1);
		}
		
	}else{
		admin_redirect('bill.php?act=confirm-bill','你的预约申请提交失败，请重新提交！',1);
	}
}