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
	function sendMail_old($recvList, $title, $content) {
		require("page/phpmailer/class.phpmailer.php");

		$mail = new PHPMailer(); //建立邮件发送类
		$mail->IsSMTP(); // 使用SMTP方式发送
		$mail->Host = "smtp.exmail.qq.com"; // 您的企业邮局域名
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
	 * Send mails using mailbox for wooqu
	 * @author dreamszl
	 * @param string token
	 */
    function sendMail($recvList, $title, $content) {
        $mailList = array();
        foreach($recvList as $key => $mail){
            $mailList[] = $mail['mail'];
        }
        $mailList = array_values(array_unique($mailList));
        $url = 'http://localhost/user/getMyInfo';
        $res = myGet('166.111.135.69:3030/common/simple_mail',
                     array(
                           'html'=>$content,
                           'subject'=>$title,
                           'from'=>'contach@hellothu.com',
                           'fromname'=>'HelloTHU注册验证',
                           'tos'=>json_encode($mailList)
                           ));
        return true;
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
        return $this->sendMail(array(array("mail"=>$user["email"], "name"=>$user['loginName'])), 
                               "HelloTHU网邮箱验证",
                        urlencode('<p>尊敬的HelloTHU用户：<br/><br/>您申请将'.$user['email'].'设置为您的登录邮箱，要完成此操作，请在内点击以下链接进行确认：<br/><a href="'.$http_type.$_SERVER['HTTP_HOST']."/user/verifyEmail?token=".$token.'" target="_blank">'.$http_type.$_SERVER['HTTP_HOST']."/user/verifyEmail?token=".$token.'</a><br/>如果您点击上述链接，提示&ldquo;链接已过期&rdquo;，则请在用户中心重新发起登录邮箱的设置申请，感谢您的配合与支持！<br/><br/>（如非本人操作，请忽略此邮件）</p>')
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

    function gotomail($mail){
        $t=explode('@',$mail);
        $t=strtolower($t[1]);
        if($t=='163.com'){
            return 'mail.163.com';
        }else if($t=='vip.163.com'){
            return 'vip.163.com';
        }else if($t=='126.com'){
            return 'mail.126.com';
        }else if($t=='qq.com'||$t=='vip.qq.com'||$t=='foxmail.com'){
            return 'mail.qq.com';
        }else if($t=='gmail.com'){
            return 'mail.google.com';
        }else if($t=='sohu.com'){
            return 'mail.sohu.com';
        }else if($t=='tom.com'){
            return 'mail.tom.com';
        }else if($t=='vip.sina.com'){
            return 'vip.sina.com';
        }else if($t=='sina.com.cn'||$t=='sina.com'){
            return 'mail.sina.com.cn';
        }else if($t=='tom.com'){
            return 'mail.tom.com';
        }else if($t=='yahoo.com.cn'||$t=='yahoo.cn'){
            return 'mail.cn.yahoo.com';
        }else if($t=='tom.com'){
            return 'mail.tom.com';
        }else if($t=='yeah.net'){
            return 'www.yeah.net';
        }else if($t=='21cn.com'){
            return 'mail.21cn.com';
        }else if($t=='hotmail.com'){
            return 'www.hotmail.com';
        }else if($t=='sogou.com'){
            return 'mail.sogou.com';
        }else if($t=='188.com'){
            return 'www.188.com';
        }else if($t=='139.com'){
            return 'mail.10086.cn';
        }else if($t=='189.cn'){
            return 'webmail15.189.cn/webmail';
        }else if($t=='wo.com.cn'){
            return 'mail.wo.com.cn/smsmail';
        }else if($t=='139.com'){
            return 'mail.10086.cn';
        }else {
            return '';
        }
    }
}

?>
