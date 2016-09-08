<?php
//处理操作
//获取用户请求的动作和所携带的参数

$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : '';
//包含配置文件
include_once 'includes/init.php';

//判断用户的动作,add为增加用户
if($act == 'add'){
	
	//包含文件
	include_once ADMIN_TEMP . '/add-building.html';
}	
if($act == 'insert'){
	//获取表单提交的数据
	$build_name = isset($_POST['build_name']) ? $_POST['build_name'] : '';
	$build_text = isset($_POST['build_text']) ? $_POST['build_text'] : '';
	//图片资源从服务器传递
	$build_pic = '';
	
	//验证数据合法性
	if(empty($build_name)){
		admin_redirect('building.php?act=add','教学楼名称不能为空，请重新输入！',1);
	}
	if(!$build_text){
		admin_redirect('building.php?act=add','教学有简介不能为空！',1);
	}
	//验证教学楼名字是否存在
	$building = new Building();
	if($building->checkBuildingName($build_name)){
		admin_redirect('building.php?act=add','教学楼名称已存在，请选择一个新名字重新添加！',1);
	}
	$max = 1024000;
	if($path = Upload::uploadSingle($_FILES['build_pic'],$config['img_upload'],$max)){
		//上传成功，将上传文件的相对路径存放到数据对应的字段下
		$build_pic = $path;
	}else{
		//上传失败，获取错误信息
		$error = Upload::$errorInfo;
	}
	//插入数据
	
	if($building->insertBuilding($build_name,$build_pic,$build_text)){
		//插入成功
		if(isset($error)){
			//文件上传失败
			admin_redirect('index.php','添加成功！由于' . $error.',文件上传失败',2 );
		}else{
			admin_redirect('index.php','添加成功！',2);
		}
	}else{
		//插入失败
		admin_redirect('building.php?act=add','添加失败，请重新尝试！',3);
	}
	
}

//编辑教学楼
//接受用户动作
if($act == 'edit'){
	//获取ID值，以编辑对应的教学楼信息
	$build_id = isset($_GET['id']) ? $_GET['id'] : '';
	if(!$build_id){
		admin_redirect('index.php','请选择需要编辑的教学楼！',2);
	}
	//获取教学楼名称和图片路径
	$building = new Building();
	if(!$buildingInfos = $building->getBuildingInfoById($build_id)){
		admin_redirect('index.php','获取教学楼信息失败，请重新编辑！',2);
	}
	include_once ADMIN_TEMP . '/edit-building.html';
}

//更新教学楼信息
//接受用户请求动作
if($act == 'update'){
	//获取表单提交的数据
	$build_name = isset($_POST['build_name']) ? $_POST['build_name'] : '';
	$build_text = isset($_POST['build_text']) ? $_POST['build_text'] : '';
	//图片资源从服务器传递
	$build_pic = '';
	
	//验证数据合法性
	if(empty($build_name)){
		admin_redirect('building.php?act=add','教学楼名称不能为空，请重新输入！',2);
	}
	if(!$build_text){
		admin_redirect('building.php?act=add','教学有简介不能为空！',1);
	}
	//验证教学楼名字是否存在
	$building = new Building();
	/*if($building->checkBuildingName($build_name)){
		admin_redirect('building.php?act=add','教学楼名称已存在，请选择一个新名字重新添加！',2);
	}
	*/
	$max = 1024000;
	if($path = Upload::uploadSingle($_FILES['build_pic'],$config['img_upload'],$max)){
		//上传成功，将上传文件的相对路径存放到数据对应的字段下
		$build_pic = $path;
	}else{
		//上传失败，获取错误信息
		$error = Upload::$errorInfo;
	}
	//更新数据
	$build_id = $_POST['build_id'];
	if($building->updateBuilding($build_name,$build_pic,$build_text,$build_id)){
		//插入成功
		if(isset($error)){
			//文件上传失败
			admin_redirect('index.php','修改成功！但图片上传失败',2 );
		}else{
			admin_redirect('index.php','修改成功！',2);
		}
	}else{
		//插入失败
		admin_redirect('building.php?act=edit','修改失败，请重新尝试！',3);
	}
}

//编辑教学楼信息后提交数据
if($act == 'delete'){
	$build_id = isset($_GET['id']) ? $_GET['id'] : '';
	//没有选中需要删除的教学楼
	if(!$build_id){
		admin_redirect('index.php','请选择需要删除的教学楼！',2);
	}
	$building = new Building();
	//通过ID删除数据库对应的教学楼信息
	if($building->deleteBuildingById($build_id)){
		admin_redirect('index.php','已成功删除！',2);
	}else{
		admin_redirect('index.php','删除失败，请重试！',2);
	}
	
}