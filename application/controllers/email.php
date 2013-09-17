<?php

@session_start();
 
class Email extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    function index(){
        $this->load->helper('email');
        $send = mail('chenao3220@gmail.com','test_email','test');
        if($send){
            echo 'true';
        }else{
            echo 'false';
        }
    }

}
?>