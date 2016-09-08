<?php

//获取用户当前的动作请求
$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

//加载公共文件
include_once 'includes/init.php';
//判断用户动作，如果用户动作为query，代表用户查询个人信息
if($act == 'query'){
	if(isset($_SESSION['admin'])){
		$ad_num = $_SESSION['admin']['ad_num'];
		//新建Admin类对象admin
		$admin = new Admin();
		//获取管理员信息
		$adminInfos = $admin->getAdminInfoByNum($ad_num);
		include_once ADMIN_TEMP . '/admin_info.html';
	}else{
		admin_redirect('privilege.php?act=login','请先登录！',1);
	}
	
}

//判断用户动作，如果用户动作为edit，代表管理员需要进入修改个人信息页面
if($act == 'edit'){
	$ad_num = $_SESSION['admin']['ad_num'];
	$admin = new Admin();
	$adminInfo = $admin->getAdminInfoByNum($ad_num);
	include_once ADMIN_TEMP . '/admin-edit.html';
}
//判断用户动作，如果用户动作为update_edit，代表管理员需要进入提交了编辑后的信息
if($act == 'update_edit'){
	$ad_name = isset($_POST['ad_name']) ? strip_tags($_POST['ad_name']) : '';
	$ad_sex = isset($_POST['ad_sex']) ? strip_tags($_POST['ad_sex']) : '';
	$ad_email = isset($_POST['ad_email']) ? strip_tags($_POST['ad_email']) : '';
	//判断数据合法性
	if(!$ad_name){
		admin_redirect('admin.php?act=edit','名字不能为空，请输入名字。',1);
	}
	if(!$ad_sex){
		admin_redirect('admin.php?act=edit','性别不能为空，请选择性别。',1);
	}
	if(!$ad_email){
		admin_redirect('admin.php?act=edit','邮箱不能为空，请输入邮箱',1);
	}
	if(!preg_match(' /^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/ ',$ad_email)){
		admin_redirect('admin.php?act=edit','邮箱格式错误，请使用正确邮箱格式。',1);
	}
	//新建Admin类对象admin
	$ad_num = $_SESSION['admin']['ad_num'];
	$admin = new Admin();
	if($admin->updateAdminInfoByNum($ad_num,$ad_name,$ad_sex,$ad_email)){
		admin_redirect('admin.php?act=query','信息已更新成功！',1);
	}else{
		admin_redirect('admin.php?act=edit','数据更新失败，请重新尝试！',1);
	}
}

//判断用户动作，如果用户动作为change-pass，代表管理员需要进入修改密码页面
if($act == 'change-pass'){
	include_once ADMIN_TEMP . '/ad_change_pass.html';
}
//判断用户动作，如果用户动作为update-pass，代表管理员修改密码并提交
if($act == 'update-pass'){
	//验证数据合法性
	$old_pass = isset($_POST['old-password']) ? $_POST['old-password'] : '';
	$new_pass = isset($_POST['new-password']) ? $_POST['new-password'] : '';
	$confirm_pass = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
	if(!$old_pass){
		admin_redirect('admin.php?act=change-pass','原密码不能为空！',1);
	}
	if(!$new_pass){
		admin_redirect('admin.php?act=change-pass','新密码不能为空！',1);
	}
	if(!$confirm_pass){
		admin_redirect('admin.php?act=change-pass','确认密码不能为空！',1);
	}
	if($new_pass != $confirm_pass){
		admin_redirect('admin.php?act=change-pass','两次密码输入不相同，请重新输入！',1);
	}
	//使用SHA1加密，并去除所有HTML和PHP标签
	$old_pass = SHA1(strip_tags($old_pass));
	$ad_pass = SHA1(strip_tags($new_pass));
	if($old_pass == $ad_pass){
		admin_redirect('admin.php?act=change-pass','新密码不能与原密码相同，请重新输入！',1);
	}
	//通过会话保存的数据获取登录用户的账号
	$usernum = $_SESSION['admin']['ad_num'];
	//新建Admin类对象admin
	$admin = new Admin();
	//通过账号获取用户原密码
	$password = $admin->getAdminPassByNum($usernum);
	if($old_pass != $password){
		admin_redirect('admin.php?act=change-pass','原密码不正确，请重新输入！',1);
	}
	if($admin->updateAdminPassByNum($usernum,$ad_pass)){
		admin_redirect('privilege.php?act=login','密码已成功修改',1);
	}else{
		admin_redirect('admin.php?act=change-pass','密码修改失败，请重新修改密码！',1);
	}
}