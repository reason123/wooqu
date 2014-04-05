<?php
@session_start();

class Sms extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

    function sendSms()
    {
        $numList = json_decode($_POST['phoneList'],true);
        $this->load->model('sms_model','sms');
        $res = $this->sms->sendSms($numList,$_REQUEST['content']);
		echo json_encode($res);
    }
}

?>
