<?php

class group_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

    /**
     * @author ca007
     * @return array $groupList
     */
    function getMyGroup(){
        if(!isset($_SESSION['userID'])){
            return array();
        }
        $sql = "select distinct member_list.groupID,group_list.class,`class` from member_list,group_list where userID=? and member_list.groupID=group_list.groupID";
        $groupList = $this->db->query($sql,array($_SESSION['userID']))->result_array();
        $this->load->model('permission_model','per');
        $resultList = array();
        foreach($groupList as $i => $group){
            $resultList[$group['groupID']] = array('class'=>$group['class'],'permission'=>$this->per->computeMyPermission($group['groupID']));
        }
        return $resultList;
    }

    /**
     * 获取志愿群组
     * @author ca007
     */
    function getVolGroup(){
        $sql = "select distinct * from `group_list` where groupID like '100019_______'";
        $volGroupList = $this->db->query($sql)->result_array();
        return $volGroupList;
    }
    
	/**
	 * 获取所有学校列表
	 * @author ca007
	 * @return list <br>
	 * school : school name<br>
	 * groupID : groupID
	 */
	function getSchoolList(){
		$sql = "SELECT DISTINCT `school`,groupID FROM `group_list` WHERE groupID LIKE '1____00000000' ORDER BY groupID";
		$schoolList = $this->db->query($sql)->result_array();
		return $schoolList;
	}

	/**
	 * 获取学校所有院系列表
	 * @author ca007
	 * @param string $schoolID 学校ID
	 * @return list <br>
	 * department : department name<br>
	 * groupID : groupID
	 */
	function getDepartmentList($schoolID){
		$sql = "SELECT `department`,groupID,`school` FROM `group_list` WHERE (groupID NOT LIKE ?)  AND (groupID LIKE ?) ORDER BY groupID";
	//	return $sql;
		$res = $this->db->query($sql,array(substr($schoolID, 0, 5).'00000000',substr($schoolID, 0, 5).'____0000'))->result_array();
		return $res;
	}

	/**
	 * 获取院系所有班级列表
	 * @author ca007
	 * @param string $departmentID 院系ID
	 * @return list <br>
	 * class : class name<br>
	 * groupID : groupID
	 */
	function getClassList($departmentID){
		$sql = "SELECT `class`,groupID,`department`,`school` FROM `group_list` WHERE (groupID NOT LIKE ?)  AND (groupID LIKE ?) ORDER BY groupID ";
	//	return $sql;
		$res = $this->db->query($sql,array(substr($departmentID, 0, 9).'0000',substr($departmentID, 0, 9).'____'))->result_array();
		return $res;
	}

	/**
	 * 获取群组名
	 * @param string $groupID 群组ID
	 * @return string 群组名
	 */
	function getGroupName($groupID){
		$sql = "SELECT `class` FROM group_list WHERE groupID=?";
		$res = $this->db->query($sql,array($groupID))->result_array();
		if(count($res) == 0){
			return errorMessage(0,'Error groupID: '.$groupID);
		}
		return array_merge(array('groupName'=>$res[0]['class']),errorMessage(1,'OK'));
	}

    /**
     * 添加志愿群组
     * @author ca007
     */
    function addVolGroup($groupName){
        $volGroupList = $this->getVolGroup();
        $volNum = count($volGroupList);
        $volGroupID = 1000190000000 + ($volNum + 1);
        $newVolGroup = array('school'=>'清华大学',
                             'department'=>'紫荆志愿',
                             'class'=>cleanString($groupName),
                             'groupID'=>$volGroupID);
        $this->db->insert('group_list',$newVolGroup);
        return errorMessage(1, '新增志愿群组成功');
    }
    
	/**
	* 新增学校
	* @author LJNanest
	* @param string $schoolName 学校名称
	*/
	function newSchool($schoolName){
        $schoolName = cleanString($schoolName);
		if (strlen($schoolName)<1){
			return errorMessage(-1,'请输入学校名');
		}
		$schoolCount = $this->db->from('group_list')->where('school',$schoolName)->get()->result_array();
		if(count($schoolCount) != 0){
			return errorMessage(-1,'学校名已存在');
		}
		$schoolList = $this->getSchoolList();
		$schoolNum = count($schoolList);
		if ($schoolNum >9999){
			return errorMessage(-1,'超过最大数目');
		}
		$schoolID = 1000000000000 + ($schoolNum + 1) * 100000000;
		$newGroup = array(
				"school"=>$schoolName,
				"department"=>$schoolName,
				"class"=>$schoolName,
				"groupID"=>$schoolID
			);
		$this->db->insert('group_list',$newGroup);
		return errorMessage(1,'新增成功');
	}

	/**
	* 新增学院 
	* @author LJNanest
	* @param string $schoolID 学校ID
	* @param string $departmentName 学院名称
	*/
	function newDepartment($schoolID,$departmemtName){
        $departmentName = cleanString($departmentName);
		if (strlen($departmemtName)<1) return array('error'=>array('code'=>-1,'message'=>'请输入院系名称!'));
		$departmentCount = $this->db->from('group_list')->where('department',$departmemtName)->get()->result_array();
		if(count($departmentCount) != 0){
			return errorMessage(-1,'院系名已存在');
		}
		if ($schoolID == 0) return array('error'=>array('code'=>-1,'message'=>'请选择学校!'));
		$tmp = $this->getDepartmentList($schoolID);
		$num = count($tmp);
		if ($num >9999){
			return array('error'=>array('code'=>-1,'message'=>'贵校院系数量已满!'));
		}
		$newID = $schoolID+($num + 1)*10000;
		$newGroup = array(
				'school'=>$tmp[0]['school'],
				'department'=>$departmemtName,
				'class'=>$departmemtName,
				'groupID'=>$newID
			);
		$this->db->insert('group_list',$newGroup);
        return errorMessage(1,'新增院系成功');
	}

	/**
	* 新增班级 
	* @author LJNanest
	* @param string $departmentID 学校ID
	* @param string $className 学院名称
	*/
	function newClass($departmentID,$className)
	{
        $className = cleanString($className);
		if (strlen($className)<1) return errorMessage(-1,'请输入班级名称');
		$classCount = $this->db->from('group_list')->where('class',$className)->get()->result_array();
		if(count($classCount) != 0){
			return errorMessage(-1,'班级名已存在');
		}
		if ($departmentID == 0) return errorMessage(-1,'请选择院系');
		$tmp = $this->getClassList($departmentID);
		$num = count($tmp);
		if ($num > 9999) return errorMessage(-1,'贵院系班级数量已满!');
		$newID = $departmentID + ($num + 1);
		$newGroup = array(
				'school'=>$tmp[0]['school'],
				'department'=>$tmp[0]['department'],
				'class'=>$className,
				'groupID'=>$newID
			);
		$this->db->insert('group_list',$newGroup);
		return errorMessage(1,'新增班级成功');
	}

	/**
	 * 删除群组
	 * @author Hewr
	 * @param groupID
	 */
	function deleteGroup($groupID) {
	}

	/**
	 * 检查当前用户是否为群组用户
	 * @author LJNanest
	 * @param string $groupID
	 * @return bool $res
	 */
	function isMemberOfGroup($groupID){
		if(!isset($_SESSION['userID'])){
			return false;
		}
		$tmp = $this->db->from('member_list')->where('userID',$_SESSION['userID'])->where('groupID',$groupID)->get()->result_array();
		if(count($tmp)){
			return true;
		}
	}

    /**
     * @author LJNanest
     * @return array $schoolList
     */
	function getSchoolByUser()
	{
		$sql = "SELECT group_list.ID ,group_list.groupID, group_list.school as name
				FROM member_list, group_list
				WHERE userID = ? AND (member_list.groupID LIKE '1____00000000') AND group_list.groupID = member_list.groupID";
		$schoolList = $this->db->query($sql,array($_SESSION['userID']))->result_array();
		return $schoolList;
	}

    /**
     * @author LJNanest
     * @return array $departmentList
     */
	function getDepartmentByUser()
	{
		$sql = "SELECT group_list.ID ,group_list.groupID, group_list.department as name
				FROM member_list, group_list
				WHERE userID = ? AND (member_list.groupID NOT LIKE '1____00000000') AND (member_list.groupID LIKE '1________0000') AND group_list.groupID = member_list.groupID";
		$departmentList = $this->db->query($sql,array($_SESSION['userID']))->result_array();
		return $departmentList;
	}

    /**
     * @author LJNest
     * @return array $classList
     */
	function getClassByUser()
	{
		$sql = "SELECT group_list.ID ,group_list.groupID, group_list.class as name
				FROM member_list, group_list
				WHERE userID = ? AND (member_list.groupID NOT LIKE '1________0000') AND (member_list.groupID LIKE '1____________') AND group_list.groupID = member_list.groupID";
		$classList = $this->db->query($sql,array($_SESSION['userID']))->result_array();
		return $classList;
	}


     /**
      * 更新当前用户的班级信息
      * @param string $schoolID
      * @param string $departmentID
      * @param string $classID
      * @return object $errorMessage
      */
	function updataClass($schoolID,$departmentID,$classID)
	{
		$school = $this->getSchoolByUser();
		$department = $this->getDepartmentByUser();
		$class = $this->getClassByUser();
		if (count($class) != 0) return errorMessage(1,'无需更新');
		$this->db->insert('member_list',array('userID'=>$_SESSION['userID'],'groupID'=>$classID));
		if (count($department) == 0) $this->db->insert('member_list',array('userID'=>$_SESSION['userID'],'groupID'=>$departmentID));
		if (count($school) == 0) $this->db->insert('member_list',array('userID'=>$_SESSION['userID'],'groupID'=>$schoolID));

		$classList = $this->db->from('group_list')->where('groupID',$classID)->get()->result_array();
		$className = $classList[0]['class'];
		$departmentList = $this->db->from('group_list')->where('groupID',$departmentID)->get()->result_array();
		$departmentName = $departmentList[0]['class'];

		$_SESSION['groupID'] = $departmentID;
		$_SESSION['groupName'] = $departmentName;
		$userClass=array(
			'class'=>$className,
			'defaultGroupID'=>$departmentID);
		$this->db->where('ID',$_SESSION['userID'])->update('user_list',$userClass);
		return errorMessage(1,'初始化成功');
	}

    /**
     * 获取我管理的群组
     * @author ca007
     */
    function getMyManageGroup(){
        $this->load->model('permission_model','per');
        $sql = "select group_list.groupID,class,school,department,roles from group_list,member_list where userID=? and group_list.groupID=member_list.groupID order by group_list.groupID";
        $group_list = $this->db->query($sql,array($_SESSION['userID']))->result_array();
        $manage_group = array();
        foreach($group_list as $i => $group){
            if($this->per->isManager($group['roles'])){
                array_push($manage_group,$group);
            }
        }
        return $manage_group;
    }

	/**
	 * 获取群组子群组ID范围
	 * @author Hewr
	 */
	function getChildIndexes($groupID) {
		if (strcmp(substr($groupID, 1, 4), "0000") == 0) {
			$minID = substr($groupID,0,1)."000000000000";
			$maxID = substr($groupID,0,1)."999999999999";
		} else if (strcmp(substr($groupID, 5, 4), "0000") == 0) {
			$minID = substr($groupID,0,5)."00000000";
			$maxID = substr($groupID,0,5)."99999999";
		} else if (strcmp(substr($groupID, 9, 4), "0000") == 0) {
			$minID = substr($groupID,0,9)."0000";
			$maxID = substr($groupID,0,9)."9999";
		} else {
			$minID = "1";
			$maxID = "0";
		}
		return array($minID, $maxID);
	}

	/**
	 * 获取群组所有子群组
	 * @author Hewr
	 */
	function getAllChildGroups($groupID) {
		$arr = $this->getChildIndexes($groupID);
		$sql = "SELECT `groupID`,`class`,`school`,`department` FROM `group_list` WHERE `groupID`>? AND `groupID`<=? ";
		if (strcmp(substr($groupID, 5, 4), "0000") == 0) 
			$sql = $sql."AND groupID LIKE '1________0000' ";
		$sql = $sql."ORDER BY `groupID`";
		$res = $this->db->query($sql, array($arr[0], $arr[1]))->result_array();
		return $res;
	}

    /**
     * 获取群组成员
     * @author ca007
     * @param string $groupID
     */
    function getMemberByGroup($groupID){
        $sql = "select userID, member_list.ID, loginName, realName, phoneNumber
                from user_list, member_list 
                where userID=user_list.ID and member_list.groupID=?";
        $user_list = $this->db->query($sql, array($_SESSION['memGroupID']))->result_array();
        return $user_list;
    }

    /**
     * 获取群组申请列表
     * @author ca007
     * @param string $groupID
     */
    function getSignByGroup($groupID){
        $sql = "select userID, member_apply.ID, loginName, realName, phoneNumber
                from user_list, member_apply 
                where userID=user_list.ID and member_apply.groupID=?";
        $user_list = $this->db->query($sql, array($_SESSION['memGroupID']))->result_array();
        return $user_list;
    }

    /**
     * 删除群组成员
     * @author ca007
     */
    function removeMember($relationID){
        $tmp = $this->db->from('member_list')->where('ID',$relationID)->get()->result_array();
        if(!count($tmp)){
            return errorMessage(-2,'No such relation');
        }
        $this->permission_model->checkManage($tmp[0]['groupID']);
        $this->db->delete('member_list',array('ID'=>$relationID));
        return errorMessage(1,'OK');
    }

    /**
     * 获取我加入的群组列表
     * @author ca007
     */
    function getMyGroupList(){
        $sql = "select class as groupName,member_list.groupID,member_list.ID
                from member_list,group_list 
                where member_list.groupID=group_list.groupID and userID=?";
        $tmp = $this->db->query($sql,array($_SESSION['userID']))->result_array();
        return $tmp;
    }

/*
	function delClassbyUser()
	{
		
		$this->db->where('userID',$_SESSION['userID'])->delete('member_list');
	}
*/
/*
	function addClass(){
		for($i = 0;$i < 10;$i ++){
			for($j = 1;$j < 4;$j ++){
				$newClass = array(
								'groupID'=>'10001000520'.$i.$j,
								'school'=>'清华大学',
								'department'=>'机械系',
								'class'=>'机'.$i.$j);
				$this->db->insert('group_list',$newClass);
			}
		}
	}
*/
}

?>
