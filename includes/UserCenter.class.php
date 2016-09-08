<?php
//新建一个UserCenter类继承DB类
class UserCenter extends DB{
	
	/*获取所有信息
	*
	*return array
	*/
	public function getAllAreaInfo($page,$build_name,$build_num,$class_num){
		//求出limit所需要的起始位置和长度
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from cl_class where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	
	/*获取所有信息
	*return array
	* 获取当前场地所有记录
	* @return 返回当前的所有记录
	*/
	public function getPageCounts($build_name,$build_num,$class_num){
		$sql = "select count(*) pagecounts from cl_class where build_name = '{$build_name}' and build_num = '{$build_num}' and class_num = '{$class_num}' ";
		$res = $this->db_getRow($sql);
		//返回
		return $res ? $res['pagecounts'] : false; 
	}
}