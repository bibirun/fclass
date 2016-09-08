<?php
//新建Area类继承DB类
class Area extends DB{
	protected $table = 'class';
	
	/*增加用户
	*@
	*return 成功返回受影响的行数，失败返回FALSE
	*/
	public function addArea($build_name,$build_num,$class_num,$class_contain_num,$class_type,$class_time){
		
		$sql = "insert into {$this->getTableName()} values(null,'{$build_name}','{$build_num}','{$class_num}','{$class_contain_num}','{$class_type}',default,'{$class_time}')";
		
		//调用父类方法
		return $this->db_insert($sql);
	}
	
	
	/*更新场地
	*@param1 string 
	*return 成功返回受影响行数，失败返回FALSE
	*/
	public function updateArea($build_name,$build_num,$class_num,$class_contain_num,$class_type,$class_time,$class_id){
		$sql = "update {$this->getTableName()} set build_name = '{$build_name}',build_num = '{$build_num}',class_num = '{$class_num}',class_contain_num = '{$class_contain_num}',class_type = '{$class_type}',class_time = '{$class_time}' where class_id = '{$class_id}' limit 1";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*检查用户是否存在用户
	*@param1 string $build_name
	*@param2 string $build_num
	*@param3 string $class_num
	*return 成功返回FALSE，失败返回TRUE
	*/
	public function checkArea($build_name,$build_num,$class_num,$class_time){
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}'and build_num = '{$build_num}' and class_num = '{$class_num}' and class_time = '{$class_time}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql) ? FALSE : TRUE;
	}
	
	/*获取所有信息
	*
	*return array
	*/
	public function getAllAreaInfo($page){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	
	/*获取所有信息
	*
	*return array
	*/
	public function getAllAddBillInfo($page){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} where class_status = 'o' limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	
	/*获取所有信息
	*
	*return array
	*/
	public function getAllDeleteBillInfo($page){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} where class_status = 'f' limit {$start},{$length}";
		
		return $this->db_getAll($sql);
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
	
	/*
	 * 获取忙时状态的课室的所有记录
	* @return 返回状态为忙时的所有记录数量
	*/
	public function getAddBillPageCounts(){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_status = 'o'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	
	
	/*
	 * 获取忙时状态的课室的所有记录
	* @return 返回状态为空闲的所有记录数量
	*/
	public function getDeleteBillPageCounts(){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	
	
	/*通过ID获取所有场地信息
	*param1 string stu_id
	*return array
	*/
	public function getAllAreaInfoById($class_id){
		$sql = "select * from {$this->getTableName()} where class_id = '{$class_id}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*通过ID删除对应ID场地信息
	*param1 string stu_id
	*return array
	*/
	public function deleteAreaById($class_id){
		$sql = "delete from {$this->getTableName()}  where class_id = '{$class_id}' limit 1";
		return $this->db_delete($sql);
	}
	
	
	/*********#################################################################################################*/
	public function getAllAreaInfoToBill($page,$class_status){
		//组织SQL语句
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where class_status = '{$class_status}' limit {$start},{$length} ";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCountsToBill($class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_grade_name
	*param3 string stu_num
	*return array
	***********************************************************************************************************/
	public function getAreaByAll($build_name,$build_num,$class_num,$page,$class_status){
		//组织SQL语句
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' and class_status = '{$class_status}' limit {$start},{$length} ";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts0($build_name,$build_num,$class_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num =  '{$class_num}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_grade_name
	*return array
	*******************************************************************************************/
	public function getAreaByBuildNumAndClass($build_num,$class_num,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and class_num = '{$class_num}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts1($build_num,$class_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_num = '{$build_num}' and class_num =  '{$class_num}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_num
	*return array
	*/
	public function getAreaByBuildNameAndClass($build_name,$class_num,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and class_num = '{$class_num}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts2($build_name,$class_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and class_num =  '{$class_num}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*param2 string stu_num
	*return array
	*/
	public function getAreaByBuildNameAndBuildNum($build_name,$build_num,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts3($build_name,$build_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*return array
	*/
	public function getAreaByBuildName($build_name,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts4($build_name,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*return array
	*/
	public function getAreaByBuildNum($build_num,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts5($build_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where  build_num = '{$build_num}' and class_status = '{$class_status}' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_num
	*return array
	*/
	public function getAreaByClass($class_num,$page,$class_status){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where class_num = '{$class_num}' and class_status = '{$class_status}' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts6($class_num,$class_status){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_num =  '{$class_num}' and class_status = '{$class_status}'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*获取课室信息
	*return 成功返回数组，失败返回空数组
	*/
	//public function getAllClassInfo(){
	//	$sql = "select * from {$this->getTableName()} where class_status = 'o' ";
	//	return $this->db_getAll($sql);
	//}
	
	/*更新课室状态
	*@param1 string class_id
	*@return 成功返回受影响的行数，失败返回Flase
	*/
	public function updateClassStatusToFree($class_id){
		$sql = "update {$this->getTableName()} set class_status = 'f' where class_id = '{$class_id}' ";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*更新课室状态
	*@param1 string class_id
	*@return 成功返回受影响的行数，失败返回Flase
	*/
	public function updateClassStatusToOccupy($class_id){
		$sql = "update {$this->getTableName()} set class_status = 'o' where class_id = '{$class_id}' ";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/******************************************************************************************************************/
	//按条件查询块
	/*更新课室状态
	*param1 string $build_name,$build_num,$class_num,$class_time
	*return 成功返回受影响的行数，失败返回Flase
	*/
	public function updateClassStatusByAll($build_name,$build_num,$class_num,$class_time){
		$sql = "update {$this->getTableName()} set class_status = 'o' where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = {$class_num} and class_time = '{$class_time}' ";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	//按条件查询块user_center.php
	/*更新课室状态
	*param1 string $build_name,$build_num,$class_num,$class_time
	*return 成功返回受影响的行数，失败返回Flase
	*/
	public function updateClassStatusByInfo($build_name,$build_num,$class_num,$class_time){
		$sql = "update {$this->getTableName()} set class_status = 'f' where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = {$class_num} and class_time = '{$class_time}' ";
		//调用父类方法
		return $this->db_update($sql);
	}
	
	/*******从这开始******/
	/*area.php?act=query
	*方法内有七个查询对应条件的方法
	*方法内有七个对应条件的分页方法
	*@param1 build_name || build_num || class_num
	*@param2 page
	*@return array && string
	*/
	//所有的条件都填写，然后查询即 build_name && build_num && class_num不为空
	public function queryGetAreaByAll($build_name,$build_num,$class_num,$page){
		//组织SQL语句
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' and class_status = 'f' limit {$start},{$length} ";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts0($build_name,$build_num,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num =  '{$class_num}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_grade_name
	*return array
	
	2222222*******************************************************************************************/
	public function queryGetAreaByBuildNumAndClass($build_num,$class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and class_num = '{$class_num}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts1($build_num,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_num = '{$build_num}' and class_num =  '{$class_num}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*param2 string stu_num
	*return array
	*/
	public function queryGetAreaByBuildNameAndClass($build_name,$class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and class_num = '{$class_num}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts2($build_name,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and class_num =  '{$class_num}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*param2 string stu_num
	*return array
	*/
	public function queryGetAreaByBuildNameAndBuildNum($build_name,$build_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts3($build_name,$build_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*return array
	*/
	public function queryGetAreaByBuildName($build_name,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts4($build_name){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*return array
	*/
	public function queryGetAreaByBuildNum($build_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts5($build_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where  build_num = '{$build_num}' and class_status = 'f' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_num
	*return array
	*/
	public function queryGetAreaByClass($class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where class_num = '{$class_num}' and class_status = 'f' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function queryGetPageCounts6($class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_num =  '{$class_num}' and class_status = 'f'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/****到这里结束 area.php?act=query****/
}