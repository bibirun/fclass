<?php

	//增加一个跳转函数
	/*
	 * 跳转函数
	 * @param1 string $url，要跳转的目标对象
	 * @param2 string $msg，提示信息
	 * @param3 int $time，跳转等待时间
	*/
	function admin_redirect($url = 'privilege.php',$msg='请登录！',$time = 2){
		//包含跳转文件
		include_once ADMIN_TEMP . '/redir.html';

		//跳转完毕不再继续执行
		exit;
	}

	/*
	 * 自动加载类
	 * @param1 string $class，需要加载的类的名字
	*/
	function __autoload($class){
		//默认从/includes去加载
		if(is_file(HOME_INC . "/$class.class.php")){
			//加载
			include_once HOME_INC . "/$class.class.php";
		}elseif(is_file(ADMIN_INC . "/$class.class.php")){
			//加载
			include_once ADMIN_INC . "/$class.class.php";
		}
	}