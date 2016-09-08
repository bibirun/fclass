<?php
class Teacher extends DB{
	protected $table = 'teacher';
	
	/*增加用户
	*
	*
	*/
	public function addTeachers($tea_num,$tea_name,$tea_pass,$tea_sex,$tea_coll_name,$tea_department,$tea_email,$tea_level){
		
		$sql = "insert into {$this->getTableName()} values(null,'{$tea_num}','{$tea_name}','{$tea_pass}','{$tea_sex}','{$tea_coll_name}','{$tea_department}','{$tea_email}','{$tea_level}')";
		
		//调用父类方法
		return $this->db_insert($sql);
	}
	
	
	/*检查用户是否存在用户
	*@param1 string $num
	*return boolean 有返回FALSE，没有返回TRUE
	*/
	public function editTeachers($tea_num,$tea_name,$tea_sex,$tea_coll_name,$tea_department,$tea_email,$tea_level){
		$sql = "update {$this->getTableName()} set tea_num = '{$tea_num}',tea_name = '{$tea_name}',tea_sex = '{$tea_sex}',tea_coll_name = '{$tea_coll_name}',tea_department = '{$tea_department}',tea_email = '{$tea_email}',tea_level = '{$tea_level}' where tea_num ='{$tea_num}'";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*检查用户是否存在用户
	*@param1 string $num
	*return boolean 有返回FALSE，没有返回TRUE
	*/
	public function getUserNum($tea_num){
		$sql = "select * from {$this->getTableName()} where tea_num = '{$tea_num}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql) ? FALSE : TRUE;
	}
	
	/*获取所有学生信息
	*
	*return array
	*/
	public function getAllTeacherInfo($page){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	/*
		 * 获取当前学生的所有记录
		 * @return 返回当前商品的所有记录
		*/
		public function getPageCounts(){
			$sql = "select count(*) pagecounts from {$this->getTableName()}";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	
	/*通过ID获取所有教师信息
	*param1 string tea_id
	*return array
	*/
	public function getAllUserInfoById($tea_id){
		$sql = "select * from {$this->getTableName()} where tea_id = '{$tea_id}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*通过ID删除对应ID教师信息
	*param1 string stu_id
	*return array
	*/
	public function deleteUserById($tea_id){
		$sql = "delete from {$this->getTableName()}  where tea_id = '{$tea_id}' limit 1";
		return $this->db_delete($sql);
	}
	
	/*
	 * 通过用户名和密码验证用户信息
	 * @param1 string $usernum，用户账号
	 * @param2 string $password，用户密码
	 * @return mixed，成功返回用户信息，失败返回FALSE
	*/
	public function checkTeacherByNumAndPass($usernum,$password){
		//加密密码
		$password = SHA1($password);
		//转义
		$usernum = addslashes($usernum);
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_num = '{$usernum}' and tea_pass = '{$password}'";
		//调用DB类的getRow方法
		return $this->db_getRow($sql);
	}
	/*****查询条件块从这里开始******/
	
	/*通过用户填写的条件进行查询教师信息
	*@param string tea_coll_name && tea_department && tea_num
	*@return array
	*/
	public function getTeaInfoByAll($page,$tea_coll_name,$tea_department,$tea_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_department = '{$tea_department}' and tea_num = '{$tea_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	
	/*teacher.php?act=query
	 * 获取当前教师记录数量
	 *@param string tea_coll_name && tea_department && tea_num
	 * @return 返回当前教师记录数量
	*/
		public function getPageCounts0($tea_coll_name,$tea_department,$tea_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_department = '{$tea_department}' and tea_num = '{$tea_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询教师信息
	*@param1 string tea_coll_name
	*@param2 string tea_coll_name
	*@return array
	*/
	public function getUserByCollAndDeparment($page,$tea_coll_name,$tea_department){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_department = '{$tea_department}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param1 string tea_coll_name
	 *@param2 string tea_coll_name
	 *@return 教师记录数量
	*/
		public function getPageCounts1($tea_coll_name,$tea_department){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_department = '{$tea_department}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询教师信息
	*@param1 string tea_coll_name
	*@param2 string tea_num
	*@return array
	*/
	public function getUserByCollAndNum($page,$tea_coll_name,$tea_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_num = '{$tea_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param1 string tea_coll_name
	 *@param2 string tea_num
	 *@return 教师记录数量
	*/
		public function getPageCounts2($tea_coll_name,$tea_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' and tea_num = '{$tea_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*通过用户填写的条件进行查询教师信息
	*@param1 string tea_department
	*@param2 string tea_num
	*@return 教师记录数量
	*/
	public function getUserByDeparmentAndNum($page,$tea_department,$tea_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_department = '{$tea_department}' and tea_num = '{$tea_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param1 string tea_department
	 *@param2 string tea_num
	 *@return 教师记录数量
	*/
		public function getPageCounts3($tea_department,$tea_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_department = '{$tea_department}' and tea_num = '{$tea_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询教师信息
	*@param1 string tea_department
	*@return 教师记录数量
	*/
	public function getUserByDeparment($page,$tea_department){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_department = '{$tea_department}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param1 string tea_department
	 * @return 返回当前教师记录数量
	*/
		public function getPageCounts4($tea_department){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_department = '{$tea_department}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询教师信息
	*@param1 string $tea_coll_name
	*@return 教师记录数量
	*/
	public function getUserByColl($page,$tea_coll_name){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param string tea_coll_name
	 *@return 返回当前教师记录数量
	*/
		public function getPageCounts5($tea_coll_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where tea_coll_name = '{$tea_coll_name}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/*通过用户填写的条件进行查询教师信息
	*param1 string tea_num
	*return 教师记录数量
	*/
	public function getUserByNum($page,$tea_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where tea_num = '{$tea_num}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前教师的所有记录
	 *@param string tea_num
	 * @return 返回当前的教师记录数量
	*/
		public function getPageCounts6($tea_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where  tea_num = '{$tea_num}'";
			$res = $this->db_getRow($sql);
			//返回
			return $res ? $res['pagecounts'] : false; 
		}
	/**********/
	/**********/
	/*****查询块到这里结束*****/
	
}