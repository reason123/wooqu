<?php

@session_start();
 
class Volunteer extends CI_Controller{
    function __construct(){
        parent::__construct();
        if(!isset($_SESSION['mcgroupID'])){
            $this->load->model('group_model','group');
            $group_list = $this->group->getMyManageGroup();
            if(count($group_list) == 0) return;
            $_SESSION['mcgroupList'] = $group_list;
            
            $_SESSION['mcgroupID'] = $group_list[0]['groupID'];
            $_SESSION['mcgroupName'] = $group_list[0]['class'];
        }
    }

    /**
     * 志愿首页 活动列表
     * @author ca007
     */
    function index(){
        $this->permission_model->checkBasePermission(BASE_VOLUNTEER_MANAGE);
        $this->load->model('activity_model','act');
        $volActList = $this->act->getVolAct();
        $statusList = array(0=>'未审核',
                            1=>'审核通过',
                            3=>'结项');
        $this->load->view('base/headervol',array('page'=>'volhome'));
        $this->load->view('volunteer/actlist',array('volActList'=>$volActList,'statusList'=>$statusList));
        $this->load->view('base/footer');
    }

    /**
     * 志愿群组列表
     * @author ca007
     */
    function grouplist(){
        $this->permission_model->checkBasePermission(BASE_VOLUNTEER_MANAGE);
        $this->load->model('group_model','group');
        $volGroupList = $this->group->getVolGroup();
        $this->load->view('base/headervol',array('page'=>'grouplist'));
        $this->load->view('volunteer/grouplist',array('volGroupList'=>$volGroupList));
        $this->load->view('base/footer');
    }

  	/**
     * 志愿者信息查询
     * @author LJNanest
     */
    function userCareer()
    {
    	$this->load->view('base/headervol',array('page'=>'volhome'));
        $this->load->model('volUserCareer_model','vUC');
        $userInfo = $this->vUC->getUserInfo($_GET["userID"]);
        $careerList = $this->vUC->getUserCareerList($_GET["userID"]);
        $honorList = $this->vUC->getUserHonorList($_GET["userID"]);
        $this->load->view('volunteer/userCareer',array('userInfo'=>$userInfo,'careerList'=>$careerList,'honorList'=>$honorList));
        $this->load->view('base/footer');
    }

    function test()
    {
    	$this->load->model('volUserCareer_model','vUC');
    	$tmp = $this->vUC->getUserHonorList(13);
    	//echo  $tmp;
    	echo json_encode($tmp);
    }
}
?>
