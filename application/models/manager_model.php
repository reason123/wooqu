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
}

?>
