<?php
@session_start();

class Feed extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function test()	{
        echo "test";
	}

    function initNewFeed(){
        $this->load->model('groupfeed_model', 'feed');
        $res = $this->feed->initNewFeed();
        echo json_encode($res);
    }

    function getNews(){
        $this->load->model('groupfeed_model','feed');
        echo json_encode($this->feed->getNewsListByType(0));
    }
}

?>