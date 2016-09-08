<?php
class Student extends DB{
	protected $table = 'student';
	
	/*�����û�
	*
	*
	*/
	public function addStudents($stu_num,$stu_name,$stu_pass,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level){
		
		$sql = "insert into {$this->getTableName()} values(null,'{$stu_num}','{$stu_name}','{$stu_pass}','{$stu_sex}','{$stu_coll_name}','{$stu_grade_name}','{$stu_email}','{$stu_level}')";
		
		//���ø��෽��
		return $this->db_insert($sql);
	}
	
	
	/*����û��Ƿ�����û�
	*@param1 string $num
	*return boolean �з���FALSE��û�з���TRUE
	*/
	public function editStudents($stu_num,$stu_name,$stu_sex,$stu_coll_name,$stu_grade_name,$stu_email,$stu_level){
		$sql = "update {$this->getTableName()} set stu_num = '{$stu_num}',stu_name = '{$stu_name}',stu_sex = '{$stu_sex}',stu_coll_name = '{$stu_coll_name}',stu_grade_name = '{$stu_grade_name}',stu_email = '{$stu_email}',stu_level = '{$stu_level}' where stu_num ='{$stu_num}'";
		//���ø��෽��
		return $this->db_update($sql);
	}
	
	/*����û��Ƿ�����û�
	*@param1 string $num
	*return boolean �з���FALSE��û�з���TRUE
	*/
	public function getUserNum($stu_num){
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit 1";
		//���ø��෽��
		return $this->db_getRow($sql) ? FALSE : TRUE;
	}
	
	/*��ȡ����ѧ����Ϣ
	*
	*return array
	*/
	public function getAllStudentInfo($page){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;

		$sql = "select * from {$this->getTableName()} limit {$start},{$length}";
		
		return $this->db_getAll($sql);
	}
	
	/*user_center.php
	*��ȡѧ����Ϣ
	*param1 string $stu_name
	*return array
	*/
	public function getStudentInfoByNum($stu_num){
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit 1";
		
		return $this->db_getRow($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts(){
			$sql = "select count(*) pagecounts from {$this->getTableName()}";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	
	
	/*ͨ��ID��ȡ����ѧ����Ϣ
	*param1 string stu_id
	*return array
	*/
	public function getAllUserInfoById($stu_id){
		$sql = "select * from {$this->getTableName()} where stu_id = '{$stu_id}' limit 1";
		//���ø��෽��
		return $this->db_getRow($sql);
	}
	
	/*ͨ��IDɾ����ӦIDѧ����Ϣ
	*param1 string stu_id
	*return array
	*/
	public function deleteUserById($stu_id){
		$sql = "delete from {$this->getTableName()}  where stu_id = '{$stu_id}' limit 1";
		return $this->db_delete($sql);
	}
	
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*@param1 string stu_coll_name
	*@param2 string stu_grade_name
	*@param3 string stu_num
	*@eturn array
	*/
	public function getUserByAll($page,$stu_coll_name,$stu_grade_name,$stu_num){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts0($stu_coll_name,$stu_grade_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_coll_name
	*param2 string stu_grade_name
	*return array
	*/
	public function getUserByCollAndGrade($page,$stu_coll_name,$stu_grade_name){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts1($stu_coll_name,$stu_grade_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_grade_name = '{$stu_grade_name}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_coll_name
	*param2 string stu_num
	*return array
	*/
	public function getUserByCollAndNum($page,$stu_coll_name,$stu_num){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts2($stu_coll_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_grade_name
	*param2 string stu_num
	*return array
	*/
	public function getUserByGradeAndNum($page,$stu_grade_name,$stu_num){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts3($stu_grade_name,$stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' and stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_grade_name
	*return array
	*/
	public function getUserByGrade($page,$stu_grade_name){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts4($stu_grade_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_grade_name = '{$stu_grade_name}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_coll_name
	*return array
	*/
	public function getUserByColl($page,$stu_coll_name){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts5($stu_coll_name){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where stu_coll_name = '{$stu_coll_name}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string stu_num
	*return array
	*/
	public function getUserByNum($page,$stu_num){
		//���limit����Ҫ����ʼλ�úͳ���
		$length = 16;
		$start  = ($page - 1) * $length;
		//��֯SQL���
		$sql = "select * from {$this->getTableName()} where stu_num = '{$stu_num}' limit {$start},{$length}";
		//���ø��෽��
		return $this->db_getAll($sql);
	}
	/*
	 * ��ȡ��ǰѧ�������м�¼
	 * @return ���ص�ǰ�����м�¼
	*/
		public function getPageCounts6($stu_num){
			$sql = "select count(*) pagecounts from {$this->getTableName()} where  stu_num = '{$stu_num}'";
			$res = $this->db_getRow($sql);
			//����
			return $res ? $res['pagecounts'] : false; 
		}
	
	/*
		 * ͨ���û�����������֤�û���Ϣ
		 * @param1 string $usernum���û��˺�
		 * @param2 string $password���û�����
		 * @return mixed���ɹ������û���Ϣ��ʧ�ܷ���FALSE
		*/
		public function checkStudentByNumAndPassword($usernum,$password){
			//��������
			$password = SHA1($password);

			//ת��
			$usernum = addslashes($usernum);

			//��֯SQL���
			$sql = "select * from {$this->getTableName()} where stu_num = '{$usernum}' and stu_pass = '{$password}'";

			//����DB���getRow����
			return $this->db_getRow($sql);
		}
		
	/*ͨ���û���д���������в�ѯѧ����Ϣ
	*param1 string new_password 
	*return �ɹ�������Ӱ��������ʧ�ܷ���FALSE
	*/
	public function updateStudentPass($new_password,$stu_id){
		//��֯SQL���
		$sql = "update {$this->getTableName()} set stu_pass = '{$new_password}' where stu_id = {$stu_id}";
		//���ø��෽��
		return $this->db_update($sql);
	}
	
	/*deal.php?act=deal
	 *ͨ���ʻ���ѧ������
	 *@param1 string $usernum
	 *@return �ɹ��������䣬ʧ�ܷ���FALSE
	*/
	public function getEmailByUserNum($usernum){
		$sql = "select stu_email from {$this->getTableName()} where stu_num = '{$usernum}' limit 1";
		//���ø��෽��
		return $this->db_getRow($sql);
	}
	
	/*ͨ���û�����ѧ������user_center.php?act=get_new_pass
	*param1 string $usernum
	*return �ɹ��������䣬ʧ�ܷ���FALSE
	*/
	public function getStudentEmailByNum($usernum){
		$sql = "select stu_email from {$this->getTableName()} where stu_num = '{$usernum}' limit 1";
		//���ø��෽��
		return $this->db_getRow($sql);
	}
	
	/*ͨ���û��˺��޸��û�����user_center.php?act=get_new_pass
	*param1 string $usernum
	*return �ɹ��������䣬ʧ�ܷ���FALSE
	*/
	public function updateStudentPassByNum($usernum,$stu_pass){
		$sql = "update {$this->getTableName()} set stu_pass = '{$stu_pass}' where stu_num = '{$usernum}'";
		//���ø��෽��
		return $this->db_update($sql);
	}
	
	/*home.privilege.php
	*��ȡ����ַ���
	*@param void
	*@return string
	*/
	function getRandChar(){
	$str = null;
	   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	   $max = strlen($strPol)-1;
	   for($i=0;$i<8;$i++){
		$str.=$strPol[rand(0,$max)];//rand($min,$max)���ɽ���min��max������֮���һ���������
	   }
	   return $str;
  }
}