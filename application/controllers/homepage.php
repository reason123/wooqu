<?php

@session_start();
 
class Homepage extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    public function index(){
        $this->all();
    }
    
    public function all(){        
        $this->load->model('groupfeed_model','feed');
        $news_list = $this->feed->getNewsList();
        $this->load->view('base/header_v2',array('page'=>'homeall','type'=>'all'));
        //$this->load->view('homepage/nav');
        $this->load->view('homepage/news',array('news_list'=>$news_list));
        $this->load->view('base/footer');
    }

    public function normal(){
        $this->load->model('groupfeed_model','feed');
        $news_list = $this->feed->getNewsListByType(0);
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'normal'));
        $this->load->view('homepage/nav');
        $this->load->view('homepage/news',array('news_list'=>$news_list));
        $this->load->view('base/footer');
    }

    public function groupbuy(){
        $this->load->model('groupfeed_model','feed');
        $news_list = $this->feed->getNewsListByType(1);
        $this->load->view('base/header',array('page'=>'homegroupbuy','type'=>'groupbuy'));
        $this->load->view('homepage/nav');
        $this->load->view('homepage/news',array('news_list'=>$news_list));
        $this->load->view('base/footer');
    }

    public function shop(){
        $this->load->model('groupfeed_model','feed');
        $news_list = $this->feed->getNewsListByType(2);
        $this->load->view('base/header',array('page'=>'homenormal','type'=>'shop'));
        $this->load->view('homepage/nav');
        $this->load->view('homepage/news',array('news_list'=>$news_list));
        $this->load->view('base/footer');
    }

    public function newAct(){
        $this->load->view('base/header',array('page'=>'homenewnact','type'=>'newact','actType'=>'null'));
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
                                  'page'=>'newnact',
                                  'status'=>'failed',
                                  'basetype_list'=>$basetype_list,
                                  'subtype_list'=>$subtype_list,
                                  'actType'=>'normal',
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
            $result = $this->act->addActivity(cleanString($_REQUEST['act_start_date']),
                                              cleanString($_REQUEST['act_end_date']),
                                              cleanString($_REQUEST['sign_start_date']),
                                              cleanString($_REQUEST['sign_end_date']),
                                              cleanString($_REQUEST['address']),
                                              cleanString($_REQUEST['title']),
                                              cleanString($_REQUEST['detail']),
                                              $pic,
                                              cleanString($_REQUEST['total']),
                                              cleanString($_REQUEST['group_list']),
                                              cleanString($_REQUEST['baseType']),
                                              cleanString($_REQUEST['subType']),
                                              $check);
            $this->addPic($result['ID'],$_FILES['pic']);
            if($_REQUEST['baseType'] == 1){
                header('Location: /volunteer');
                return;
            }else if($_REQUEST['subType'] == 3 && $_REQUEST['baseType'] == 0){
                header('Location: /activity/createForm?actID='.$result['ID']);
                return;
            }
            $this->load->view('base/header',array('page'=>'newnact','type'=>'newact','basetype_list'=>$basetype_list,'actType'=>'normal','subtype_list'=>$subtype_list));
            $this->load->view('homepage/nav');
            $this->load->view('homepage/actnav');
            $this->load->view('homepage/newact',array('status'=>'success'));
            $this->load->view('base/footer');
        }
    }

    /**
     * 新增团购活动
     * @author ca007
     */
    function newGroupbuy(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','title','required'); 
        $this->form_validation->set_rules('howtopay','howtopay','required'); 
        $this->form_validation->set_rules('source','source','required'); 
        $this->form_validation->set_rules('comment','comment','required'); 
        $this->form_validation->set_rules('illustration','illustration','required'); 
        $this->load->model('groupbuy_model','groupbuy');
        if($this->form_validation->run() == FALSE){
          $this->load->view('base/header',array('page'=>'newgroupbuy','type'=>'newact','actType'=>'groupbuy'));
          $this->load->view('homepage/nav');
          $this->load->view('homepage/actnav');
          //$this->load->view('base/mainnav',array('page'=>'newgroupbuy'));
          $this->load->view('homepage/newgroupbuy');
          $this->load->view('base/footer');
        }else{          
          $shop = array(
              "title"=>cleanString($_REQUEST['title']),
              "status"=>"1",
              "comment"=>cleanString($_REQUEST['comment']),
              "howtopay"=>cleanString($_REQUEST['howtopay']),
              "illustration"=>cleanString($_REQUEST['illustration']),
              "deadline"=>cleanString($_REQUEST['act_end_date']),
              "pickuptime"=>cleanString($_REQUEST['sign_end_date']), 
              "source"=>cleanString($_REQUEST['source']),
              "group_list"=>cleanString($_REQUEST['group_list']));

          $groupbuyID = $this->groupbuy->insertShop($shop,$_SESSION['loginName']);
          $this->addGroupbuyPic($groupbuyID, $_FILES['pic']);
          header('Location: /groupbuy/selectGoods?id='.$groupbuyID);          
        }
    }
    
	/**
	 * 团购修改页面
	 * @author Hewr
	 */
    function groupbuy_modify() {
        $this->load->view('base/header',array('page'=>'groupbuy_manager_modify','type'=>'newact','actType'=>'groupbuy'));
		if (!isset($_GET["id"])) exit(0);
        $this->load->view('homepage/nav');
        $this->load->view('homepage/actnav');
		$this->load->view("manager/groupbuy/groupbuy_modify", array("id" => $_GET["id"]));
		$this->load->view("base/footer");
    }
    
    /**
     * 为活动添加图片
     * @author ca007
     */
    function addPic($actID,$pic){
        $picType = explode('/',$pic['type']);
        if ((($pic["type"] == "image/gif")
             || ($pic["type"] == "image/jpeg")
             || ($pic["type"] == "image/pjpeg"))
            && ($pic["size"] < 200000)){
            move_uploaded_file($pic['tmp_name'],'./storage/act_'.$actID.'.jpeg');
        }
    }

    /**
     * 为团购添加图片
     * @author ca007
     */
    function addGroupbuyPic($gbID, $pic){
        $picType = explode('/',$pic['type']);
        if ((($pic["type"] == "image/gif")
             || ($pic["type"] == "image/jpeg")
             || ($pic["type"] == "image/pjpeg"))
            && ($pic["size"] < 200000)){
            move_uploaded_file($pic['tmp_name'],'./storage/groupbuyPic/pic_'.$gbID.'.jpg');
        }
    }
}
?>
