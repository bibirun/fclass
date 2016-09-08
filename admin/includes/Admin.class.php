<?php

	//Admin表对应的类
	class Admin extends DB{
		//属性
		protected $table = 'admin';

		/*
		 * 通过用户名和密码验证用户信息
		 * @param1 string $usernum，用户账号
		 * @param2 string $password，用户密码
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function checkByUsernumAndPassword($usernum,$password){
			//加密密码
			$password = SHA1($password);

			//转义
			$usernum = addslashes($usernum);

			//组织SQL语句
			$sql = "select * from {$this->getTableName()} where ad_num = '{$usernum}' and ad_pass = '{$password}'";

			//调用DB类的getRow方法
			return $this->db_getRow($sql);
		}
		
		
		/*
		 * 通过管理员账号获取管理员邮箱和密码
		 * @param1 string $usernum，用户账号
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function getAdminEmailByNum($usernum){

			//组织SQL语句
			$sql = "select ad_email from {$this->getTableName()} where ad_num = '{$usernum}'";

			//调用DB类的getRow方法
			return $this->db_getRow($sql);
		}
		
		/* admin.php?act = query||admin.php?act=edit
		 * 通过管理员账号获取管理员信息
		 * @param1 string $ad_id，用户账号
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function getAdminInfoByNum($ad_num){

			//组织SQL语句
			$sql = "select * from {$this->getTableName()} where ad_num = '{$ad_num}'";

			//调用DB类的getRow方法
			return $this->db_getRow($sql);
		}
		
		/* admin.php?act = change-pass
		 * 通过管理员账号获取管理员信息
		 * @param1 string $ad_id，用户账号
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function getAdminPassByNum($usernum){

			//组织SQL语句
			$sql = "select ad_pass from {$this->getTableName()} where ad_num = '{$usernum}'";

			//调用DB类的getRow方法
			return $this->db_getRow($sql);
		}
		
		/* admin.php
		 * 通过管理员账号获取管理员邮箱和密码
		 * @param1 string $usernum，用户账号
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function updateAdminPassByNum($usernum,$ad_pass){

			//组织SQL语句
			$sql = "update  {$this->getTableName()} set ad_pass = '{$ad_pass}' where ad_num = '{$usernum}'";

			//调用DB类的getRow方法
			return $this->db_update($sql);
		}
		
		/* admin.php?act=update_edit
		 * 通过管理员账号获取管理员邮箱和密码
		 * @param1 string $usernum，用户账号
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function updateAdminInfoByNum($ad_num,$ad_name,$ad_sex,$ad_email){

			//组织SQL语句
			$sql = "update  {$this->getTableName()} set ad_name = '{$ad_name}', ad_sex = '{$ad_sex}',ad_email = '{$ad_email}' where ad_num = '{$ad_num}' limit 1";

			//调用DB类的getRow方法
			return $this->db_update($sql);
		}
		
	/*privilege.php
	*获取随机字符串
	*@param void
	*@return string
	*/
	function getRandChar(){
	$str = null;
	   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	   $max = strlen($strPol)-1;
	   for($i=0;$i<8;$i++){
		$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	   }
	   return $str;
  }

	}