<?php

class user_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }

    /**
	 * @param string $loginName 用户登录名 
	 * @param string $nickName 用户昵称
	 * @param string $password 用户密码
	 * @param string $realName 用户真实姓名
	 * @param string $phoneNumber 用户手机号码
	 * @param string $schoolID 用户学校ID
	 * @param string $department 用户院系ID
	 * @param string $classID 用户班级ID
	 * @param string $studentId 用户学号
	 * @param string $address 用户地址
	 * @return array 
	 * userKey : use for set cookie<br>
	 * userID : use for set cookie<br>
	 * loginName : user for set cookie<br>
	 */
	function addUser($loginName, $nickName, $password,
					 $realName, $phoneNumber, $schoolID, $departmentID, $classID, $studentID, $address){
		$this->cleanUserInfo();
		$this->db->from('user_list')->where('loginName',$loginName);
		if(count($this->db->get()->result_array())){
			return errorMessage(0,'用户名已存在.');
		}
		$this->db->from('user_list')->where('nickName',$nickName);
		if(count($this->db->get()->result_array())){
			return errorMessage(-5,'昵称已存在.');
		}
		//insert to user_list
		$classList = $this->db->from('group_list')->where('groupID',$classID)->get()->result_array();
		$className = $classList[0]['class'];
		$passsalt = subStr($password,0,2).$this->_getSalt();
		$newUser = array(
			'loginName'=>$loginName,
			'nickName'=>$nickName,
			'password'=>crypt($password,$passsalt),
			'realName'=>cleanString($realName),
			'phoneNumber'=>$phoneNumber,
			'class'=>$className,
			'studentID'=>$studentID,
			'defaultGroupID'=>$departmentID,
			'baseRole'=>0,
			'address'=>$address);
		$this->db->insert('user_list',$newUser);

		//get the userID
        $tmp = $this->db->insert_id();

		//insert to member_list
		$this->db->insert('member_list',array('userID'=>$tmp,'groupID'=>$classID,'roles'=>2));
		$this->db->insert('member_list',array('userID'=>$tmp,'groupID'=>$departmentID,'roles'=>2));
		$this->db->insert('member_list',array('userID'=>$tmp,'groupID'=>$schoolID,'roles'=>2));

		//set session and cookie
		$this->_setUserInfo($loginName,$tmp,crypt($password,$passsalt),$departmentID,0,array(), $nickName,0);
        
		return errorMessage(1,'OK.');
	}
    
	/**
	 * 检查当前用户
	 * @param string $loginName 用户登陆名
	 * @param string $password 用户密码
	 */
	function checkUser($loginName,$password){
		$this->db->from('user_list')->where('loginName',$loginName);
		$tmp = $this->db->get()->result_array();
		if(!count($tmp)){
			return errorMessage(0,'username not exist.');
		}
		$passsalt = subStr($password,0,2).$this->_getSalt();
		if($tmp[0]['password'] == crypt($password,$passsalt)){
			$this->_setUserInfo($loginName,$tmp[0]['ID'],crypt($password,$passsalt),$tmp[0]['defaultGroupID'],$tmp[0]['baseRole'],array(), $tmp[0]['nickName'],$tmp[0]['baseRole']);
			return errorMessage(1,'OK.');
		}else{
			return errorMessage(-1,'error password.');
		}
	}

    /**
     * 检查用户cookie
     * @author ca007
     */
    function checkCookie(){
        if(isset($_SESSION['userID'])){
            return true;
        }
        if(!isset($_COOKIE['loginName'])){
            $_SESSION['myGroup'] = array('1000100000000'=>array('class'=>'清华大学','permission'=>'0'));
            return false;
        }
        $tmp = $this->db->from('user_list')->where('loginName',$_COOKIE['loginName'])->get()->result_array();
        if(!count($tmp)){
            return false;
        }
        if($_COOKIE['userKey'] == $tmp[0]['password']){
			$this->_setUserInfo($_COOKIE['loginName'],$tmp[0]['ID'],$_COOKIE['userKey'],$tmp[0]['defaultGroupID'],$tmp[0]['baseRole'],array(), $tmp[0]['nickName'],$tmp[0]['baseRole']);
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取当前登录用户信息
     * @author ca007
     */
    function getMyInfo(){
        $sql = "select loginName, realName, nickName, phoneNumber, class, studentID from user_list where ID=?";
        $tmp = $this->db->query($sql, array($_SESSION['userID']))->result_array();
        return array_merge($tmp[0],array('session'=>$_SESSION));
        return array_merge($tmp[0],array('basepermission'=>$_SESSION['basepermission']));
    }

    /**
     * 修改当前登录用户个人信息
     * @author ca007
     * @param string $nickName
     * @param string $phoneNumber
     * @param string $studentID
     */
    function modMyInfo($nickName, $phoneNumber, $studentID){
        $tmp = $this->db->from('user_list')->where('nickName',$nickName)->where('ID !=',$_SESSION['userID'])->get()->result_array();
        if($tmp){
            return errorMessage(-1,'昵称已存在');
        }
        $userInfo = array(
            'nickName'=>$nickName,
            'phoneNumber'=>$phoneNumber,
            'studentID'=>$studentID);
        $this->db->where('ID',$_SESSION['userID'])->update('user_list',$userInfo);
        return errorMessage(1, '修改成功'); 
    }

 	/**
	 * 清除用户登陆信息
	 */
	function cleanUserInfo(){
		unset($_SESSION['loginName']);
		unset($_SESSION['userID']);
		unset($_SESSION['baseRole']);
		unset($_SESSION['groupID']);
		unset($_SESSION['groupName']);
		unset($_SESSION['nickName']);
		unset($_SESSION['myGroup']);
        unset($_SESSION['basepermission']);
        unset($_SESSION['mcgroupList']);
        unset($_SESSION['mcgroupID']);
        unset($_SESSION['managerInfo']);
		setcookie('loginName','',-1,'/');
		setcookie('userKey','',-1,'/');
	}

	/**
	 * 设置用户cookie、session等
	 * @access private
	 * @param string $loginName 用户登陆名
	 * @param string $userID 用户ID
	 * @param string $userKey cookie密码
	 * @param string $myGroup 我的群组列表
	 * @param string $baseRole 基本角色
	 */
	private function _setUserInfo($loginName,$userID,$userKey,$defaultGroupID,$baseRole,$myGroup, $nickName,$baseRole) {
		$group_list = $this->db->from('group_list')->where('groupID',$defaultGroupID)->get()->result_array();
		if(count($group_list) != 0){
			$_SESSION['groupName'] = $group_list[0]['class'];
		}else{
			$_SESSION['gropuName'] = '不存在群组';
		}
		$_SESSION['userID'] = $userID;
		$_SESSION['loginName'] = $loginName;
		$_SESSION['baseRole'] = $baseRole;
		$_SESSION['groupID'] = $defaultGroupID;
		$_SESSION['nickName'] = $nickName;
		setcookie('loginName',$loginName,time()+60*60*24*10,'/');
		setcookie('userKey',$userKey,time()+60*60*24*10,'/');
		$this->load->model('group_model','group');
		$_SESSION['myGroup'] = $this->group->getMyGroup();

        $permission = 0;
        for($i = 0; $i < 32; $i ++){
            if(((int)$baseRole >> $i) & 1){
                $tmp = $this->db->from('baserole_list')->where('ID', $i)->get()->result_array();
                if(count($tmp)){
                    $permission = $permission | $tmp[0]['permission'];
                }
            }
        }
        $_SESSION['basepermission'] = $permission;
	}

    private function _getSalt(){
		return 'thu';
	}

}

?>
