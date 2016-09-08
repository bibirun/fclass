<?php

	//后台公共文件（初始化系统）

	//字符集设置
	header('Content-type:text/html;charset=utf-8');

	//定义目录常量
	//系统根目录
	define('HOME_ROOT',str_replace('\\','/',substr(__DIR__,0,strpos(__DIR__,'\admin\includes'))));
	//前台公共目录
	define('HOME_INC',		HOME_ROOT . '/includes');
	define('HOME_CONF',		HOME_ROOT . '/conf');

	//后台根目录
	define('ADMIN_ROOT',	HOME_ROOT . '/admin');
	define('ADMIN_INC',		ADMIN_ROOT . '/includes');
	define('ADMIN_TEMP',	ADMIN_ROOT. '/templates');
	define('ADMIN_UPL',		ADMIN_ROOT. '/uploads');

	//定义url常量
	define('__ADMIN__',		'http://loacalhost/admin');

	//定义系统错误控制
	ini_set('error_reporting',		E_ALL);
	ini_set('display_errors',      1);

	//加载公共函数
	include_once ADMIN_INC . '/functions.php';

	//加载配置文件
	$config  = include_once HOME_CONF . '/config.php';

	//开启session
	@session_start();

	//验证用户身份
	//获取当前请求的脚本
	$script_name = basename($_SERVER['SCRIPT_NAME']);
	
	//判断
	if($script_name == 'privilege.php' && ($act == 'login' || $act == 'signin' || $act == 'forgetpassword' || $act == 'get_new_pass' )){
		//不需要验证的
	}else{
		//需要验证
		if(!isset($_SESSION['admin'])){
			
				//没有session信息,跳转页面
				admin_redirect('privilege.php','请先登录',1);
			}
		
	}