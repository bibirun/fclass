<?php
//文件上传类
class Upload{
	public static $errorInfo;
	
	/*
	 * 单文件上传
	 * @param1 array $file，上传的图片信息
	 * @param2 array $allow，允许上传的文件的MIME类型
	 * @param3 int $max，允许上传文件的最大限制
	 * @return mixed，文件上传成功后的路径（相对路径），失败返回FALSE
	*/
	public static function uploadSingle($file,$allow,$max){
		//判断文件是否合理
		if(!is_array($file)){
			//给出提示
			self::$errorInfo = '当前不是一个合法的文件信息！';
			//返回
			return FALSE;
		}

		//判断文件类型是否合法
		if(!in_array($file['type'],$allow)){
			//文件类型不符合
			self::$errorInfo = '当前文件类型不允许上传，允许的类型有：' . implode(',',$allow);

			return false;
		}
		
		//处理文件错误代码
			switch($file['error']){
				case 1:
					self::$errorInfo = '文件过大！已经超过服务器允许大小！';
					return false;
				case 2:
					self::$errorInfo = '文件过大！已经超过浏览器允许大小！';
					return false;
				case 3:
					self::$errorInfo = '文件上传不完整！';
					return false;
				case 4:
					self::$errorInfo = '没有选择要上传的文件！';
					return false;
				case 6:
					self::$errorInfo = '找不到服务器文件的临时目录！';
					return false;
				case 7:
					self::$errorInfo = '没有权限将文件上传到目标文件夹！';
					return false;
				case 0:
					//判断当前文件的大小是否在允许范围内
					if($file['size'] > $max){
						//超过当前商品上传文件的允许大小
						self::$errorInfo = '文件太大，当前商品只允许上传' . $max . '字节大小！';
						return false;
					}
			}
			
			//处理文件
			//获取新的文件名字
			$newname = self::getNewName($file['name']);
			if(move_uploaded_file($file['tmp_name'],ADMIN_UPL . '/' . $newname)){
				//成功
				return './uploads/' . $newname;
				//./uploads/20140910142828abcdef.gif
			}else{
				//失败
				self::$errorInfo = '文件移动失败！';
				return false;
			}
	}
	
		/*
		 * 生成文件名字
		 * @param1 string $filename，本身文件的名字
		 * @return string $newname，新的文件名字
		*/
		private static function getNewName($filename){
			//获取文件的后缀名
			$extension = substr($filename,strrpos($filename,'.'));

			//生成新名字
			$newname = date('YmdHis');

			//拼凑随机字符串
			$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			for($i = 0;$i < 6;$i++){
				$newname .= $str[mt_rand(0,strlen($str) - 1)];
			}

			//拼凑文件名
			return $newname . $extension;
		}
}