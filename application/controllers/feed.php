<?php
@session_start();

class Feed extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function test()	{
        $this->load->model('groupfeed_model','feed');
            //$this->feed->addFeedItem(0,'测试新鲜事',$_SESSION['userID'],nowTime(),'','呵呵呵','http://www.baidu.com',12,'test');
        $this->feed->sendFeed(0,12,'1000100000000');
	}

    function getNews(){
        $this->load->model('groupfeed_model','feed');
        echo json_encode($this->feed->getNewsListByType(0));
    }
}

?>