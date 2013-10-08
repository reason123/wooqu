<?php

@session_start();
 
class Homepage extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    public function index(){        
        $this->load->model('groupfeed_model','feed');
        $news_list = $this->feed->getNewsList();
        $this->load->view('base/header',array('page'=>'newhome','type'=>'all'));
        $this->load->view('homepage/nav');
        $this->load->view('homepage/news',array('news_list'=>$news_list));
        $this->load->view('base/footer');
    }

    public function normal(){
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'normal'));
        $this->load->view('homepage/nav');
        $this->load->view('base/footer');
    }

    public function groupbuy(){
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'groupbuy'));
        $this->load->view('homepage/nav');
        $this->load->view('base/footer');
    }

    public function shop(){
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'shop'));
        $this->load->view('homepage/nav');
        $this->load->view('base/footer');
    }

    public function newAct(){
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'newact'));
        $this->load->view('homepage/nav');
        $this->load->view('base/footer');
    }
}
?>