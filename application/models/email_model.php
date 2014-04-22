<?php

class email_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }

    /**
     * 检查邮箱是否已经经过验证
     * @author Hewr
     */
    function isVerified(){
        $sql = "select email, veri_email from user_list where ID=?";
        $tmp = $this->db->query($sql, array($_SESSION['userID']))->result_array();
		$user = $tmp[0];
		return (strcmp($user["email"], $user["veri_email"]) == 0);
    }

	/**
	 * 发送邮箱
	 * @author Hewr
	 * @param array(array(mail, name)) 接收者列表
	 * @param string 标题
	 * @param string 正文
	 */
	function sendMail($recvList, $title, $content) {
		require("page/phpmailer/class.phpmailer.php");

		$mail = new PHPMailer(); //建立邮件发送类
		$mail->IsSMTP(); // 使用SMTP方式发送
		$mail->Host = "smtp.foxmail.com"; // 您的企业邮局域名
		$mail->Port = 465;
		$mail->SMTPAuth = true; // 启用SMTP验证功能
		$mail->SMTPSecure = 'ssl';
		$mail->Username = "hellothu@foxmail.com"; // 邮局用户名(请填写完整的email地址)
		$mail->Password = "haluotuangou"; // 邮局密码

		$mail->From = "hellothu@foxmail.com"; //邮件发送者email地址
		$mail->FromName = "hellothu网管理员";
		//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
		foreach ($recvList as $index => $item) {
			$mail->AddAddress($item["mail"], $item["name"]);
		}
		//$mail->AddReplyTo("", "");

		//$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
		//$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式

		$mail->CharSet = "UTF-8";
		$mail->Subject = $title; //邮件标题
		$mail->Body = $content; //邮件内容
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略

		return $mail->Send();
	}

	/**
	 * 发送验证邮箱邮件
	 * @author Hewr
	 */
	function sendVerification() {
		if ($this->isVerified()) return;

		// 生成验证码
        $sql = "select loginName, email from user_list where ID=?";
        $tmp = $this->db->query($sql, array($_SESSION['userID']))->result_array();
		$user = $tmp[0];
		$user["regTime"] = time();
		$token = md5($user["loginName"].$user["regTime"]);
		$expire_time = $user["regTime"] + 60 * 60 * 24;
		$this->db->insert('email_verification',array(
			"userID"=>$_SESSION["userID"], 
			"email"=>$user["email"], 
			"token"=>$token,
			"expire_time"=>$expire_time
		));

		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) 
			&& $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://'; 

		return $this->sendMail(array(array("mail"=>"ljnanest@gmail.com", "name"=>"LJN")), 
			"hellothu网邮箱验证", 
			$http_type.$_SERVER['HTTP_HOST']."/user/verifyEmail?token=".$token
		);
	}

	/**
	 * 验证邮箱
	 * @author Hewr
	 * @param string token
	 */
	function verify($token) {
        $sql = "select userID, email, expire_time from email_verification where token=?";
        $tmp = $this->db->query($sql, array($token))->result_array();
		if (count($tmp) == 0) {
			return errorMessage(-1, "未定义验证");
		}
		$list = $tmp[0];

		if (time() > $list["expire_time"]) {
			return errorMessage(-1, "超过验证时间，请重新验证");
		}

        $userInfo = array('veri_email'=> cleanString($list["email"]));
        $this->db->where('ID',$list["userID"])->update('user_list',$userInfo);

		$this->db->delete('email_verification', array('token' => $token)); 

		return errorMessage(1, "成功验证！");
	}

}

?>
