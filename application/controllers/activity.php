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
     * 活动信息页面
     * @author ca007
     */
    function index(){
        $this->load->model('activity_model','act');
        $this->load->view('base/mainnav',array('page'=>'actmain'));
        $actInfo = $this->act->getActByID($_REQUEST['actID']);
        $this->load->view('activity/actmain',array('actInfo'=>$actInfo));
        $this->load->view('base/footer');
    }
    
    /**
     * 活动页面主要
     * @author ca007
     */
    function actmain(){
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
        if($this->form_validation->run() == FALSE){
          $this->load->view('base/mainnav',
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
            //echo($pic);
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
            $result = $this->act->modActivity($_REQUEST['actID'],
                                              $_REQUEST['act_start_date'],
                                              $_REQUEST['act_end_date'],
                                              $_REQUEST['sign_start_date'],
                                              $_REQUEST['sign_end_date'],
                                              $_REQUEST['address'],
                                              $_REQUEST['title'],
                                              $_REQUEST['detail'],
                                              $_REQUEST['total']);
            if($result['error']['code'] != 1){
                echo json_encode($result);
                return;
            }
            $this->load->view('base/mainnav',array('page'=>'newactivity'));
            $this->load->view('manager/activity/modact',array_merge(array('status'=>'success'),$result));
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
        if(isset($_SESSION['userID'])){
            $result = $this->act->signupact($_REQUEST['actID'],
                                            $_REQUEST['realName'],
                                            $_REQUEST['class'],
                                            $_REQUEST['phoneNumber'],
                                            $_REQUEST['studentID'],
                                            $_REQUEST['addon']);
        }else{
            $result = $this->act->an_signupact($_REQUEST['actID'],
                                            $_REQUEST['realName'],
                                            $_REQUEST['class'],
                                            $_REQUEST['phoneNumber'],
                                            $_REQUEST['studentID'],
                                            $_REQUEST['addon']);
        }
        echo json_encode($result);
    }
    
    /**
     * 取消报名
     * @author ca007
     */
    function delSign(){
        $this->load->model('activity_model', 'act');
        $result = $this->act->delSign($_REQUEST['signID']);
        echo json_encode($result);
    }

    /**
     * 取消报名表
     * @author ca007
     */
    function cancelForm(){
        $this->load->model('activity_model', 'act');
        $result = $this->act->cancelForm($_REQUEST['formID']);
        echo json_encode($result);
    }

    /**
     * 获取报名列表
     * @author ca007
     */
    function getsignlist(){
        $this->load->model('activity_model', 'act');
        $permissionCheck = $this->act->checkUserPermission($_REQUEST['actID']);
        if($permissionCheck['error']['code'] != 1){
            die($permissionCheck['error']['message']);
        }
        $sign_list = $this->act->getSignList($_REQUEST['actID']);
        $act_title = $this->act->actTitle($_REQUEST['actID']);
        $this->load->view('base/mainnav',array('page'=>'signlist'));
        $this->load->view('activity/signlist',array('sign_list'=>$sign_list, 'actTitle'=>$act_title));
        $this->load->view('base/footer');
    }

    /**
     * 获取报名表列表
     * @author ca007
     */
    function getformlist(){
        $this->load->model('activity_model', 'act');
        $permissionCheck = $this->act->checkUserPermission($_REQUEST['actID']);
        if($permissionCheck['error']['code'] != 1){
            die($permissionCheck['error']['message']);
        }
        $context = array();
        $context['page'] = 'getformlist';
        $context['title'] = $this->act->actTitle($_REQUEST['actID']);
        $res_form = $this->act->getActForm($_REQUEST['actID']);
        $context['s_form'] = json_decode($res_form['form_content'],true);
        $context['e_form_list'] = $this->act->getEFormList($_REQUEST['actID']);
        $this->load->view('base/header',$context);
        $this->load->view('activity/formlist');
        $this->load->view('base/footer');
    }

    /**
     * 报名表创建页面
     * @author ca007
     */
    function createForm(){
        $this->load->view('base/header',array('page'=>'formm'));
        $this->load->view('activity/formm');
        $this->load->view('base/footer');
    }

    /**
     * 创建报名表API
     * @author ca007
     */
    function addForm(){
        $this->load->model('activity_model','act');
        $res = $this->act->addForm($_REQUEST['actID'],
                                   $_REQUEST['content']);
        echo json_encode($res);
    }

    /**
     * 填写报名表页面
     * @author ca007
     */
    function completeForm(){
        $this->load->view('base/header',array('page'=>'completeform'));
        $this->load->model('activity_model','act');
        $context = array();
        $tmp = $this->act->getActForm($_REQUEST['actID']);
        if($tmp['error']['code'] == 1){
            $context['form_content'] = json_decode($tmp['form_content'],true);
        }else{
            $context['form_content'] = array();
        }
        $act = $this->act->getActByID($_REQUEST['actID']);
        $myFormInfo = $this->act->getMyFormInfo($_REQUEST['actID']);
        if(count($myFormInfo)){
            $context['myForm'] = json_decode($myFormInfo[0]['content'],true);
        }
        $context['title'] = $act['title'];
        $context['detail'] = $act['detail'];
        $this->load->view('activity/completeform',$context);
        $this->load->view('base/footer');
    }

    /**
     * 提交报名表API
     * @author ca007
     */
    function subForm(){
        $this->load->model('activity_model','act');
        $res = $this->act->subForm($_REQUEST['actID'],$_REQUEST['content']);
        echo json_encode($res);
    }

    function smsAct(){
        $this->load->model('activity_model','act');
        $sign_list = $this->act->getSignList($_REQUEST['actID']);
        $numList = array();
        foreach($sign_list as $key => $signInfo){
            $numList[] = $signInfo['phoneNumber'];
        }
        $this->load->model('sms_model','sms');
        $res = $this->sms->sendSms($numList,$_REQUEST['content']);
        echo json_encode($res);
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
        $this->load->model('activity_model','act');
        $actInfo = $this->act->getActByID($_REQUEST['actID']);
        $this->load->view('mobile/quicksign',array('actInfo'=>$actInfo));
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
