<?php
//处理预约场地操作
//获取用户请求的动作和所携带的参数
$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : '';
//包含配置文件
include_once 'includes/init.php';
//接收用户动作，add-bill-query-用户在增加可预约课室使用查询
if($act == 'add-bill-query'){
	//接受用户提交数据
	$build_name = isset($_POST['build_name']) ? strip_tags($_POST['build_name']) : '';
	$build_num = isset ($_POST['build_num']) ? strip_tags($_POST['build_num']) : '';
	$class_num = isset ($_POST['class_num']) ? strip_tags($_POST['class_num']) : '';
	//设置查询课室的状态
	$class_status = 'o';
	//把接收数据存储到会话中
	$_SESSION['build_name'] = $build_name;
	$_SESSION['build_num'] = $build_num;
	$_SESSION['class_num'] = $class_num;
	$_SESSION['class_status'] = $class_status;
	//用户没有填写任何数据进行查询
	if(!$build_name && !$build_num && !$class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有场地信息
		$class_status = 'o';
		$area = new Area();
		//获取所有课室信息
		$allClassInfo = $area->getAllAreaInfoToBill($page,$class_status);
		//显示分页
		$pagecounts = $area->getPageCountsToBill($class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query0',$pagecounts,$page);
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	if($build_name && $build_num && $class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByAll($build_name,$build_num,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts0($build_name,$build_num,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	//用户填写了课室号和教学楼编号两项数据
	if(empty($build_name)&& (!empty($build_num)) && (!empty($class_num))){
		//按条件查询场地信息
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts1($build_num,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query2',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	
	//用户填写了教学楼和课室两项数据
	if(!empty($build_name)&& empty($build_num) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts2($build_name,$class_num,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query3',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	
	//用户填写了教学楼和教学楼编号两项数据
	if(!empty($build_name)&& (!empty($build_num)) && empty($class_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNameAndBuildNum($build_name,$build_num,$page,$class_status);
		$pagecounts = $area->getPageCounts3($build_name,$build_num,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query4',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	
	//用户填写了教学楼一项数据
	if(!empty($build_name)&& (empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildName($build_name,$page,$class_status);
		$pagecounts = $area->getPageCounts4($build_name,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query5',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	
	//用户填写了教学楼编号一项数据
	if(empty($build_name)&& (!empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByBuildNum($build_num,$page,$class_status);
		$pagecounts = $area->getPageCounts5($build_num,$class_status);

		//获取分页信息
		$page = Page::show("booking.php?act=add-bill-query6",$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}
	
	//用户填写了课室号一项数据
	if(empty($build_name)&& (empty($build_num)) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应场地信息
		$class_status = 'o';
		$area = new Area();
		//使用getUserByall方法查询场地信息
		$allClassInfo = $area->getAreaByClass($class_num,$page,$class_status);
		$pagecounts = $area->getPageCounts6($class_num,$class_status);
		//获取分页信息
		$page = Page::show('booking.php?act=add-bill-query7',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/add-booking-class.html';
	}

}
if($act == 'add-bill-query0'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有场地信息
	$area = new Area();
	//获取所有课室信息
	$allClassInfo = $area->getAllAreaInfoToBill($page,$class_status);
	//显示分页
	$pagecounts = $area->getPageCountsToBill($class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query0',$pagecounts,$page);
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query1'){
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
	$page = Page::show('booking.php?act=remove-bill-query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query2'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts1($build_num,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query2',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query3'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	//按条件查询对应场地信息
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts2($build_name,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query3',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query4'){
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
	$page = Page::show('booking.php?act=remove-bill-query4',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query5'){
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
	$page = Page::show('booking.php?act=remove-bill-query5',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query6'){
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
	$page = Page::show("booking.php?act=remove-bill-query6",$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'add-bill-query7'){
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
	$page = Page::show('booking.php?act=remove-bill-query7',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query'){
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
		$page = Page::show('booking.php?act=remove-bill-query0',$pagecounts,$page);
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query2',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query3',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query4',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query5',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show("booking.php?act=remove-bill-query6",$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
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
		$page = Page::show('booking.php?act=remove-bill-query7',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/delete-booking-class.html';
	}
}
/*当用户在act=query按条件查询时，点击分页链接时跳转到这里显示分页数据*/
if($act == 'remove-bill-query0'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有场地信息
	$area = new Area();
	//获取所有课室信息
	$allClassInfo = $area->getAllAreaInfoToBill($page,$class_status);
	//显示分页
	$pagecounts = $area->getPageCountsToBill($class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query0',$pagecounts,$page);
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query1'){
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
	$page = Page::show('booking.php?act=remove-bill-query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query2'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts1($build_num,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query2',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query3'){
	//接收保存在会话中的条件
	$build_name = $_SESSION['build_name'];
	$class_num = $_SESSION['class_num'];
	$build_num = $_SESSION['build_num'];
	$class_status = $_SESSION['class_status'];
	//按条件查询对应场地信息
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询场地信息
	$area = new Area();
	//使用getUserByall方法查询场地信息
	$allClassInfo = $area->getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status);
	$pagecounts = $area->getPageCounts2($build_name,$class_num,$class_status);
	//获取分页信息
	$page = Page::show('booking.php?act=remove-bill-query3',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query4'){
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
	$page = Page::show('booking.php?act=remove-bill-query4',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query5'){
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
	$page = Page::show('booking.php?act=remove-bill-query5',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query6'){
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
	$page = Page::show("booking.php?act=remove-bill-query6",$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
if($act == 'remove-bill-query7'){
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
	$page = Page::show('booking.php?act=remove-bill-query7',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}
//接受用户动作
//add-class-to,把课室状态切换到空闲状态
if($act == 'add-class-to'){
	$class_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$class_id){
		admin_redirect('area.php?act=add-bill','请选择需要添加的课室！',1);
	}
	$area = new Area();
	//更新课室状态---class_status=f
	if($area->updateClassStatusToFree($class_id)){
		admin_redirect('booking.php?act=add-bill','课室状态已切换到空闲！',1);
	}else{
		admin_redirect('booking.php?act=add-bill','课室状态切换失败！',1);
	}
}
//接受用户传递动作
//add-bill动作为列举所有忙时状态的课室
if($act =='add-bill'){
	
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$area = new Area();
	
	$allClassInfo = $area->getAllAddBillInfo($page);
	
	$pagecounts = $area->getAddBillPageCounts();

	//获取分页信息
	$page = Page::show('booking.php?act=add-bill',$pagecounts,$page);
	
	include_once ADMIN_TEMP .'/add-booking-class.html';
}
//接受用户传递动作
//delete-bill为列举所有闲时状态的课室
if($act == 'delete-bill'){
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有信息
	$area = new Area();
	
	$allClassInfo = $area->getAllDeleteBillInfo($page);
	
	$pagecounts = $area->getDeleteBillPageCounts();

	//获取分页信息
	$page = Page::show('booking.php?act=delete-bill',$pagecounts,$page);
	
	include_once ADMIN_TEMP .'/delete-booking-class.html';
}

//接受用户动作
//remove-class-to,把课室状态切换到空闲状态
if($act == 'remove-class-to'){
	$class_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$class_id){
		admin_redirect('booking.php?act=add-bill','请选择需要添加的课室！',1);
	}
	$area = new Area();
	//更新课室状态---class_status=o
	if($area->updateClassStatusToOccupy($class_id)){
		admin_redirect('booking.php?act=delete-bill','课室状态已切换到空闲！',1);
	}else{
		admin_redirect('booking.php?act=delete-bill','课室状态切换失败！',1);
	}
}
if($act == 'bill-history'){
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//新建Order对象
	$order = new Order();
	$orderInfo = $order->getHistoryInfo($page);
	$pagecounts = $order->getHistoryPageCounts();
	//获取分页信息
	$page = Page::show('booking.php?act=bill-history',$pagecounts,$page);
	include_once ADMIN_TEMP . '/bill-history.html';
}
if($act == 'history-query'){
	//接收用户提交数据，并去除多余空格
	$build_name = isset($_POST['build_name'])? trim($_POST['build_name']) : '';
	$build_num = isset($_POST['build_num']) ? trim($_POST['build_num']) : '';
	$class_num = isset($_POST['class_num']) ? trim($_POST['class_num']) : '';
	$order_date = isset($_POST['order_date']) ? trim($_POST['order_date']) : '';
	//验证数据合法性
	if(!$build_name){
		admin_redirect('booking.php?act=bill-history','教学楼名字不能为空！',1);
	}
	if(!$build_num){
		admin_redirect('booking.php?act=bill-history','教学楼编号不能为空！',1);
	}
	if(!$class_num){
		admin_redirect('booking.php?act=bill-history','课室编号不能为空！',1);
	}
	if(!$order_date){
		admin_redirect('booking.php?act=bill-history','日期不能为空！',1);
	}
	//把数据存储到会话中
	$_SESSION['build_name'] = $build_name;
	$_SESSION['build_num'] = $build_num;
	$_SESSION['class_num'] = $class_num;
	$_SESSION['order_date'] = $order_date;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//新建Order对象
	$order = new Order();
	$orderInfo = $order->getHistoryRecordByQuery($build_name,$build_num,$class_num,$order_date,$page);
	$pagecounts = $order->getHistoryRecordByQueryPageCounts($build_name,$build_num,$class_num,$order_date);
	//获取分页信息
	$page = Page::show('booking.php?act=history-query1',$pagecounts,$page);
	include_once ADMIN_TEMP . '/bill-history.html';
	
}
if($act == 'history-query1'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$order_date = $_SESSION['order_date'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//新建Order对象
	$order = new Order();
	$orderInfo = $order->getHistoryRecordByQuery($build_name,$build_num,$class_num,$order_date,$page);
	$pagecounts = $order->getHistoryRecordByQueryPageCounts($build_name,$build_num,$class_num,$order_date);
	//获取分页信息
	$page = Page::show('booking.php?act=history-query1',$pagecounts,$page);
	include_once ADMIN_TEMP . '/bill-history.html';
}