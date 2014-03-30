<?php

@session_start();
 
class Staticpages extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    function howtouse(){
        $this->load->view('base/header',array('page'=>'howtouse'));
        $this->load->view('static/howtouse');
        $this->load->view('base/footer');
    }

    function compensate(){
        $this->load->view('base/header',array('page'=>'howtouse'));
        $this->load->view('static/compensate');
        $this->load->view('base/footer');
    }
}

?>
