<?php
/**
 * GRBAC权限类
 */

class permission_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    /**
     * 计算当前登录用户群组权限
     * @author ca007
     * @param string $groupID
     */
    function computeMyPermission($groupID){
        $myPermission = 0;
        $sql = "select roles from member_list where userID=? and groupID=?";
        $myRoles = $this->db->query($sql,array($_SESSION['userID'],$groupID))->result_array();
        if(count($myRoles) == 0){
            return $myPermission;
        }

        $myRoles = intval($myRoles[0]['roles']);
        $roleNum = 0;
        while($myRoles){
            if($myRoles & 1){
                $permissions = $this->db->from('role_list')->where('ID',$roleNum)->get()->result_array();
                $myPermission |= $permissions[0]['permissions'];
            }
            $myRoles = $myRoles >> 1;
            $roleNum += 1;
        }
        return $myPermission;
//        return $myRoles;
    }
    
    /**
     * 新增群组权限
     * @author ca007
     * @param int $ID
     * @param string $name
     * @param string $detail
     */
    function addPermission($ID, $name, $detail){
        $this->checkBasePermission(PERMISSION_MANAGE);
        $newPermission = array(
            'ID'=>$ID,
            'permissionName'=>$name,
            'permissionDetail'=>$detail);
        $this->db->insert('permission_list',$newPermission);
        return errorMessage(1,'新增权限成功');
    }

    /**
     * 新增基础权限
     * @author ca007
     * @param int $ID
     * @param string $name
     * @param string $detail
     */
    function addBasePermission($ID, $name, $detail){
        $this->checkBasePermission(BASE_PERMISSION_MANAGE);
        $newPermission = array(
            'ID'=>$ID,
            'permissionName'=>$name,
            'permissionDetail'=>$detail);
        $this->db->insert('basepermission_list',$newPermission);
        return errorMessage(1,'新增权限成功');       
    }

    /**
     * 检查用户在当前群组的权限
     * @author ca007
     * @param int $groupID groupID
     * @param int $permissionName constant
     * @param int $flag 没有权限的处理方式,1:Relocation 0:return -1
     */
    function checkPermission($groupID,$permissionName,$flag = 1){
    
        if(!isset($_SESSION['myGroup'][$groupID])){
            return $this->noPermission($permissionName,$flag,$groupID);
        }
        $permission = $_SESSION['myGroup'][$groupID]['permission'];
        if(!(($permission >> $permissionName) & 1)){
            return $this->noPermission($permissionName,$flag,$groupID);
        }
        return true;
    }

    /**
     * 检查当前用户的基础权限
     * @author ca007
     * @param int $permissionName constant
     * @param int $flag 没有权限的处理方式,1:Relocation 0:return -1
     */
    function checkBasePermission($permissionName,$flag = 1){
        if(!(($_SESSION['basepermission'] >> $permissionName) & 1)){
            return $this->noPermission($permissionName,$flag);
        }
        return true;
    }

    /**
     * 无权限处理
     * @author ca007
     * @param int $permissionName
     * @param int $flag 没有权限的处理方式,1:Relocation 0:return -1
     */
    function noPermission($permissionName, $flag = 1,$extra=''){
        if($flag == 1){
            die('No permission'.$extra);
        }else if($flag == 0){
            return false;
        }
        return ture;
    }

    /**
     * 检查当前role是否包含manager
     * @author ca007
     * @param int $roleNum
     */
    function isManager($roleNum){
        return (((int)$roleNum >> GROUP_MANAGER_SHIFT) & 1) ? true : false;
    }

    /**
     * 检查当前用户是否为该群组的管理员
     * @author ca007
     * @param string $groupID
     * @return bool $result <false: No permission true: Manager Permission>
     */
    function manageGroup($groupID){
        $sql = "select roles from member_list where groupID=? and userID=?";
        $roles = $this->db->query($sql,array($groupID,$_SESSION['userID']))->result_array();
        if(count($roles) == 0){
            return false;
        }
        return $this->isManager($roles[0]['roles']);
    }

    /**
     * 检查当前用户在该群组的权限
     * @author ca007
     */
    function checkManage($groupID){
        if(!$this->manageGroup($groupID)){
            header('Location: /user/nopermission');
        }
    }
}
?>