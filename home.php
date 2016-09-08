<?php
//前台首页
	
//获取用户动作
//$act = isset($_GET['act']) ? $_GET['act'] : 'home';
$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : 'home';

//加载公共文件
include_once 'includes/init.php';
//判断用户是否登录
//session_start();			//init.php中已经开启session

//判断动作
if($act == 'home'){
	$_SESSION['user'] = isset($_SESSION['user']) ? $_SESSION['user'] : '';
	//接收数据（home_privilege.php传过来）
	//从Building类哪里获取教学楼信息，显示在主页当中
	$building = new Building();
	//获取所有的教学楼信息
	//调用Building类的方法，获取所有数据
	if(!$buildingInfo = $building->getAllBuildingInfos()){
		admin_redirect('building.php?act=add','获取信息失败，请重试！',1);
	}
	//var_dump($buildingInfo);
	//exit;		
	//加载首页模板文件
	include_once ADMIN_TEMP . '/index.html';
		
}