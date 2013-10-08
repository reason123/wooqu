<?php
@session_start();

class Feed extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function test()
	{
	//	$this->load->model('groupFeed_model','feed');
		//$this->feed->addNews("test","test!");
	//	echo json_encode($this->feed->getNewsList());
 		//echo $this->feed->getNewsList();
	}
	
}

?>