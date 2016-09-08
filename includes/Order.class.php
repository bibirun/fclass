<?php
//新建Order类继承DB类
class Order extends DB{
	protected $table = 'order';
	
	/*增加订单
	*@param1
	*return 成功返回受影响的行数，失败返回FALSE
	*/
	public function insertUserInfoToOrder($build_name,$build_num,$class_num,$class_type,$class_time,$order_date,$username,$usernum){
		
		$sql = "insert into {$this->getTableName()} values(null,'{$build_name}','{$build_num}','{$class_num}','{$class_type}','{$class_time}','{$order_date}','{$username}',default,default,default,'{$usernum}')";
		
		//调用父类方法
		return $this->db_insert($sql);
	}
	
	/*通过用户填写的条件进行查询学生信息
	*@param1 string stu_num
	*@return array
	*deal_order.php?act=deal
	*/
	public function getAllInfoFromOrder($page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()}  where order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	//deal_order.php?act=deal
	public function getPageCountsToDeal(){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where order_status = 'on' and time_out = 'no'";
		$res = $this->db_getRow($sql);
		//返回总记录数
		return $res ? $res['pagecounts'] : false; 
	}
	/*
	 * 获取当前学生的所有记录
	 * @return 返回当前的所有记录
	*/
	public function getPageCounts(){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where order_status = 'on'";
		$res = $this->db_getRow($sql);
		//返回总记录数
		return $res ? $res['pagecounts'] : false; 
	}
	/*deal_order.php?act=deal && reject
	 * 通过Order_id获取用户名，
	 * @return 返回对应ID的用户名
	*/
	public function getUserNumByOrderId($order_id){
		$sql = "select * from {$this->getTableName()} where order_id = '{$order_id}'";
		return $this->db_getRow($sql);
	}
	
	/*deal.php?act=pass
	 * 通过Order_id更新审批预约的状态，
	 * @return 成功返回受影响的行数，失败返回FALSE
	*/
	public function updateOrderStatusResult($order_id){
		$sql = "update  {$this->getTableName()}  set order_status = 'off',order_result = 'pass' where order_id = '{$order_id}'";
		return $this->db_update($sql);
	}
	
	/*deal.php?act=reject
	 * 通过Order_id更新审批预约的状态，
	 * @return 成功返回受影响的行数，失败返回FALSE
	*/
	public function updateOrderStatusOff($order_id){
		$sql = "update  {$this->getTableName()}  set order_status = 'off' where order_id = '{$order_id}'";
		return $this->db_update($sql);
	}
	/*user_center.php?act=unsubscribe
	 * 通过Order_id更新审批预约的状态，
	 * @return 成功返回受影响的行数，失败返回FALSE
	*/
	public function updateOrderResultToReject($order_id){
		$sql = "update  {$this->getTableName()}  set order_result = 'reject' where order_id = {$order_id}";
		return $this->db_update($sql);
	}
	
	/*user_center.php?act=booking-info
	 * 通过Order_id更新审批预约的状态，
	* @return 成功返回受影响的行数，失败返回FALSE
	*/
	public function getUserOrderInfo($order_usernum,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where order_usernum = '{$order_usernum}' and  order_status = 'off' and order_result = 'pass' and time_out = 'no' limit {$start},{$length}";
		return $this->db_getAll($sql);
	}
	/*user_center.php?act=booking-info
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCountsOrder($order_usernum){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where order_usernum = '{$order_usernum}' and  order_status = 'off' and order_result = 'pass' and time_out = 'no'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*user_center.php?act=booking-record
	 * 通过Order_id更新审批预约的状态，
	* @return 成功返回受影响的行数，失败返回FALSE
	*/
	public function getUserOrderPassInfo($order_usernum,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where order_usernum = '{$order_usernum}' and  order_status = 'off' and order_result = 'pass' and TO_DAYS(NOW())>TO_DAYS(order_date) limit {$start},{$length}";
		return $this->db_getAll($sql);
	}
	/*user_center.php?act=booking-record
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCountsOrderPass($order_usernum){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where order_usernum = '{$order_usernum}' and  order_status = 'off' and order_result = 'pass' and TO_DAYS(NOW())> TO_DAYS(order_date)";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	
	/*
	 * 获取当前order表对应ID的课室信息
	* @return 返回当前的所有记录，失败返回空数组
	*/
	public function getClassInfoById($order_id){
		$sql = "select *  from {$this->getTableName()} where order_id = '{$order_id}'";
		return $this->db_getRow($sql);
	}
	
	/*user_center.php?act=booking-info
	 * 获取对应ID的time_out为yes
	* @return 返回受影响行数，失败返回FALSE
	*/
	public function updateTimeOutToYes($order_id){
		$sql = "update {$this->getTableName()} set time_out = 'yes' where order_id = '{$order_id}'";
		return $this->db_update($sql);
	}
	
	/***查询块在这里开始****/
	/***查询块在这里开始****/
	/***查询块在这里开始****/
	
	/*deal_order.php?act=query
	*用户在预约审批页面使用查询
	*@param build_name || build_num || class_num
	*@return array
	*/
	public function getAreaByAll($build_name,$build_num,$class_num,$page,$class_status){
		//组织SQL语句
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length} ";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts0($build_name,$build_num,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num =  '{$class_num}' and order_status = 'on' and time_out = 'no'";
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
	public function getAreaByBuildNumAndClass($build_num,$class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and class_num = '{$class_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts1($build_num,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_num = '{$build_num}' and class_num =  '{$class_num}' and order_status = 'on' and time_out = 'no'";
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
	public function getAreaByBuildNameAndClass($build_name,$class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and class_num = '{$class_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts2($build_name,$class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and class_num =  '{$class_num}' and order_status = 'on' and time_out = 'no' ";
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
	public function getAreaByBuildNameAndBuildNum($build_name,$build_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts3($build_name,$build_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and order_status = 'on' and time_out = 'no' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_grade_name
	*return array
	*/
	public function getAreaByBuildName($build_name,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts4($build_name){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and order_status = 'on' and time_out = 'no'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_coll_name
	*return array
	*/
	public function getAreaByBuildNum($build_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where build_num = '{$build_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts5($build_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where  build_num = '{$build_num}' and order_status = 'on' and time_out = 'no'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/*************************************************************************************************************
	/*通过用户填写的条件进行查询学生信息
	*param1 string stu_num
	*return array
	*/
	public function getAreaByClass($class_num,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		//组织SQL语句
		$sql = "select * from {$this->getTableName()} where class_num = '{$class_num}' and order_status = 'on' and time_out = 'no' limit {$start},{$length}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	/*
	 * 获取当前学生的所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts6($class_num){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where class_num =  '{$class_num}' and order_status = 'on' and time_out = 'no'";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	/***查询块在这里结束****/
	/***查询块在这里结束****/
	/***查询块在这里结束****/
	
	/*bill.php?act=confirm
	 *检查用户在这天内是否已经有预约记录
	 *@param1 string order_usernum
	 *@param2 string order_username
	 *@return bool
	*/
	public function checkUserOrTwoTime($order_username,$order_usernum){
		$sql = "select * from {$this->getTableName()} where order_username = '{$order_username}' and order_usernum = '{$order_usernum}' and order_status = 'off' and order_result = 'pass' and time_out = 'no' and TO_DAYS(NOW()) = TO_DAYS(order_date) limit 1";
		$order_date = $this->db_getRow($sql);
		return $order_date ? true : false;
	}
	
	/*获取已通过审批并且time_out=yes,的记录到历史记录
	*booking.php act=bill-history
	*@param  int page
	*@return array
	*/
	public function getHistoryInfo($page){
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where order_status = 'off' and order_result = 'pass' and time_out = 'yes' order by order_date desc  limit {$start},{$length} ";
		return $this->db_getAll($sql);
	}
	/*
	 * 获取order_status=off,order_result=pass,time_out=yes的所有记录
	* @return 返回当前的所有记录
	*/
	public function getHistoryPageCounts(){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where order_status = 'off' and order_result = 'pass' and time_out = 'yes' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
	
	/*获取已通过审批并且time_out=yes,的记录到历史记录
	*booking.php act=history-query
	*@param  int page
	*@param string build_name,build_num,class_num,order_date
	*@return array
	*/
	public function getHistoryRecordByQuery($build_name,$build_num,$class_num,$order_date,$page){
		$length = 16;
		$start  = ($page - 1) * $length;
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' and TO_DAYS(order_date) = TO_DAYS('{$order_date}') and order_status = 'off' and order_result = 'pass' and time_out = 'yes' order by order_date desc  limit {$start},{$length} ";
		return $this->db_getAll($sql);
	}
	/*
	*booking.php act=history-query
	* 获取order_status=off,order_result=pass,time_out=yes的所有记录
	*@param string build_name,build_num,class_num,order_date
	* @return 返回当前的所有记录
	*/
	public function getHistoryRecordByQueryPageCounts($build_name,$build_num,$class_num,$order_date){
		$sql = "select count(*) pagecounts from {$this->getTableName()} where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' and TO_DAYS(order_date) = TO_DAYS('{$order_date}') and order_status = 'off' and order_result = 'pass' and time_out = 'yes' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
}