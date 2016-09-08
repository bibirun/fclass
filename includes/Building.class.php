<?php

class Building extends DB{
	//创建一个属性用于获取表名
	protected $table = 'building';
	
	/*
	 * 获取所有信息
	* @param1 int $page，当前要获取的页码
	* @return mixed，成功返回数组，失败返回FALSE
	*/
	function checkBuildingName($build_name){
		$sql = "select * from {$this->getTableName()} where build_name = '{$build_name}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*
	 * 获取所有信息
	* @param1 string $build_name，教学楼名字
	* @param2 string $build_pic 图片路径
	* @return 
	*/
	public function insertBuilding($build_name,$build_pic,$build_text){
		$sql = "insert into {$this->getTableName()} values (null,'{$build_name}','{$build_pic}','{$build_text}')";
		//调用父类方法
		return $this->db_insert($sql);
	}
	
	/*
	 * 获取所有信息
	* @param1 string $build_name，教学楼名字
	* @param2 string $build_pic 图片路径
	* @return 
	*/
	public function updateBuilding($build_name,$build_pic,$build_text,$build_id){
		$sql = "update {$this->getTableName()} set build_name = '{$build_name}',build_pic = '{$build_pic}',build_text = '{$build_text}' where build_id = '{$build_id}'";
		//调用父类方法
		return $this->db_update($sql);
		
	}
	
	/*user_center.php &&
	 * 获取所有教学楼信息
	 * @param1 string $build_id 教学楼名字
	* @return array
	*/
	public function getBuildingInfoById($build_id){
		$sql = "select * from {$this->getTableName()} where build_id = '{$build_id}' limit 1";
		//调用父类方法
		return $this->db_getRow($sql);
	}
	
	/*home.php
	 * 获取所有教学楼信息
	* @return array
	*/
	public function getAllBuildingInfos(){
		$sql = "select * from {$this->getTableName()}";
		//调用父类方法
		return $this->db_getAll($sql);
	}
	
	/*
	 * 获取所有教学楼信息
	 * @param1 string $build_id 教学楼名字
	* @return array
	*/
	
	public function deleteBuildingById($build_id){
		$sql = "delete from {$this->getTableName()} where build_id = '{$build_id}'";
		return $this->db_delete($sql);
	}
}