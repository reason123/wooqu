<?php
@session_start();

class email extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
    
    function bundling()
    {
        $this->load->model('user_model','user');
        $myInfo = $this->user->getMyInfo();
        $this->user->modMyInfo($myInfo['nickName'],$myInfo['phoneNumber'],$myInfo['studentID'],$_POST['email'],$myInfo['address']);
        $this->load->model('email_model','email');
        $tmp = $this->email->sendVerification();
        $url = $this->email->gotomail($_POST['email']);
		$ret = array( "content"=>"已发送成功！点击确认转跳到您的邮箱", "error"=>"", "href"=>$url );
        echo json_encode($ret);
    }
    
}

?>
