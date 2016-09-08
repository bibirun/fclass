<?php
class Student extends DB{
	protected $table = 'student';
	
	/*增加用户
	*
	*
	*/
	public function addStudents($stu_num,$stu_name,$stu_pass,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level){
		
		$sql = "insert into {$this->getTableName()} values(null,'{$stu_num}','{$stu_name}','{$stu_pass}','{$stu_sex}','{$stu_coll_name}','{$stu_grade_name}','{$stu_email}','{$stu_level}')";
		
		//调用父类方法
		return $this->db_insert($sql);
	}
	
	
	/*检查用户是否存在用户
	*@param1 string $num
	*return boolean 有返回FALSE，没有返回TRUE
	*/
	public function editStudents($stu_num,$stu_name,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level){
		$sql = "update {$this->getTableName()} set stu_num = '{$stu_num}',stu_name = '{$stu_name}',stu_sex = '{$stu_sex}',stu_coll_name = '{$stu_coll_name}',stu_grade_name = '{$stu_grade_name}',stu_email = '{$stu_email}',stu_level = '{$stu_level}' where stu_num ='{$stu_num}'";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*检查用户是否存在用户
	*@param1 string $num
	*return boolean 有返回FALSE，没有返回TRUE
	*/
	public function getUserNum($stu_num){
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql) ? FALSE : TRUE;
	}
	
	/*获取所有学生信息
	*
	*return array
	*/
	public function getAllStudentInfo($page){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	
	/*user_center.php
	*获取学生信息
	*param1 string $stu_name
	*return array
	*/
	public function getStudentInfoByNum($stu_num){
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit 1";
		
		return $this->db_getRow($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts(){
			$sql = "select count(*) pagecounts from {$this->getTableName()}";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	
	/*通过ID获取所有学生信息
	*param1 string stu_id
	*return array
	*/
	public function getAllUserInfoById($stu_id){
		$sql = "select * from {$this->getTableName()} where stu_id = '{$stu_id}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*通过ID删除对应ID学生信息
	*param1 string stu_id
	*return array
	*/
	public function deleteUserById($stu_id){
		$sql = "delete from {$this->getTableName()}  where stu_id = '{$stu_id}' limit 1";
		return $this->db_delete($sql);
	}
	
	/*通过用户填写的条件进行查询学生信息
	*@param1 string stu_coll_name
	*@param2 string stu_grade_name
	*@param3 string stu_num
	*@eturn array
	*/
	public function getUserByAll($page,$stu_coll_name,$stu_grade_name,$stu_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts0($stu_coll_name,$stu_grade_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_grade_name
	*return array
	*/
	public function getUserByCollAndGrade($page,$stu_coll_name,$stu_grade_name){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts1($stu_coll_name,$stu_grade_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_num
	*return array
	*/
	public function getUserByCollAndNum($page,$stu_coll_name,$stu_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts2($stu_coll_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*param2 string stu_num
	*return array
	*/
	public function getUserByGradeAndNum($page,$stu_grade_name,$stu_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts3($stu_grade_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*return array
	*/
	public function getUserByGrade($page,$stu_grade_name){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts4($stu_grade_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*return array
	*/
	public function getUserByColl($page,$stu_coll_name){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts5($stu_coll_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_num
	*return array
	*/
	public function getUserByNum($page,$stu_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
		public function getPageCounts6($stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where  stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*
		 * 通过用户名和密码验证用户信息
		 * @param1 string $usernum，用户账号
		 * @param2 string $password，用户密码
		 * @return mixed，成功返回用户信息，失败返回FALSE
		*/
		public function checkStudentByNumAndPassword($usernum,$password){
			//加密密码
			$password = SHA1($password);

			//转义
			$usernum = addslashes($usernum);

			//组织SQL语句
			$sql = "select * from {$this->getTableName()} where stu_num = '{$usernum}' and stu_pass = '{$password}'";

			//调用DB类的getRow方法
			return $this->db_getRow($sql);
		}
		
	/*通过用户填写的条件进行查询学生信息
	*param1 string new_password 
	*return 成功返回受影响行数，失败返回FALSE
	*/
	public function updateStudentPass($new_password,$stu_id){
		//组织SQL语句
		$sql = "update {$this->getTableName()} set stu_pass = '{$new_password}' where stu_id = {$stu_id}";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*deal.php?act=deal
	 *通过帐户找学生邮箱
	 *@param1 string $usernum
	 *@return 成功返回邮箱，失败返回FALSE
	*/
	public function getEmailByUserNum($usernum){
		$sql = "select stu_email from {$this->getTableName()} where stu_num = '{$usernum}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*通过用户名找学生邮箱user_center.php?act=get_new_pass
	*param1 string $usernum
	*return 成功返回邮箱，失败返回FALSE
	*/
	public function getStudentEmailByNum($usernum){
		$sql = "select stu_email from {$this->getTableName()} where stu_num = '{$usernum}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*通过用户账号修改用户密码user_center.php?act=get_new_pass
	*param1 string $usernum
	*return 成功返回邮箱，失败返回FALSE
	*/
	public function updateStudentPassByNum($usernum,$stu_pass){
		$sql = "update {$this->getTableName()} set stu_pass = '{$stu_pass}' where stu_num = '{$usernum}'";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*home.privilege.php
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