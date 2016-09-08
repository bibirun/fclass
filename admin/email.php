<?php
header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
require 'class.phpmailer.php';
try {
	$mail = new PHPMailer(true); 
	$mail->IsSMTP();
	$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
	$mail->SMTPAuth   = true;                  //开启认证
	$mail->Port       = 25;                    
	$mail->Host       = "smtp.163.com"; //网易邮箱客户端
	$mail->Username   = "hb_lun";    //用户名称，不用带@163.com
	$mail->Password   = "cehsledfbibuaqqw";   //客户端密码         
	//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
	$mail->AddReplyTo("hb_lun@163.com","mckee");//回复地址
	$mail->From       = "hb_lun@163.com";
	$mail->FromName   = "hbl.com";
	$to = "$email";
	$mail->AddAddress($to);
	$mail->Subject  = "$subject";
	$mail->Body = "$bodyInfo";
	//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
	$mail->WordWrap   = 80; // 设置每行字符串的长度
	//$mail->AddAttachment("f:/test.png");  //可以添加附件
	$mail->IsHTML(true); 
	$mail->Send();
	//echo '';
	admin_redirect("$redirect",'邮件已发送',1);
} catch (phpmailerException $e) {
	echo "邮件发送失败：".$e->errorMessage();
}
?>