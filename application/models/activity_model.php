<?php

class activity_model extends CI_Model{
    const UNEXAMINED = -1;
    const PASS = 1;
    
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /**
     * 新增活动
     * @author ca007
     * @param timestamp $act_start_date 活动开始时间
     * @param timestamp $act_end_date 活动结束时间
     * @param timestamp $sign_start_date 报名开始时间
     * @param timestamp $sign_end_date 报名结束时间
     * @param string $address 地址
     * @param stirng $title 活动标题
     * @param string $detail 活动简介
     * @param string $pic 活动图片地址
     * @param int $total 总数
     * @param int $baseType 基本活动类型（0: normal 1: volunteer）
     * @param int $subType 子活动类型（0: normal 0.1 normal with sign form）
     * @param int $check 报名是否需要审核
     */
    function addActivity($act_start_date,
                         $act_end_date,
                         $sign_start_date,
                         $sign_end_date,
                         $address,
                         $title,
                         $detail,
                         $pic,
//                         $state,
                         $total,
                         $group_list,
                         $baseType,
                         $subType,
                         $check) {
        $newAct = array(
            'act_start_date'=>$act_start_date,
            'act_end_date'=>$act_end_date,
            'sign_start_date'=>$sign_start_date,
            'sign_end_date'=>$sign_end_date,
            'address'=>$address,
            'title'=>$title,
            'detail'=>$detail,
            'userID'=>$_SESSION['userID'],
            'pic'=>$pic,
            'total'=>$total,
            'nowTotal'=>0,
            'status'=>0,
            'baseType'=>$baseType,
            'subType'=>$subType,
            'check'=>$check);
        $this->load->model('groupfeed_model','feed');
        $this->db->insert('activity_list', $newAct);
        $actID = $this->db->insert_id();
        if($baseType == 0 && $subType == 3){
            $url = '/activity/completeform?actID='.$actID;
        }else if($baseType == 0 && $subType == 2){
            $url = '/activity?actID='.$actID;
        }
        $this->feed->addFeedItem(0,
                                 $title,
                                 $_SESSION['userID'],
                                 nowTime(),
                                 '/storage/act_'.$actID.'.jpeg',
                                 substr($detail,0,40),
                                 $url,
                                 $actID,
                                 '{}');
        $groupList = explode(';',$group_list);
/*        foreach($groupList as $key => $groupID){
            if(!isGID($groupID)) continue;
            $this->permission_model->checkPermission($groupID, MANAGE_ACTIVITY);
            }*/
        foreach($groupList as $key => $groupID){
            if(!isGID($groupID)) continue;
            $this->db->insert('group_act', array('actID'=>$actID,'groupID'=>$groupID,'state'=>1));
            if($this->permission_model->manageGroup($groupID)){
                $this->feed->sendFeed(0,$actID,$groupID,1);
            }else{
                $this->feed->sendFeed(0,$actID,$groupID,0);
            }
        }
        return array_merge(errorMessage(1, '活动添加成功'),array('ID'=>$actID));
    }

    /**
     * 添加报名表
     * @author ca007
     * @param int $actID
     * @param string $content
     */
    function addForm($actID, $content){
        $tmp = $this->db->from('activity_list')->where('ID',$actID)->get()->result_array();
        if(count($tmp) == 0){
            return errorMessage(-1,'No such activity');
        }else if($tmp[0]['userID'] != $_SESSION['userID']){
            return errorMessage(-10, 'No permission');
        }
        $newForm = array(
            'userID'=>$_SESSION['userID'],
            'content'=>$content,
            'actID'=>$actID);
        $this->db->insert('s_form', $newForm);
        $formID = $this->db->insert_id();
        $this->db->where('ID',$actID)->update('activity_list',array('formID'=>$formID));
        return errorMessage(1, 'Add form success');
    }

    /**
     * 修改活动信息
     * @author ca007
     * @param string $act_start_date
     * @param string $act_end_date
     * @param string $sign_start_date
     * @param string $sign_end_date
     * @param string $address
     * @param string $title
     * @param string $detail
     */
    function modActivity($act_start_date,
                         $act_end_date,
                         $sign_start_date,
                         $sign_end_date,
                         $address,
                         $title,
                         $detail,
                         $total){
        $actInfo = array(
            'title'=>$title,
            'detail'=>$detail,
            'address'=>$address,
            'total'=>$total,
            'act_start_date'=>$act_start_date,
            'act_end_date'=>$act_end_date,
            'sign_start_date'=>$sign_start_date,
            'sign_end_date'=>$sign_end_date);
        $this->db->update('activity_list',$actInfo);
        return errorMessage(1,'OK');
    }

    /**
     * 获取群组活动
     * @author ca007
     * @param string $groupID 群组ID
     */
    function getGroupAct($groupID){
        $this->permission_model->checkManage($groupID);
        $sql = "select activity_list.ID, 
                       title, 
                       total, 
                       group_act.state, 
                       loginName,
                       nowTotal
                from activity_list,user_list,group_act  
                where userID=user_list.ID and 
                      activity_list.ID=actID and 
                      group_act.groupID=?";
        $actList = $this->db->query($sql,array($groupID))->result_array();
        return $actList;
    }

    /**
     * 获取当前登录用户创建的活动
     * @author ca007
     */
    function getMyAct(){
        if(!isLogin()){
            return errorMessage(-1,'未登录用户');
        }
        $sql = "select activity_list.ID, 
                       title, 
                       total, 
                       group_act.state, 
                       loginName,
                       nowTotal
                from activity_list,user_list,group_act  
                where userID=user_list.ID and 
                      activity_list.ID=actID and 
                      userID=? order by activity_list.ID desc";
        $actList = $this->db->query($sql,array($_SESSION['userID']))->result_array();
        return $actList;
    }

    /**
     * 通过活动ID获取活动信息
     * @author ca007
     */
    function getActByID($actID){
        $actList = $this->db->from('activity_list')->where('ID',$actID)->get()->result_array();
        if(!count($actList)){
            return errorMessage(-1,'No actID='.$actID);
        }else{
            return array_merge(errorMessage(1,"Success"),$actList[0]);
        }
    }

    /**
     * 获取当前登录用户所属群组的活动列表
     * @author ca007
     */
    function getActList(){
        $sql = "select activity_list.ID, activity_list.address, act_start_date, 
                       act_end_date, sign_start_date, sign_end_date, title, subType,
                       detail, nickName, baseType as type, total, nowTotal 
                from activity_list, user_list, group_act 
                where activity_list.ID=group_act.actID and userID=user_list.ID and state=1 and (";
        $count = 0;
        foreach($_SESSION['myGroup'] as $groupID => $groupInfo){
            if($count != 0) $sql = $sql."or ";
            $sql = $sql."groupID=".$groupID." ";
            $count += 1;
        }
        $sql = $sql.") order by activity_list.ID desc";
        $actList = $this->db->query($sql)->result_array();
        return $actList;
    }

    /**
     * 报名活动
     * @author ca007
     * @param int $actID activityID
     * @param string $realName 真实姓名
     * @param string $class 班级
     * @param string $phoneNumber 手机号
     * @param string $studentID 学号
     * @param string addon 备注
     */
    function signupact($actID, $realName, $class, $phoneNumber, $studentID, $addon){
        if(!isset($_SESSION['userID'])){
            return errorMessage(-1, '尚未登录。');
        }
        $hasSigned = $this->db->from('sign_list')->where('userID',$_SESSION['userID'])->where('actID',$actID)->get()->result_array();
        if(count($hasSigned)){
            return errorMessage(-2, '已报名，请勿重新报名。');
        }
        $act = $this->db->from('activity_list')->where('ID', $actID)->get()->result_array();
        if(!count($act)){
            return errorMessage(-3, '没有对应活动。');
        }
        $nTime = nowTime();
        if($nTime < $act[0]['sign_start_date']){
            return errorMessage(-4, '报名尚未开始。');
        }
        if($nTime > $act[0]['sign_end_date']){
            return errorMessage(-5, '报名已结束。');
        }
        $newSign = array('actID' => $actID,
                         'realName' => $realName,
                         'class' => $class,
                         'phoneNumber' => $phoneNumber,
                         'studentID' => $studentID,
                         'userID' => $_SESSION['userID'],
                         'addon' => $addon);
        $this->db->insert('sign_list', $newSign);
        $tmp = $this->db->from('activity_list')->where('ID',$actID)->get()->result_array();
        $totalNum = $tmp[0]['nowTotal'] + 1;
        $this->db->where('ID',$actID)->update('activity_list', array('nowTotal'=>$totalNum));
        return errorMessage(1, '添加成功。');
    }

    /**
     * 获取某活动的报名列表
     * @author ca007
     */
    function getSignList($actID){
        return $this->db->from('sign_list')->where('actID', $actID)->get()->result_array();
    }

    /**
     * 获取当前登录用户的报名列表
     * @author ca007
     */
    function getMySign(){
        $sql = "select sign_list.ID, act_start_date as sdate, act_end_date as edate, title, address, realName, class, phoneNumber, studentID, addon from sign_list, activity_list where activity_list.ID=sign_list.actID and sign_list.userID=?";
        $tmp = $this->db->query($sql,array($_SESSION['userID']))->result_array();
        return $tmp;
    }

    /**
     * 获取活动标题
     * @author ca007
     */
    function actTitle($actID){
        $tmp = $this->db->from('activity_list')->where('ID', $actID)->get()->result_array();
        return $tmp[0]['title'];
    }

    /**
     * 获取活动报名表
     * @author ca007
     */
    function getActForm($actID){
        $tmp = $this->db->from('activity_list')->where('ID', $actID)->get()->result_array();
        if(!count($tmp)){
            return errorMessage(-1,'No such activity');
        }else if($tmp[0]['baseType']!=0 || $tmp[0]['subType'] != 3 || $tmp[0]['formID'] == 0){
            return errorMessage(-2,'There\'s no s_form for the activity');
        }
        $s_form_id = $tmp[0]['formID'];
        $form_list = $this->db->from('s_form')->where('ID',$s_form_id)->get()->result_array();
        if(!count($form_list)){
            return errorMessage(-3,'No such s_form');
        }
        return array_merge(errorMessage(1,'Get act form success'), array('form_content'=>$form_list[0]['content']));
    }

    /**
     * 获取志愿活动
     * @author ca007
     */
    function getVolAct(){
        $sql = "select activity_list.ID,`title`,`total`,act_basetype.name as baseTypeName,act_subtype.name as subTypeName, status, nowTotal, loginName from activity_list,user_list,act_basetype,act_subtype where (activity_list.baseType=act_basetype.ID and subType=act_subtype.ID and userID=user_list.ID) order by activity_list.ID desc";
        $tmp = $this->db->query($sql)->result_array();
        return $tmp;
    }
    
    /**
     * 获取基本活动类型
     * @author ca007
     */
    function getBaseType(){
        $tmp = $this->db->from('act_basetype')->get()->result_array();
        return $tmp;
    }

    /**
     * 获取子活动类型
     * @author ca007
     */
    function getSubType($baseType){
        $tmp = $this->db->from('act_subtype')->where('baseType', $baseType)->get()->result_array();
        return $tmp;
    }
    
    /**
     * 检查当前用户是否为活动创建者
     * @author ca007
     */
    function checkUserPermission($actID){
        if($this->permission_model->checkBasePermission(BASE_VOLUNTEER_MANAGE, 0)){
            return errorMessage(1,'OK');
        }
        $tmp = $this->db->from('activity_list')->where('ID',$actID)->get()->result_array();
        if(count($tmp) == 0) {
            return errorMessage(-1, '没有对应活动');
        }
        if($tmp[0]['userID'] != $_SESSION['userID']){
            return errorMessage(-2, '没有对该活动的权限');
        }
        return errorMessage(1, 'OK');
    }
    
    /**
     * 审批通过活动
     * @author ca007
     */
    function passAct($relationID){
        $relationList = $this->db->from('group_act')->where('ID',$relationID)->get()->result_array();
        if(!count($relationID)){
            return errorMessage(-1, 'No such activity relation');
        }
        if(!$this->permission_model->manageGroup($relationList[0]['groupID'])){
            return errorMessage(-10, 'No permission');
        }
        $this->db->where('ID',$relationID)->update('group_act',array('state'=>1));
        return errorMessage(1,'OK');
    }

    /**
     * 关闭已审批活动
     * @author ca007
     */
    function closeAct($relationID){
        $relationList = $this->db->from('group_act')->where('ID',$relationID)->get()->result_array();
        if(!count($relationID)){
            return errorMessage(-1, 'No such activity relation');
        }
        if(!$this->permission_model->manageGroup($relationList[0]['groupID'])){
            return errorMessage(-10, 'No permission');
        }
        $this->db->where('ID',$relationID)->update('group_act',array('state'=>0));
        return errorMessage(1,'OK');
    }
}

?>
