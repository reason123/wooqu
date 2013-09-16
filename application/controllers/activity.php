<?php

@session_start();
 
class Activity extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function test(){
        $this->load->model('activity_model','act');
        echo json_encode($this->act->getActList());
    }
    
    /**
     * 活动页面首页
     * @author ca007
     */
    function index(){
        $this->load->model('activity_model','act');
        $this->load->view('base/mainnav',array('page'=>'actmain'));
        $actList = $this->act->getActList();
        $this->load->view('activity/actmain',array('actlist'=>$actList));
        $this->load->view('base/footer');
    }

    /**
     * 新增活动页面
     * @author ca007
     */
    function newActivity(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','活动标题','required');
        $this->form_validation->set_rules('total','最大报名人数','required|numeric');
        $this->form_validation->set_rules('sign_start_date','报名开始时间','required');
        $this->form_validation->set_rules('sign_end_date','报名结束时间','required');
        $this->load->model('activity_model','act');
        $basetype_list = $this->act->getBaseType();
        $subtype_list = $this->act->getSubType(0);
        if($this->form_validation->run() == FALSE){$this->load->view('base/mainnav',
                              array(
                                  'page'=>'newactivity',
                                  'status'=>'failed',
                                  'basetype_list'=>$basetype_list,
                                  'subtype_list'=>$subtype_list)
                              );
            $this->load->view('manager/activity/addact');
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
            $this->load->view('base/mainnav',array('page'=>'newactivity','basetype_list'=>$basetype_list,'subtype_list'=>$subtype_list));
            $this->load->view('manager/activity/addact',array('status'=>'success'));
            $this->load->view('base/footer');
        }
    }
    
    /**
     * 修改活动页面
     * @author ca007
     */
    function modActivity(){
        $this->permission_model->checkManage($_SESSION['mcgroupID']);
        $this->load->model('activity_model','act');
        $this->act->checkUserPermission($_REQUEST['actID']);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','活动标题','required');
        $this->form_validation->set_rules('total','最大报名人数','required|numeric');
        $this->form_validation->set_rules('sign_start_date','报名开始时间','required');
        $this->form_validation->set_rules('sign_end_date','报名结束时间','required');
        $actInfo = $this->act->getActByID($_REQUEST['actID']);
        if($this->form_validation->run() == FALSE){
            $this->load->view('base/mainnav',array('page'=>'newactivity','status'=>'failed'));
            $this->load->view('manager/activity/modact',$actInfo);
            $this->load->view('base/footer');
        }else{
            $result = $this->act->modActivity($_REQUEST['act_start_date'],
                                              $_REQUEST['act_end_date'],
                                              $_REQUEST['sign_start_date'],
                                              $_REQUEST['sign_end_date'],
                                              $_REQUEST['address'],
                                              $_REQUEST['title'],
                                              $_REQUEST['detail'],
                                              $_REQUEST['total']);
            if($result['code'] != 1){
                
            }
            $this->load->view('base/mainnav',array('page'=>'newactivity'));
            $this->load->view('manager/activity/modact',array_merge(array('status'=>'success'),$actInfo));
            $this->load->view('base/footer');
        }
    }
    
    /**
     * 新增活动API
     * @authro ca007
     * @return json $errorMessage
     */
    function addActivity(){
        if (!isset($_SESSION['userID'])) {
			echo json_encode(errorMessage(-1,'未登录'));
            return ;
		}

        $this->load->model('activity_model','act');
        $result = $this->act->addActivity($_REQUEST['act_start_date'],
                                          $_REQUEST['act_end_date'],
                                          $_REQUEST['sign_start_date'],
                                          $_REQUEST['sign_end_date'],
                                          $_REQUEST['address'],
                                          $_REQUEST['title'],
                                          $_REQUEST['detail'],
                                          $_REQUEST['pic'],
                                          $_REQUEST['type'],
                                          $_REQUEST['total'],
                                          $_REQUEST['group_list']);
        echo json_encode($result);
    }

    /**
     * 报名活动
     * @author ca007
     */
    function signupact(){
//      if (!isset($_SESSION['userID'])) {
//			echo json_encode(errorMessage(-1,'未登录'));
//          return ;
//		}
        $this->load->model('activity_model', 'act');
        $result = $this->act->signupact($_REQUEST['actID'],
                                        $_REQUEST['realName'],
                                        $_REQUEST['class'],
                                        $_REQUEST['phoneNumber'],
                                        $_REQUEST['studentID'],
                                        $_REQUEST['addon']);
        echo json_encode($result);
    }

    /**
     * 获取报名列表
     * @author ca007
     */
    function getsignlist(){
        $this->load->model('activity_model', 'act');
        $permissionCheck = $this->act->checkUserPermission($_REQUEST['actID']);
        if($permissionCheck['code'] != 1){
            die('No permissions.');
        }
        $sign_list = $this->act->getSignList($_REQUEST['actID']);
        $act_title = $this->act->actTitle($_REQUEST['actID']);
        $this->load->view('base/mainnav',array('page'=>'signlist'));
        $this->load->view('activity/signlist',array('sign_list'=>$sign_list, 'actTitle'=>$act_title));
        $this->load->view('base/footer');
    }

    function smsAct(){
        $this->load->model('activity_model','act');
        $sign_list = $this->act->getSignList($_REQUEST['actID']);
        $numList = array();
        foreach($sign_list as $key => $signInfo){
            $numList[] = $signInfo['phoneNumber'];
        }
        $this->load->model('sms_model','sms');
        $this->sms->sendSms($numList,$_REQUEST['content']);
        echo json_encode(errorMessage(1,'发送成功'));
    }
    
    /**
     * 获取活动标题
     * @author ca007
     */
    function actTitle(){
        $this->load->model('activity_model','act');
        echo json_encode($this->act->actTitle($_REQUEST['actID']));
    }

    /**
     * 快速报名
     * @author ca007
     */
    function quickSign(){
        $this->load->view('base/headermobi',array('page'=>'quicksign'));
        $this->load->view('mobile/quicksign');
        $this->load->view('base/footermobi');
    }

    /**
     * 快速报名成功
     * @author ca007
     */
    function signsuc(){
        $this->load->view('base/headermobi',array('page'=>'signsuc'));
        $this->load->view('mobile/signsuc');
        $this->load->view('base/footermobi');
    }

    /**
     * 获取子类型
     * @author ca007
     */
    function getSubType(){
        $this->load->model('activity_model', 'act');
        echo json_encode($this->act->getSubType($_REQUEST['baseType']));
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
}

?>