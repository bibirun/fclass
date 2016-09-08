<?php
//处理场地操作
//获取用户请求的动作和所携带的参数
$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : '';
//包含配置文件
include_once 'includes/init.php';
//判断用户的动作,add为增加用户
if($act == 'add'){
	
	//包含文件
	include_once ADMIN_TEMP . '/add-class.html';
}	
if($act == 'insert'){
	//插入数据
	//验证数据合法性
	$build_name = isset($_POST['build_name']) ? $_POST['build_name'] : '';
	$build_num = isset($_POST['build_num']) ? $_POST['build_num'] : '';
	$class_num = isset($_POST['class_num']) ? $_POST['class_num'] : '';
	$class_contain_num = isset($_POST['class_contain_num']) ? $_POST['class_contain_num'] : '';
	$class_type = isset($_POST['class_type']) ? $_POST['class_type'] : '';
	$class_time = isset($_POST['class_time']) ? $_POST['class_time'] : '';
	if(!empty($class_num)){
		if(!is_numeric($class_num)){
			admin_redirect('area.php?act=add','请使用不超过65535的整数填写！',1);
		}
	}

	if(empty($build_name)){
		admin_redirect('area.php?act=add','教学楼名字不能为空，请重新填写！',1);
	}
	if(empty($build_num)){
		admin_redirect('area.php?act=add','请使用大写字母填写教学楼编号！',1);
	}
	if(empty($class_contain_num)){
		admin_redirect('area.php?act=add','课室容纳人数不能为空！',1);
	}
	
	if(empty($class_type)){
			admin_redirect('area.php?act=add','课室类型不能为空！',1);

	}
	if(empty($class_time)){
			admin_redirect('area.php?act=add','课室时间不能为空！',1);

	}
	
	$area = new Area();
	//调用方法增加学生用户
	if($area->checkArea($build_name,$build_num,$class_num,$class_time)){
		if($area->addArea($build_name,$build_num,$class_num,$class_contain_num,$class_type,$class_time)){
			admin_redirect('area.php?act=add','数据已成功插入！',0.1);
		}else{
			admin_redirect('area.php?act=add','数据插入失败！',1);
		}
	
	}else{
		admin_redirect('area.php?act=add','对应编号的教学楼的课室时间已经存在！',1);
	}
}

//判断用户动作,如果为edit，则进入所有用户界面
if($act == 'edit'){
	//获取页码
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$area = new Area();
	
	$areaInfo = $area->getAllAreaInfo($page);
	
	$pagecounts = $area->getPageCounts();

	//获取分页信息
	$page = Page::show('area.php?act=edit',$pagecounts,$page);
	include_once ADMIN_TEMP .'/all-class.html';
}
//判断用户动作，delete为删除，但和edit一样进入所有用户界面
if($act == 'delete'){
	
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$area = new Area();
	
	$areaInfo = $area->getAllAreaInfo($page);
	
	$pagecounts = $area->getPageCounts();

	//获取分页信息
	$page = Page::show('area.php?act=edit',$pagecounts,$page);
	
	include_once ADMIN_TEMP .'/all-class.html';
}

//当用户动作为edit-user时，通过所携带的ID把对应用户数据填写到表单
if($act == 'edit-class'){
	//编辑学生信息
	//获取用户的id
	$class_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($class_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('area.php?act=edit','没有选中需要编辑的项！',2);
	}
	
	$area = new Area();
	//获取id值所对应的用户信息
	$areaInfos = $area->getAllAreaInfoById($class_id);
	//包含编辑学生HTML文件
	include_once ADMIN_TEMP .'/edit-class.html';
	
}

//判断用户动作是否为edit-insert（代表编辑后插入数据到数据库）
if($act =='update'){
	//插入数据
	//验证数据合法性
	$build_name = isset($_POST['build_name']) ? $_POST['build_name'] : '';
	$build_num = isset($_POST['build_num']) ? $_POST['build_num'] : '';
	$class_num = isset($_POST['class_num']) ? $_POST['class_num'] : '';
	$class_contain_num = isset($_POST['class_contain_num']) ? $_POST['class_contain_num'] : '';
	$class_type = isset($_POST['class_type']) ? $_POST['class_type'] : '';
	$class_time = isset($_POST['class_time']) ? $_POST['class_time'] : '';
	if(empty($class_num)){
		
		admin_redirect('area.php?act=edit','课室号不能为空！',2);
	}

	if(empty($build_name)){
		admin_redirect('area.php?act=edit','教学楼名字不能为空，请重新填写！',2);
	}
	if(empty($build_num)){
		admin_redirect('area.php?act=edit','请使用大写字母填写教学楼编号！',2);
	}
	if(empty($class_contain_num)){
		admin_redirect('area.php?act=edit','课室容纳人数不能为空！',2);
	}
	
	if(empty($class_type)){
			admin_redirect('area.php?act=edit','课室类型不能为空！',2);
	}
	if(empty($class_time)){
			admin_redirect('area.php?act=edit','课室时间不能为空！',2);
	}
	$area = new Area();
	//调用方法增加学生用户
	$class_id = $_POST['class_id'];
	if($area->updateArea($build_name,$build_num,$class_num,$class_contain_num,$class_type,$class_time,$class_id)){
		admin_redirect('area.php?act=edit','数据已成功更新！',0.1);
	}else{
		admin_redirect('area.php?act=edit','数据更新失败！',2);
	}
	
	
}
if($act == 'delete-class'){
	
	//获取用户的id
	$class_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($class_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('area.php?act=edit','没有正确选择需要删除的项！',2);
	}
	
	$area = new Area();
	//删除指定ID用户的信息
	if($area->deleteAreaById($class_id)){
		//删除成功
		admin_redirect('area.php?act=edit',' 数据已成功删除！',0.1);
	}else{
		//删除失败
		admin_redirect('area.php?act=delete','删除课室失败，请重新尝试删除',2);
	}
}

if($act == 'query'){
	//接受用户提交数据
	$build_name = isset($_POST['build_name']) ? strip_tags($_POST['build_name']) : '';
	$build_num = isset ($_POST['build_num']) ? strip_tags($_POST['build_num']) : '';
	$class_num = isset ($_POST['class_num']) ? strip_tags($_POST['class_num']) : '';
	$_SESSION['build_name'] = $build_name;
	$_SESSION['build_num'] = $build_num;
	$_SESSION['class_num'] = $class_num;
	//判断表单数据的合法性
	//用户没有填写任何数据进行查询

	if(!$build_name && !$build_num && !$class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有场地信息
		$area = new Area();
		//获取所有课室信息
		$areaInfo = $area->getAllAreaInfo($page);
		//显示分页
		$pagecounts = $area->getPageCounts();
		//获取分页信息
		$page = Page::show('area.php?act=query',$pagecounts,$page);
		include_once ADMIN_TEMP .'/all-class.html';
	}

	if($build_name && $build_num && $class_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByAll($build_name,$build_num,$class_num,$page);
		$pagecounts = $area->queryGetPageCounts0($build_name,$build_num,$class_num);
		//获取分页信息
		$page = Page::show('area.php?act=query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了班级和账号两项数据
	if(empty($build_name)&& (!empty($build_num)) && (!empty($class_num))){
		//按条件查询对应用户
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByBuildNumAndClass($build_num,$class_num,$page);
		$pagecounts = $area->queryGetPageCounts1($build_num,$class_num);

		//获取分页信息
		$page = Page::show('area.php?act=query2',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了学院和账号两项数据
	if(!empty($build_name)&& empty($build_num) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByBuildNameAndClass($build_name,$class_num,$page);
		$pagecounts = $area->queryGetPageCounts2($build_name,$class_num);
		//获取分页信息
		$page = Page::show('area.php?act=query3',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了学院和班级两项数据
	if(!empty($build_name)&& (!empty($build_num)) && empty($class_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByBuildNameAndBuildNum($build_name,$build_num,$page);
		$pagecounts = $area->queryGetPageCounts3($build_name,$build_num);
		//获取分页信息
		$page = Page::show('area.php?act=query4',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了学院一项数据
	if(!empty($build_name)&& (empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByBuildName($build_name,$page);
		$pagecounts = $area->queryGetPageCounts4($build_name);
		//获取分页信息
		$page = Page::show('area.php?act=query5',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了班级一项数据
	if(empty($build_name)&& (!empty($build_num)) && (empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByBuildNum($build_num,$page);
		$pagecounts = $area->queryGetPageCounts5($build_num);
		//获取分页信息
		$page = Page::show('area.php?act=query6',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
	
	//用户填写了账号一项数据
	if(empty($build_name)&& (empty($build_num)) && (!empty($class_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$area = new Area();
		//使用getUserByall方法查询用户数据
		$areaInfo = $area->queryGetAreaByClass($class_num,$page);
		$pagecounts = $area->queryGetPageCounts6($class_num);
		//获取分页信息
		$page = Page::show('area.php?act=query7',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-class.html';
	}
}
/*
*显示对应查询条件结果的分页----接area.php?act=query
*/
if($act == 'query1'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByAll($build_name,$build_num,$class_num,$page);
	$pagecounts = $area->queryGetPageCounts0($build_name,$build_num,$class_num);
	//获取分页信息
	$page = Page::show('area.php?act=query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
if($act == 'query2'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	//按条件查询对应用户
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByBuildNumAndClass($build_num,$class_num,$page);
	$pagecounts = $area->queryGetPageCounts1($build_num,$class_num);
	//获取分页信息
	$page = Page::show('area.php?act=query2',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
if($act == 'query3'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByBuildNameAndClass($build_name,$class_num,$page);
	$pagecounts = $area->queryGetPageCounts2($build_name,$class_num);
	//获取分页信息
	$page = Page::show('area.php?act=query3',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
if($act == 'query4'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByBuildNameAndBuildNum($build_name,$build_num,$page);
	$pagecounts = $area->queryGetPageCounts3($build_name,$build_num);
	//获取分页信息
	$page = Page::show('area.php?act=query4',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
	
}
if($act == 'query5'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByBuildName($build_name,$page);
	$pagecounts = $area->queryGetPageCounts4($build_name);
	//获取分页信息
	$page = Page::show('area.php?act=query5',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
if($act == 'query6'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByBuildNum($build_num,$page);
	$pagecounts = $area->queryGetPageCounts5($build_num);
	//获取分页信息
	$page = Page::show('area.php?act=query6',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
if($act == 'query7'){
	$build_name = $_SESSION['build_name'];
	$build_num = $_SESSION['build_num'];
	$class_num = $_SESSION['class_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$area = new Area();
	//使用getUserByall方法查询用户数据
	$areaInfo = $area->queryGetAreaByClass($class_num,$page);
	$pagecounts = $area->queryGetPageCounts6($class_num);
	//获取分页信息
	$page = Page::show('area.php?act=query7',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-class.html';
}
