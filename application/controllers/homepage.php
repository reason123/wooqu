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
        $this->load->view('base/header',array('page'=>'homenewnact','type'=>'newact'));
        $this->load->view('homepage/nav');
        $this->load->view('homepage/actnav');
        $this->load->view('base/footer');
    }
    
    public function newNormalAct(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','活动标题','required');
        $this->form_validation->set_rules('total','最大报名人数','required|numeric');
        $this->form_validation->set_rules('sign_start_date','报名开始时间','required');
        $this->form_validation->set_rules('sign_end_date','报名结束时间','required');
        $this->load->model('activity_model','act');
        $basetype_list = $this->act->getBaseType();
        $subtype_list = $this->act->getSubType(0);
        if($this->form_validation->run() == FALSE){$this->load->view('base/header',
                              array(
                                  'page'=>'newactivity',
                                  'status'=>'failed',
                                  'basetype_list'=>$basetype_list,
                                  'subtype_list'=>$subtype_list,
                                  'page'=>'homenewact',
                                  'type'=>'newact')
                              );
            $this->load->view('homepage/nav');
            $this->load->view('homepage/actnav');
            $this->load->view('homepage/newact');
            $this->load->view('base/footer');
        }else{
            if(!isset($_REQUEST['pic'])) $pic = null;
            else $pic = $_REQUEST['pic'];
            $check = 0;
            if(isset($_REQUEST['check']) && $_REQUEST['check'] == 'on'){
                $check = 1;
            }else{
                $check = 0;
            }
            $result = $this->act->addActivity($_REQUEST['act_start_date'],
                                              $_REQUEST['act_end_date'],
                                              $_REQUEST['sign_start_date'],
                                              $_REQUEST['sign_end_date'],
                                              $_REQUEST['address'],
                                              $_REQUEST['title'],
                                              $_REQUEST['detail'],
                                              $pic,
                                              $_REQUEST['total'],
                                              $_REQUEST['group_list'],
                                              $_REQUEST['baseType'],
                                              $_REQUEST['subType'],
                                              $check);
            $this->addPic($result['ID'],$_FILES['pic']);
            if($_REQUEST['baseType'] == 1){
                header('Location: /volunteer');
                return;
            }
            $this->load->view('base/header',array('page'=>'homenewact','type'=>'newact','basetype_list'=>$basetype_list,'subtype_list'=>$subtype_list));
            $this->load->view('homepage/nav');
            $this->load->view('homepage/actnav');
            $this->load->view('homepage/newact',array('status'=>'success'));
            $this->load->view('base/footer');
        }
    }
}
?>