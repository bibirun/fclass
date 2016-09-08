<?php
//处理学生操作
//获取用户请求的动作和所携带的参数

$act = isset ($_REQUEST['act']) ? $_REQUEST['act'] : '';
//包含配置文件
include_once 'includes/init.php';

//判断用户的动作,add为增加用户
if($act == 'add'){
	
	//包含文件
	include_once ADMIN_TEMP . '/add-student.html';
}	
if($act == 'insert'){
	//插入数据
	//验证数据合法性
	
	$stu_num = isset($_POST['stu_num']) ? $_POST['stu_num'] : '';
	$stu_name = isset($_POST['stu_name']) ? $_POST['stu_name'] : '';
	$stu_pass = isset($_POST['stu_pass']) ? $_POST['stu_pass'] : '';
	$stu_sex = isset($_POST['stu_sex']) ? $_POST['stu_sex'] : '';
	$stu_coll_name = isset($_POST['stu_coll_name']) ? $_POST['stu_coll_name'] : '';
	$stu_grade_name = isset($_POST['stu_grade_name']) ? $_POST['stu_grade_name'] : '';
	$stu_email = isset($_POST['stu_email']) ? $_POST['stu_email'] : '';
	$stu_level = isset($_POST['stu_level']) ? $_POST['stu_level'] : '';
	
	if(!empty($stu_num)){
		if(!is_numeric($stu_num)){
			admin_redirect('student.php?act=add','student number must use number！',2);
		}
	}

	if(empty($stu_name)){
		admin_redirect('student.php?act=add','name is null！！',3);
	}
	if(empty($stu_sex)){
		admin_redirect('student.php?act=add','sex is null！',3);
	}
	if(empty($stu_pass)){
		admin_redirect('student.php?act=add','password is null！',3);
	}
	
	if(empty($stu_grade_name)){
			admin_redirect('student.php?act=add','grade is null！',2);

	}
	if(empty($stu_coll_name)){
		admin_redirect('student.php?act=add','college is null！',3);
	}
	if(empty($stu_email)){
		//使用过滤器过滤邮箱
		//if(filter_var($stu_email,FILTER_VALIDATE_EMAIL)){
			admin_redirect('student.php?act=add','email error',2);
		//}
	
	}
	
	if(empty($stu_level)){
		admin_redirect('student.php?act=add','Phone is Null！',3);
	}
	
	$student = new Student();
	//调用方法增加学生用户
	if($student->getUserNum($stu_num)){
		$stu_pass = SHA1($stu_pass);
		if($student->addStudents($stu_num,$stu_name,$stu_pass,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level)){
			admin_redirect('student.php?act=add','succeed',2);
		}else{
			admin_redirect('student.php?act=add','插入失败！',2);
		}
	
	}else{
		admin_redirect('student.php?act=add','用户已经存在！',2);
	}
}

//判断用户动作,如果为edit，则进入所有用户界面
if($act == 'edit'){
	//获取页码
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$student = new Student();
	
	$studentInfo = $student->getAllStudentInfo($page);
	
	$pagecounts = $student->getPageCounts();

	//获取分页信息
	$page = Page::show('student.php?act=edit',$pagecounts,$page);
	include_once ADMIN_TEMP .'/all-student.html';
}
//判断用户动作，delete为删除，但和edit一样进入所有用户界面
if($act == 'delete'){
	
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//获取所有学生信息
	$student = new Student();
	
	$studentInfo = $student->getallStudentInfo($page);
	
	$pagecounts = $student->getPageCounts();

	//获取分页信息
	$page = Page::show('student.php?act=edit',$pagecounts,$page);
	
	include_once ADMIN_TEMP .'/all-student.html';
}

//当用户动作为edit-user时，通过所携带的ID把对应用户数据填写到表单
if($act == 'edit-user'){
	//编辑学生信息
	//获取用户的id
	$stu_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($stu_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('student.php?act=edit','没有选择需要编辑的用户',2);
	}
	
	$student = new Student();
	//获取id值所对应的用户信息
	$studentInfos = $student->getallUserInfoById($stu_id);
	//包含编辑学生HTML文件
	include_once ADMIN_TEMP .'/edit-student.html';
	
}

//判断用户动作是否为edit-insert（代表编辑后插入数据到数据库）
if($act =='edit-insert'){
	//验证数据合法性
	
	$stu_num = isset($_POST['stu_num']) ? $_POST['stu_num'] : '';
	$stu_name = isset($_POST['stu_name']) ? $_POST['stu_name'] : '';
	$stu_sex = isset($_POST['stu_sex']) ? $_POST['stu_sex'] : '';
	$stu_coll_name = isset($_POST['stu_coll_name']) ? $_POST['stu_coll_name'] : '';
	$stu_grade_name = isset($_POST['stu_grade_name']) ? $_POST['stu_grade_name'] : '';
	$stu_email = isset($_POST['stu_email']) ? $_POST['stu_email'] : '';
	$stu_level = isset($_POST['stu_level']) ? $_POST['stu_level'] : '';
	
	if(empty($stu_num)){
		if(!is_numeric($stu_num)){
			admin_redirect('student.php?act=add','student number must use number！',2);
		}
	}

	if(empty($stu_name)){
		admin_redirect('student.php?act=add','name is null！！',3);
	}
	if(empty($stu_sex)){
		admin_redirect('student.php?act=add','sex is null！',3);
	}
	
	if(empty($stu_grade_name)){
			admin_redirect('student.php?act=add','grade is null！',2);

	}
	if(empty($stu_coll_name)){
		admin_redirect('student.php?act=add','college is null！',3);
	}
	if(empty($stu_email)){
		//使用过滤器过滤邮箱
		//if(filter_var($stu_email,FILTER_VALIDATE_EMAIL)){
			admin_redirect('student.php?act=add','email error',2);
		}
	
	
	if(empty($stu_level)){
		admin_redirect('student.php?act=add','Phone is Null！',3);
	}
	
	$student = new Student();
	//调用方法增加学生用户
	
	if($student->editStudents($stu_num,$stu_name,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level)){
		admin_redirect('student.php?act=edit','edit insert succeed',2);
	}else{
		admin_redirect('student.php?act=edit','edit insert failed！',2);
	}
	
}
if($act == 'delete-user'){
	
	//获取用户的id
	$stu_id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if($stu_id == 0){
		//没有传入ID值，跳转页面
		admin_redirect('student.php?act=edit','请选择需要删除的用户！',2);
	}
	
	$student = new Student();
	//删除指定ID用户的信息
	if($student->deleteUserById($stu_id)){
		//删除成功
		admin_redirect('student.php?act=edit','用户已经删除！',2);
	}else{
		//删除失败
		admin_redirect('student.php?act=delete','删除失败，请重新尝试！',2);
	}
}

if($act == 'query'){
	//接受用户提交数据
	$stu_coll_name = isset($_POST['stu_coll_name']) ? $_POST['stu_coll_name'] : '';
	$stu_grade_name = isset ($_POST['stu_grade_name']) ? $_POST['stu_grade_name'] : '';
	$stu_num = isset ($_POST['stu_num']) ? $_POST['stu_num'] : '';
	//把传入的条件保存到会话中
	$_SESSION['stu_coll_name'] = $stu_coll_name;
	$_SESSION['stu_grade_name'] = $stu_grade_name;
	$_SESSION['stu_num'] = $stu_num;
	//判断表单数据的合法性
	//所有条件都没填写即点击查询
	if(!$stu_coll_name && !$stu_grade_name && !$stu_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//获取所有学生信息
		$student = new Student();
		$studentInfo = $student->getallStudentInfo($page);
		$pagecounts = $student->getPageCounts();
		//获取分页信息
		$page = Page::show('student.php?act=edit',$pagecounts,$page);
		include_once ADMIN_TEMP .'/all-student.html';
	}
	//用户填写了全部数据
	if($stu_coll_name && $stu_grade_name && $stu_num){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByAll($page,$stu_coll_name,$stu_grade_name,$stu_num);
		$pagecounts = $student->getPageCounts0($stu_coll_name,$stu_grade_name,$stu_num);
		//获取分页信息
		$page = Page::show('student.php?act=query1',$pagecounts,$page);	
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了班级和账号两项数据
	if(empty($stu_coll_name)&& (!empty($stu_grade_name)) && (!empty($stu_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByGradeAndNum($page,$stu_grade_name,$stu_num);
		$pagecounts = $student->getPageCounts3($stu_grade_name,$stu_num);
		//获取分页信息
		$page = Page::show('student.php?act=query2',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了学院和账号两项数据
	if(!empty($stu_coll_name)&& empty($stu_grade_name) && (!empty($stu_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByCollAndNum($page,$stu_coll_name,$stu_num);
		$pagecounts = $student->getPageCounts2($stu_coll_name,$stu_num);
		//获取分页信息
		$page = Page::show('student.php?act=query3',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了学院和班级两项数据
	if(!empty($stu_coll_name)&& (!empty($stu_grade_name)) && empty($stu_num)){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByCollAndGrade($page,$stu_coll_name,$stu_grade_name);
		$pagecounts = $student->getPageCounts1($stu_coll_name,$stu_grade_name);
		//获取分页信息
		$page = Page::show('student.php?act=query4',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了学院一项数据
	if(!empty($stu_coll_name)&& (empty($stu_grade_name)) && (empty($stu_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByColl($page,$stu_coll_name);
		$pagecounts = $student->getPageCounts5($stu_coll_name);
		//获取分页信息
		$page = Page::show('student.php?act=query5',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了班级一项数据
	if(empty($stu_coll_name)&& (!empty($stu_grade_name)) && (empty($stu_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByGrade($page,$stu_grade_name);
		$pagecounts = $student->getPageCounts4($stu_grade_name);
		//获取分页信息
		$page = Page::show('student.php?act=query6',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
	
	//用户填写了账号一项数据
	if(empty($stu_coll_name)&& (empty($stu_grade_name)) && (!empty($stu_num))){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//按条件查询对应用户
		$student = new Student();
		//使用getUserByall方法查询用户数据
		$studentInfo = $student->getUserByNum($page,$stu_num);
		$pagecounts = $student->getPageCounts6($stu_num);
		//获取分页信息
		$page = Page::show('student.php?act=query7',$pagecounts,$page);		
		include_once ADMIN_TEMP .'/all-student.html';
	}
}
//当用户进入query中对应的查询条件，显示对应条件查询的分页
if($act == 'query1'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByAll($page,$stu_coll_name,$stu_grade_name,$stu_num);
	$pagecounts = $student->getPageCounts0($stu_coll_name,$stu_grade_name,$stu_num);
	//获取分页信息
	$page = Page::show('student.php?act=query1',$pagecounts,$page);	
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query2'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByGradeAndNum($page,$stu_grade_name,$stu_num);
	$pagecounts = $student->getPageCounts3($stu_grade_name,$stu_num);
	//获取分页信息
	$page = Page::show('student.php?act=query2',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query3'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByCollAndNum($page,$stu_coll_name,$stu_num);
	$pagecounts = $student->getPageCounts2($stu_coll_name,$stu_num);
	//获取分页信息
	$page = Page::show('student.php?act=query3',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query4'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByCollAndGrade($page,$stu_coll_name,$stu_grade_name);
	$pagecounts = $student->getPageCounts1($stu_coll_name,$stu_grade_name);
	//获取分页信息
	$page = Page::show('student.php?act=query4',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query5'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByColl($page,$stu_coll_name);
	$pagecounts = $student->getPageCounts5($stu_coll_name);
	//获取分页信息
	$page = Page::show('student.php?act=query5',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query6'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByGrade($page,$stu_grade_name);
	$pagecounts = $student->getPageCounts4($stu_grade_name);
	//获取分页信息
	$page = Page::show('student.php?act=query6',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}
if($act == 'query7'){
	$stu_coll_name  = $_SESSION['stu_coll_name'];
	$stu_grade_name = $_SESSION['stu_grade_name'];
	$stu_num = $_SESSION['stu_num'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	//按条件查询对应用户
	$student = new Student();
	//使用getUserByall方法查询用户数据
	$studentInfo = $student->getUserByNum($page,$stu_num);
	$pagecounts = $student->getPageCounts6($stu_num);
	//获取分页信息
	$page = Page::show('student.php?act=query7',$pagecounts,$page);		
	include_once ADMIN_TEMP .'/all-student.html';
}