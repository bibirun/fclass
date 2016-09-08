<?php

//获取用户当前的动作请求
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

//加载公共文件
include_once 'includes/init.php';

/*
*动作将会处理两个问题
*加载所有order_status = on && order_result = reject && time_out = no 的所有预约信息
*判断今日日期是否已经不等于预约日期，如果不等于则自动更改课室状态和审批状态
*/
//判断用户动作,如果动作为deal,代表用户从首页进入审批页，将会获取所有未预约信息
if($act == 'deal'){
	//获取页码
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//新建order对象
	$order = new Order();
	$orderInfo = $order->getAllInfoFromOrder($page);
	$pagecounts = $order->getPageCountsToDeal();
	//获取分页信息
	$page = Page::show('order.php?act=deal',$pagecounts,$page);
	
	/*******************************/
		foreach($orderInfo as $orderInfos){
			$order_date = $orderInfos['order_date'];
			//测试数据
			//$order_date = '2015-10-24';
			$order_id = $orderInfos['order_id'];
			
			$order_date = isset($order_date) ? $order_date : '';
			if($order_date){
				//把预约日期从2015-10-26 17:08:00  变成20151026
				$order_date = implode('',explode('-',substr($order_date,0,10)));
				$today = implode('',explode('-',date('Y-m-d')));
				//var_dump($today);
				//exit;
				//判断今日日期是否已经不等于预约日期，如果不等于则自动更改课室状态和审批状态
				if($today !== $order_date){
					//$order = new Order();
					//更新预约表的审批状态
					$order->updateTimeOutToYes($order_id);
					$order->updateOrderStatusOff($order_id);
				}
			}
		}
	/***************************/
	include_once ADMIN_TEMP . '/bill-management.html';
}
//判断用户动作
if($act == 'pass'){
	//新建order对象
	$order_id = isset($_GET['id']) ? $_GET['id'] : '';
	//var_dump($order_id);
	//exit;
	if(!$order_id){
		admin_redirect('deal.php?act=deal','没有选择审批的内容，请选择预约申请！',1);
	}
	$order = new Order();
	//通过order_id获取对应预约表的用户名
	$orderInfo = $order->getUserNumByOrderId($order_id);
	//获取对应Order_id的用户账号和姓名
	$usernum = $orderInfo['order_usernum'];
	$username = $orderInfo['order_username'];
	$student = new Student();
	$userInfo = $student->getEmailByUserNum($usernum);
	//定义邮件变量
	$email = $userInfo['stu_email'];
	$subject = "HBL空闲课室预约系统";
	$redirect = "deal_order.php?act=deal";
	$bodyInfo = "$username,你的预约已经通过审批了，若不是您本人操作，请及时退订，并修改你的密码！";
	$order->updateOrderStatusResult($order_id);
	include_once  'email.php';
}
//判断用户动作
//如果用户动作为reject,代表用户拒绝预约申请
if($act == 'reject'){
	
	$order_id = isset($_GET['id']) ? $_GET['id'] : '';
	//var_dump($order_id);
	//exit;
	if(!$order_id){
		admin_redirect('deal.php?act=deal','没有选择审批的内容，请选择预约申请！',1);
	}
	$order = new Order();
	//通过order_id获取对应预约表的用户名
	$orderInfo = $order->getUserNumByOrderId($order_id);
	
	//获取课室信息，以获得对应课室ID
	$build_name = $orderInfo['build_name'];
	$build_num = $orderInfo['build_num'];
	$class_num = $orderInfo['class_num'];
	$class_time = $orderInfo['order_time'];
	//把课室状态设置到空闲状态
	$area = new Area();
	if(!$area->updateClassStatusByInfo($build_name,$build_num,$class_num,$class_time)){
		admin_redirect('deal_order.php?act=deal','更新失败！',1);
	}
	//获取对应Order_id的用户账号和姓名
	$username = $orderInfo['order_username'];
	$usernum = $orderInfo['order_usernum'];
	$student = new Student();
	$userInfo = $student->getEmailByUserNum($usernum);
	//定义邮件变量
	$stu_email = $userInfo['stu_email'];
	$email = $userInfo['stu_email'];
	$subject = "HBL空闲课室预约系统";
	$redirect = "deal_order.php?act=deal";
	$bodyInfo = "$username,很抱歉！你的申请被拒绝了，请尝试预约其他课室！";
	$order->updateOrderStatusOff($order_id);
	include_once  'email.php';
}
/*
*用户在预约审批页面使用查询
*@param build_name || build_num || class_num
*三个条件，有八种情况（一个条件，两个条件，三个条件）
*/
if($act == 'query'){
	//接受用户提交数据
	$build_name = isset($_POST['build_name']) ? strip_tags($_POST['build_name']) : '';
	$build_num = isset ($_POST['build_num']) ? strip_tags($_POST['build_num']) : '';
	$class_num = isset ($_POST['class_num']) ? strip_tags($_POST['class_num']) : '';
	//把接收数据存储到会话中
	$_SESSION['build_name'] = $build_name;
	$_SESSION['build_num'] = $build_num;
	$_SESSION['class_num'] = $class_num;
	//用户没有填写任何数据进行查询
	//直接显示所有数据
	if(!$build_name && !$build_num && !$class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有学生信息
		$order = new Order();
		$orderInfo = $order->getAllInfoFromOrder($page);
		$pagecounts = $order->getPageCountsToDeal();
		//获取分页信息
		$page = Page::show('order.php?act=deal',$pagecounts,$page);
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	if($build_name && $build_num && $class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByAll($build_name,$build_num,$class_num,$page);
		$pagecounts = $order->getPageCounts0($build_name,$build_num,$class_num);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	//用户填写了课室号和教学楼编号两项数据
	if(empty($build_name)&& (!empty($build_num)) && (!empty($class_num))){
		//按条件查询场地信息
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByBuildNumAndClass($build_num,$class_num,$page);
		$pagecounts = $order->getPageCounts1($build_num,$class_num);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query2',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	
	//用户填写了教学楼和课室两项数据
	if(!empty($build_name)&& empty($build_num) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByBuildNameAndClass($build_name,$class_num,$page);
		$pagecounts = $order->getPageCounts2($build_name,$class_num);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query3',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	
	//用户填写了教学楼和教学楼编号两项数据
	if(!empty($build_name)&& (!empty($build_num)) && empty($class_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByBuildNameAndBuildNum($build_name,$build_num,$page);
		$pagecounts = $order->getPageCounts3($build_name,$build_num);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query4',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	
	//用户填写了教学楼一项数据
	if(!empty($build_name)&& (empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByBuildName($build_name,$page);
		$pagecounts = $order->getPageCounts4($build_name);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query5',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	
	//用户填写了教学楼编号一项数据
	if(empty($build_name)&& (!empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByBuildNum($build_num,$page);
		$pagecounts = $order->getPageCounts5($build_num);

		//获取分页信息
		$page = Page::show("deal_order.php?act=query6",$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}
	
	//用户填写了课室号一项数据
	if(empty($build_name)&& (empty($build_num)) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$order = new Order();
		//使用getUserByall方法查询场地信息
		$orderInfo = $order->getAreaByClass($class_num,$page);
		$pagecounts = $order->getPageCounts6($class_num);
		//获取分页信息
		$page = Page::show('deal_order.php?act=query7',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/bill-management.html';
	}

}
if($act == 'query1'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByAll($build_name,$build_num,$class_num,$page);
	$pagecounts = $order->getPageCounts0($build_name,$build_num,$class_num);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query2'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByBuildNumAndClass($build_num,$class_num,$page);
	$pagecounts = $order->getPageCounts1($build_num,$class_num);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query2',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query3'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	//按条件查询对应场地信息
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByBuildNameAndClass($build_name,$class_num,$page);
	$pagecounts = $order->getPageCounts2($build_name,$class_num);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query3',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query4'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByBuildNameAndBuildNum($build_name,$build_num,$page);
	$pagecounts = $order->getPageCounts3($build_name,$build_num);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query4',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query5'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByBuildName($build_name,$page);
	$pagecounts = $order->getPageCounts4($build_name);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query5',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query6'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByBuildNum($build_num,$page);
	$pagecounts = $order->getPageCounts5($build_num);
	//获取分页信息
	$page = Page::show("deal_order.php?act=query6",$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}
if($act == 'query7'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应场地信息
	$order = new Order();
	//使用getUserByall方法查询场地信息
	$orderInfo = $order->getAreaByClass($class_num,$page);
	$pagecounts = $order->getPageCounts6($class_num);
	//获取分页信息
	$page = Page::show('deal_order.php?act=query7',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/bill-management.html';
}