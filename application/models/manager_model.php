<?php

@session_start();

class manager_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /**
     * 初始化用户管理员信息
     * @author ca007
     */
    function initManagerInfo(){
        if(!isset($_SESSION['userID'])){
            return;
        }
        if(!isset($_SESSION['managerInfo'])){
            $this->load->model('group_model','group');
            $group_list = $this->group->getMyManageGroup();
            if(!count($group_list)){
                $_SESSION['managerInfo'] = true;
                return;
            }
            $_SESSION['mcgroupList'] = $group_list;
            
            $_SESSION['mcgroupID'] = $group_list[0]['groupID'];
            $_SESSION['mcgroupName'] = $group_list[0]['class'];
        }
        $_SESSION['managerInfo'] = true;
    }
/**
    function getExamineList(){
        $resultList = array();
        
        $actSql = "select group_list.class,title,loginName,createTime,
                   group_act.ID as relationID,state  
                   from group_list,user_list,activity_list,group_act
                   where actID=activity_list.ID and 
                         group_list.groupID=group_act.groupID and 
                         userID=user_list.ID and 
                         (";
        $count = 0;
        foreach($_SESSION['mcgroupList'] as $key => $groupInfo){
            if($count != 0) $actSql = $actSql."or ";
            $actSql = $actSql."group_list.groupID=".$groupInfo['groupID']." ";
            $count += 1;
        }
        $actSql = $actSql.")";
        $actList = $this->db->query($actSql)->result_array();
        foreach($actList as $key => $actInfo){
            $actList[$key]['type'] = 'act';
        }

        $resultList = array_merge($resultList,$actList);
        usort($resultList,'mysort');
        return $resultList;
        }    */


    function getExamineList(){
        $resultList = array();

        $actSql = "select feed_list.title,loginName,feed_list.time,feed_list.type, 
                       group_feed.ID as relationID,group_feed.state,group_list.class
                   from group_list,user_list,group_feed,feed_list
                   where feed_list.ID=group_feed.newsID and feed_list.userID=user_list.ID 
                       and group_list.groupID=group_feed.groupID and (";
        $count = 0;
        foreach($_SESSION['mcgroupList'] as $key => $groupInfo){
            if($count != 0) $actSql = $actSql."or ";
            $actSql = $actSql."group_list.groupID=".$groupInfo['groupID']." ";
            $count += 1;
        }
        $actSql = $actSql.") order by feed_list.ID desc";
        $actList = $this->db->query($actSql)->result_array();
        return $actList;
    }

    function mysort($a,$b){
        if($a['createTime'] == $b['createTime']){
            return 0;
        }else if($a['createTime'] > $b['createTime']){
            return 1;
        }else if($a['createTime'] < $b['createTime']){
            return -1;
        }
    }
}
?>
