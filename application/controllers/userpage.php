<?php
@session_start();

class UserPage extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

    function index(){
        $this->groupbuyOrder();
    }
    
	/**
	 * 水果订单页面
	 * @author Hewr
	 */
	function fruitOrder() {
        $this->load->view('base/mainnav',array('page'=>'fruitorder'));
        $this->load->view('userpage/header',array('header'=>'fruit'));
        $this->load->view('userpage/fruitOrder');
        $this->load->view('base/footer');
	}

	/**
	 * 团购订单页面
	 * @author Hewr
	 */
	function groupbuyOrder() {
        $this->load->view('base/mainnav',array('page'=>'groupbuyorder'));
        $this->load->view('userpage/header',array('header'=>'groupbuy'));
        $this->load->view('userpage/groupbuyOrder');
        $this->load->view('base/footer');
	}

	/**
	 * 我的报名页面
	 * @author Hewr ca007
	 */
	function myEnroll() {
        $this->load->model('activity_model','act');
        $signList = $this->act->getMySign();
        $this->load->view('base/mainnav',array('page'=>'myenroll'));
        $this->load->view('userpage/header',array('header'=>'enroll'));
        $this->load->view('userpage/myEnroll',array('signList'=>$signList));
        $this->load->view('base/footer');
	}

    /**
     * 我的群组
     * @author ca007
     */
    function myGroup(){
        $this->load->model('group_model','group');
        $groupList = $this->group->getMyGroupList();
        $this->load->view('base/mainnav',array('page'=>'myenroll'));
        $this->load->view('userpage/header',array('header'=>'group'));
        $this->load->view('userpage/mygroup',array('groupList'=>$groupList));
        $this->load->view('base/footer');
    }

	/**
	 * 个人信息页面
	 * @author Hewr ca007
	 */
	function myInfo() {
        $this->load->model('user_model','user');
        $userInfo = $this->user->getMyInfo();
        $this->load->view('base/mainnav',array('page'=>'userpage_myinfo'));
        $this->load->view('userpage/header',array('header'=>'userinfo'));
        $this->load->view('userpage/myInfo',array('userInfo'=>$userInfo));
        $this->load->view('base/footer');
	}

}

?>
