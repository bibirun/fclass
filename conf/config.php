<?php

	//配置文件
	return array(
		//数据库连接配置选项
		'mysql' =>array(
			'host' => 'localhost',
			'port' => '3306',
			'user' => 'root',
			'pass' => 'huangbo',
			'prefix' => 'cl_',
			'dbname' => 'booking',
			'charset' => 'utf8',
		),
		//后台图片上传允许上传的MIME类型
		'img_upload' => array(
			'image/gif',
			'image/pgif',
			'image/png',
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
		)

	);