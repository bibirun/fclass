<?php

//获取用户当前的动作请求
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

//加载公共文件
include_once 'includes/init.php';

//判断用户请求动作
if($act == 'center'){
	if($_SESSION['user']){
		include_once ADMIN_TEMP . '/center.html';
	}else{
		admin_redirect('home_privilege.php?act=login','请登录！',0.1);
	}
}


//接收用户动作
if($act == 'booking_class'){
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$build_name = '';
	$build_num = '';
	$class_num = '';
	$class_status = 'f';
	//获取所有场地信息
	$area = new Area();
	
	$allClassInfo = $area->getAllAreaInfoToBill($page,$class_status);
	
	$pagecounts = $area->getPageCountsToBill($class_status);

	//获取分页信息
	$page = Page::show('user_center.php?act=booking_class',$pagecounts,$page);
	include_once ADMIN_TEMP . '/booking_query.html';
	
}

if($act == 'query'){
	$_SESSION['user'] = isset($_SESSION['user']) ? $_SESSION['user'] : '';
	//接受用户提交数据
	$build_name = isset($_POST['build_name']) ? strip_tags($_POST['build_name']) : '';
	$build_num = isset ($_POST['build_num']) ? strip_tags($_POST['build_num']) : '';
	$class_num = isset ($_POST['class_num']) ? strip_tags($_POST['class_num']) : '';
	//设置查询课室的状态
	$class_status = 'f';
	//把接收数据存储到会话中
	$_SESSION['build_name'] = $build_name;
	$_SESSION['build_num'] = $build_num;
	$_SESSION['class_num'] = $class_num;
	$_SESSION['class_status'] = $class_status;
	//用户没有填写任何数据进行查询
	if(!$build_name && !$build_num && !$class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有场地信息
		$class_status = 'f';
		$area = new Area();
		//获取所有课室信息
		$allClassInfo = $area->getAllAreaInfoToBill($page,$class_status);
		//显示分页
		$pagecounts = $area->getPageCountsToBill($class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query',$pagecounts,$page);
		include_once ADMIN_TEMP . '/booking_query.html';
	}
	if($build_name && $build_num && $class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByAll($build_name,$build_num,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts0($build_name,$build_num,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query2',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	//用户填写了课室号和教学楼编号两项数据
	if(empty($build_name)&& (!empty($build_num)) && (!empty($class_num))){
		//按条件查询场地信息
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts1($build_num,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query3',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	
	//用户填写了教学楼和课室两项数据
	if(!empty($build_name)&& empty($build_num) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts2($build_name,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query4',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	
	//用户填写了教学楼和教学楼编号两项数据
	if(!empty($build_name)&& (!empty($build_num)) && empty($class_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNameAndBuildNum($build_name,$build_num,$page,$class_status);
		$pagecounts = $area->getPageCounts3($build_name,$build_num,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query5',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	
	//用户填写了教学楼一项数据
	if(!empty($build_name)&& (empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildName($build_name,$page,$class_status);
		$pagecounts = $area->getPageCounts4($build_name,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query6',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	
	//用户填写了教学楼编号一项数据
	if(empty($build_name)&& (!empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNum($build_num,$page,$class_status);
		$pagecounts = $area->getPageCounts5($build_num,$class_status);

		//获取分页信息
		$page = Page::show("user_center.php?act=query1",$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
	
	//用户填写了课室号一项数据
	if(empty($build_name)&& (empty($build_num)) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'f';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByClass($class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts6($class_num,$class_status);
		//获取分页信息
		$page = Page::show('user_center.php?act=query7',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/booking_query.html';
	}
}
/*当用户在act=query按条件查询时，点击分页链接时跳转到这里显示分页数据*/
if($act == 'query1'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNum($build_num,$page,$class_status);
	$pagecounts = $area->getPageCounts5($build_num,$class_status);

	//获取分页信息
	$page = Page::show("user_center.php?act=query1",$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query2'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByAll($build_name,$build_num,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts0($build_name,$build_num,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('user_center.php?act=query2',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query3'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	//按条件查询对应场地信息
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts1($build_num,$class_num,$class_status);

	//获取分页信息
	$page = Page::show('user_center.php?act=query3',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query4'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts2($build_name,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('user_center.php?act=query4',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query5'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNameAndBuildNum($build_name,$build_num,$page,$class_status);
	$pagecounts = $area->getPageCounts3($build_name,$build_num,$class_status);
	//获取分页信息
	$page = Page::show('user_center.php?act=query5',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query6'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildName($build_name,$page,$class_status);
	$pagecounts = $area->getPageCounts4($build_name,$class_status);
	//获取分页信息
	$page = Page::show('user_center.php?act=query6',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
if($act == 'query7'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByClass($class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts6($class_num,$class_status);
	//获取分页信息
	$page = Page::show('user_center.php?act=query7',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/booking_query.html';
}
//接收用户传入动作
//当用户动作为my-info时，说明用户需要查看我的资料
if($act == 'my-info'){
	if($_SESSION['user']){
		$stu_num = $_SESSION['user']['stu_num'];
		$student = new Student();
		$studentInfos = $student->getStudentInfoByNum($stu_num);
		//var_dump($studentInfos);
		//exit;
		include_once ADMIN_TEMP . '/my_information.html';
	}else{
		admin_redirect('home_privilege.php?act=login','请登录！',0.1);
	}
}

//接收用户传入动作
//当用户动作为booking-info时，说明用户需要查看我的预约
if($act == 'booking-info'){
	if($_SESSION['user']){
		//新建Order类对象
		$order_usernum = $_SESSION['user']['stu_num'];
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$order = new Order();
		$orderInfo = $order->getUserOrderInfo($order_usernum,$page);
		$pagecounts = $order->getPageCountsOrder($order_usernum);
		//获取分页信息
		$page = Page::show('user_center.php?act=booking-info',$pagecounts,$page);
		/****************/
		
		foreach($orderInfo as $orderInfos){
			$order_date = $orderInfos['order_date'];
			//测试数据
			//$order_date = '2015-10-24';
			$order_id = $orderInfos['order_id'];
			$order_date = isset($order_date) ? $order_date : '';
			if($order_date){
				//把预约日期从2015-10-26 17:08:00  变成20151026
				$order_date = implode('',explode('-',substr($order_date,0,10)));
				//获取当天日期，并把日期格式变成字符串“21051026”
				$today = implode('',explode('-',date('Y-m-d')));
				////判断今日日期是否已经不等于预约日期，如果不等于则自动更改课室状态和审批状态
				if($today !== $order_date){
					//$order = new Order();
					//更新预约表的审批状态
					$order->updateTimeOutToYes($order_id);
					$orderInfos = $order->getClassInfoById($order_id);
					$build_name = $orderInfos['build_name'];
					$build_num = $orderInfos['build_num'];
					$class_num = $orderInfos['class_num'];
					$class_time = $orderInfos['order_time'];
					$area =new Area();
					//更改课室的状态
					$area->updateClassStatusByInfo($build_name,$build_num,$class_num,$class_time);
				}
			}
			
		}
		
		/***************/
		include_once ADMIN_TEMP . '/booking_info.html';
	}else{
		admin_redirect('home_privilege.php?act=login','请登录！',0.1);
	}
	
}

//接收用户传入动作
//当用户动作为unsubscribe时，说明用户需要退订
if($act =='unsubscribe'){
	$order_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$order_id){
		admin_redirect('user_center.php?act=booking-info','请选择需要退订的课室！',1);
	}
	$order = new Order();
	if(!$order->updateOrderResultToReject($order_id)){
		admin_redirect('user_center.php?act=booking-info','退订失败，请重新尝试！',1);
	}
	$orderInfo = $order->getClassInfoById($order_id);
	$build_name = $orderInfo['build_name'];
	$build_num = $orderInfo['build_num'];
	$class_num = $orderInfo['class_num'];
	$class_time = $orderInfo['order_time'];
	$area =new Area();
	$area->updateClassStatusByInfo($build_name,$build_num,$class_num,$class_time);
	admin_redirect('user_center.php?act=booking-info','退订成功！',1);
}

//接收用户传入动作
//当用户动作为booking-record时，说明用户需要查看历史记录
if($act == 'booking-record'){
	
	if($_SESSION['user']){
		
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$stu_num = $_SESSION['user']['stu_num'];
		$order_usernum = $_SESSION['user']['stu_num'];
		$order = new Order();
		$orderInfo = $order->getUserOrderPassInfo($order_usernum,$page);
		$pagecounts = $order->getPageCountsOrderPass($order_usernum);
		//获取分页信息
		$page = Page::show('user_center.php?act=booking-record',$pagecounts,$page);
		include_once ADMIN_TEMP . '/booking_record.html';
	}else{
		admin_redirect('home_privilege.php?act=login','请登录！',0.1);
	}
}

//接收用户传入动作
//当用户动作为change-pass时，说明用户需要修改密码
if($act == 'change-pass'){
	if($_SESSION['user']){
		include_once ADMIN_TEMP . '/change_pass.html';
	}else{
		admin_redirect('home_privilege.php?act=login','请登录！',0.1);
	}
}
//接收用户传入动作
//当用户动作为update-pass时，说明用户提交修改密码表单
if($act == 'update-pass'){
	$stu_pass = isset($_POST['old-password']) ? strip_tags($_POST['old-password']) : '';
	$new_password = isset($_POST['new-password']) ? strip_tags($_POST['new-password']) : '';
	$confirm_password = isset($_POST['confirm-password']) ? strip_tags($_POST['confirm-password']) : '';
	if($stu_pass){
		//从会话中获取用户的账号
		$stu_num = $_SESSION['user']['stu_num'];
		$student = new Student();
		//获取对应账号的密码
		$studentInfos = $student->getStudentInfoByNum($stu_num);
		//比较密码是否相同
		if(!(SHA1($stu_pass)==$studentInfos['stu_pass'])){
			admin_redirect('user_center.php?act=change-pass','原密码输入有误，请重新输入！',1);
		}
	}else{
		admin_redirect('user_center.php?act=change-pass','原密码不能为空！',1);
	}
	if($new_password){
		if(!($new_password ==$confirm_password )){
			admin_redirect('user_center.php?act=change-pass','两次密码输入不匹配，请重新输入！',1);
		}
	}else{
		admin_redirect('user_center.php?act=change-pass','密码不能为空！',1);
	}
	
	$student = new Student();
	$stu_id = $studentInfos['stu_id'];
	//var_dump($stu_id);
	//exit;
	$new_password = SHA1($new_password);
	//判断新密码和原密码是否相同
	if($new_password == SHA1($stu_pass)){
		admin_redirect('user_center.php?act=change-pass','新密码不能与原密码相同！',1);
	}
	if($student->updateStudentPass($new_password,$stu_id)){
		admin_redirect('user_center.php?act=my-info','密码已成功修改！',1);
	}else{
		admin_redirect('user_center.php?act=change-pass','密码修改失败！',1);
	}
}
//接收用户动作，在主页通过连接查看教学楼简介
if($act == 'look_up'){
	$build_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$build_id){
		admin_redirect('home.php','请你选择你要查看的教学楼链接',1);
	}
	//新建Building对象
	$building = new Building();
	$buildingInfo = $building->getBuildingInfoById($build_id);
	include_once ADMIN_TEMP . '/introduction.html';
}