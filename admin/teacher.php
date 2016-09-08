<?php
//处理学生操作
//获取用户请求的动作和所携带的参数

$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : '';
//包含配置文件
include_once 'includes/init.php';

//判断用户的动作,add为增加用户
if($act == 'add'){
	
	//包含文件
	include_once ADMIN_TEMP . '/add-teacher.html';
}	
if($act == 'insert'){
	//插入数据
	//验证数据合法性
	
	$tea_num = isset($_POST['tea_num']) ? $_POST['tea_num'] : '';
	$tea_name = isset($_POST['tea_name']) ? $_POST['tea_name'] : '';
	$tea_pass = isset($_POST['tea_pass']) ? $_POST['tea_pass'] : '';
	$tea_sex = isset($_POST['tea_sex']) ? $_POST['tea_sex'] : '';
	$tea_coll_name = isset($_POST['tea_coll_name']) ? $_POST['tea_coll_name'] : '';
	$tea_department = isset($_POST['tea_department']) ? $_POST['tea_department'] : '';
	$tea_email = isset($_POST['tea_email']) ? $_POST['tea_email'] : '';
	$tea_level = isset($_POST['tea_level']) ? $_POST['tea_level'] : '';
	
	if(!empty($tea_num)){
		if(!is_numeric($tea_num)){
			admin_redirect('teacher.php?act=add','账户已经存在，请重新输入！',2);
		}
	}

	if(empty($tea_name)){
		admin_redirect('teacher.php?act=add','名字不能为空！',3);
	}
	if(empty($tea_sex)){
		admin_redirect('teacher.php?act=add','性别不能为空！',3);
	}
	if(empty($tea_pass)){
		admin_redirect('teacher.php?act=add','密码不能为空！',3);
	}
	
	if(empty($tea_department)){
			admin_redirect('teacher.php?act=add','部门名称不能为空，若没有所在部门，则填写无',3);

	}
	if(empty($tea_coll_name)){
		admin_redirect('teacher.php?act=add','学院名称不能为空，若没有所在学院，则填写无',3);
	}
	if(empty($tea_email)){
		//使用过滤器过滤邮箱
		//if(filter_var($stu_email,FILTER_VALIDATE_EMAIL)){
			admin_redirect('teacher.php?act=add','邮件格式错误，请输入正确格式！',2);
		//}
	
	}
	
	if(empty($tea_level)){
		admin_redirect('teacher.php?act=add','用户级别不能为空！',3);
	}
	
	$teacher = new Teacher();
	//调用方法增加学生用户
	if($teacher->getUserNum($tea_num)){
		$tea_pass = SHA1($tea_pass);
		if($teacher->addTeachers($tea_num,$tea_name,$tea_pass,$tea_sex,$tea_coll_name,$tea_department,$tea_email,$tea_level)){
			admin_redirect('teacher.php?act=add','插入成功！',2);
		}else{
			admin_redirect('teacher.php?act=add','插入失败，请重新插入',2);
		}
	
	}else{
		admin_redirect('teacher.php?act=add','用户已经存在！',2);
	}
}

//判断用户动作,如果为edit，则进入所有用户界面
if($act == 'edit'){
	//获取页码
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$teacher = new Teacher();
	
	$teacherInfo = $teacher->getallTeacherInfo($page);
	
	$pagecounts = $teacher->getPageCounts();

	//获取分页信息
	$page = Page::show('teacher.php?act=edit',$pagecounts,$page);
	include_once ADMIN_TEMP .'/all-teacher.html';
}
//判断用户动作，delete为删除，但和edit一样进入所有用户界面
if($act == 'delete'){
	//获取页码
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$teacher = new Teacher();
	
	$teacherInfo = $teacher->getallTeacherInfo($page);
	
	$pagecounts = $teacher->getPageCounts();

	//获取分页信息
	$page = Page::show('teacher.php?act=edit',$pagecounts,$page);
	include_once ADMIN_TEMP .'/all-teacher.html';
}

//当用户动作为edit-user时，通过所携带的ID把对应用户数据填写到表单
if($act == 'edit-user'){
	//编辑学生信息
	//获取用户的id
	$tea_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($tea_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('teacher.php?act=edit','没有选择需要编辑的用户',2);
	}
	
	$teacher = new Teacher();
	//获取id值所对应的用户信息
	$teacherInfos = $teacher->getallUserInfoById($tea_id);
	//包含编辑学生HTML文件
	include_once ADMIN_TEMP .'/edit-teacher.html';
	
}

//判断用户动作是否为edit-insert（代表编辑后插入数据到数据库）
if($act =='edit-insert'){
	//验证数据合法性
	
	$tea_num = isset($_POST['tea_num']) ? $_POST['tea_num'] : '';
	$tea_name = isset($_POST['tea_name']) ? $_POST['tea_name'] : '';
	$tea_sex = isset($_POST['tea_sex']) ? $_POST['tea_sex'] : '';
	$tea_coll_name = isset($_POST['tea_coll_name']) ? $_POST['tea_coll_name'] : '';
	$tea_department = isset($_POST['tea_department']) ? $_POST['tea_department'] : '';
	$tea_email = isset($_POST['tea_email']) ? $_POST['tea_email'] : '';
	$tea_level = isset($_POST['tea_level']) ? $_POST['tea_level'] : '';
	
	if(!empty($tea_num)){
			if(!is_numeric($tea_num)){
			admin_redirect('teacher.php?act=add','工号不能为空，请重新输入！',2);
		}
	}

	if(empty($tea_name)){
		admin_redirect('teacher.php?act=add','名字不能为空！',3);
	}
	if(empty($tea_sex)){
		admin_redirect('teacher.php?act=add','性别不能为空！',3);
	}
	
	if(empty($tea_department)){
			admin_redirect('teacher.php?act=add','部门名称不能为空，若没有所在部门，则填写无',3);

	}
	if(empty($tea_coll_name)){
		admin_redirect('teacher.php?act=add','学院名称不能为空，若没有所在学院，则填写无',3);
	}
	if(empty($tea_email)){
		//使用过滤器过滤邮箱
		//if(filter_var($stu_email,FILTER_VALIDATE_EMAIL)){
			admin_redirect('teacher.php?act=add','邮件格式错误，请输入正确格式！',2);
		//}
	
	}
	
	if(empty($tea_level)){
		admin_redirect('teacher.php?act=add','用户级别不能为空！',3);
	}
	
	$teacher = new Teacher();
	//调用方法增加学生用户
	if($teacher->addTeachers($tea_num,$tea_name,$tea_sex,$tea_coll_name,$tea_department,$tea_email,$tea_level)){
		admin_redirect('teacher.php?act=add','插入成功！',2);
	}else{
		admin_redirect('teacher.php?act=add','插入失败，请重新插入',2);
	}
}

if($act == 'delete-user'){
	
	//获取用户的id
	$tea_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($tea_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('teacher.php?act=edit','没有选择需要删除的用户！',2);
	}
	
	$teacher = new Teacher();
	//删除指定ID用户的信息
	if($teacher->deleteUserById($tea_id)){
		//删除成功
		admin_redirect('teacher.php?act=edit','用户信息已删除！',2);
	}else{
		//删除失败
		admin_redirect('teacher.php?act=delete','由于系统原因不能删除用户，请重试！',2);
	}
}

if($act == 'query'){
	//接受用户提交数据
	$tea_coll_name = isset($_POST['tea_coll_name']) ? $_POST['tea_coll_name'] : '';
	$tea_department = isset ($_POST['tea_department']) ? $_POST['tea_department'] : '';
	$tea_num = isset ($_POST['tea_num']) ? $_POST['tea_num'] : '';
	//把传入的条件保存到会话中
	$_SESSION['tea_coll_name'] = $tea_coll_name;
	$_SESSION['tea_department'] = $tea_department;
	$_SESSION['tea_num'] = $tea_num;
	//判断表单数据的合法性
	//所有条件都没填写即点击查询
	if(!$tea_coll_name && !$tea_department && !$tea_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有学生信息
		$teacher = new Teacher();	
		$teacherInfo = $teacher->getallTeacherInfo($page);	
		$pagecounts = $teacher->getPageCounts();
		//获取分页信息
		$page = Page::show('teacher.php?act=edit',$pagecounts,$page);
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	//用户填写了全部数据
	if($tea_coll_name && $tea_department && $tea_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getTeaInfoByall方法查询用户数据
		$teacherInfo = $teacher->getTeaInfoByAll($page,$tea_coll_name,$tea_department,$tea_num);
		$pagecounts = $teacher->getPageCounts0($tea_coll_name,$tea_department,$tea_num);
		//获取分页信息
		$page = Page::show('teacher.php?act=query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了班级和账号两项数据
	if(empty($tea_coll_name)&& (!empty($tea_department)) && (!empty($tea_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByDeparmentAndNum($page,$tea_department,$tea_num);
		$pagecounts = $teacher->getPageCounts3($tea_department,$tea_num);
		//获取分页信息
		$page = Page::show('teacher.php?act=query2',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了学院和账号两项数据
	if(!empty($tea_coll_name)&& empty($tea_department) && (!empty($tea_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByCollAndNum($page,$tea_coll_name,$tea_num);
		$pagecounts = $teacher->getPageCounts2($tea_coll_name,$tea_num);
		//获取分页信息
		$page = Page::show('teacher.php?act=query3',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了学院和班级两项数据
	if(!empty($tea_coll_name)&& (!empty($tea_department)) && empty($tea_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByCollAndDeparment($page,$tea_coll_name,$tea_department);
		$pagecounts = $teacher->getPageCounts1($tea_coll_name,$tea_department);
		//获取分页信息
		$page = Page::show('teacher.php?act=query4',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了学院一项数据
	if(!empty($tea_coll_name)&& (empty($tea_department)) && (empty($tea_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByColl($page,$tea_coll_name);
		$pagecounts = $teacher->getPageCounts5($tea_coll_name);
		//获取分页信息
		$page = Page::show('teacher.php?act=query5',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了班级一项数据
	if(empty($tea_coll_name)&& (!empty($tea_department)) && (empty($tea_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByDeparment($page,$tea_department);
		$pagecounts = $teacher->getPageCounts4($tea_department);
		//获取分页信息
		$page = Page::show('teacher.php?act=query6',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
	
	//用户填写了账号一项数据
	if(empty($tea_coll_name)&& (empty($tea_department)) && (!empty($tea_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$teacher = new Teacher();	
		//使用getUserByall方法查询用户数据
		$teacherInfo = $teacher->getUserByNum($page,$tea_num);
		$pagecounts = $teacher->getPageCounts6($tea_num);
		//获取分页信息
		$page = Page::show('teacher.php?act=query7',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-teacher.html';
	}
}
//当用户进入query中对应的查询条件，显示对应条件查询的分页
if($act == 'query1'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getTeaInfoByAll($page,$tea_coll_name,$tea_department,$tea_num);
	$pagecounts = $teacher->getPageCounts0($tea_coll_name,$tea_department,$tea_num);
	//获取分页信息
	$page = Page::show('teacher.php?act=query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query2'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByDeparmentAndNum($page,$tea_department,$tea_num);
	$pagecounts = $teacher->getPageCounts3($tea_department,$tea_num);
	//获取分页信息
	$page = Page::show('teacher.php?act=query2',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query3'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByCollAndNum($page,$tea_coll_name,$tea_num);
	$pagecounts = $teacher->getPageCounts2($tea_coll_name,$tea_num);
	//获取分页信息
	$page = Page::show('teacher.php?act=query3',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query4'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByCollAndDeparment($page,$tea_coll_name,$tea_department);
	$pagecounts = $teacher->getPageCounts1($tea_coll_name,$tea_department);
	//获取分页信息
	$page = Page::show('teacher.php?act=query4',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query5'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByColl($page,$tea_coll_name);
	$pagecounts = $teacher->getPageCounts5($tea_coll_name);
	//获取分页信息
	$page = Page::show('teacher.php?act=query5',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query6'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByDeparment($page,$tea_department);
	$pagecounts = $teacher->getPageCounts4($tea_department);
	//获取分页信息
	$page = Page::show('teacher.php?act=query6',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}
if($act == 'query7'){
	$tea_coll_name  = $_SESSION['tea_coll_name'];
	$tea_department = $_SESSION['tea_department'];
	$tea_num = $_SESSION['tea_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$teacher = new Teacher();	
	//使用getUserByall方法查询用户数据
	$teacherInfo = $teacher->getUserByNum($page,$tea_num);
	$pagecounts = $teacher->getPageCounts6($tea_num);
	//获取分页信息
	$page = Page::show('teacher.php?act=query7',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-teacher.html';
}