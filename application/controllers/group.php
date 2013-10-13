<?php
@session_start();

class group extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    /**
     * 群组管理页面
     * @author ca007
     */
    public function groupManage(){
        $this->load->view('base/mainnav',array('page'=>'groupmanage'));
        $this->load->view('group/groupManage');
        $this->load->view('base/footer');
    }

    /**
     * 查看群组管理员
     * @author ca007
     */
    public function groupManager(){
        $this->load->view('base/mainnav',array('page'=>'groupmanager'));
        $this->load->view('group/groupmanager');
        $this->load->view('base/footer');
    }
    
    /**
     * @author ca007
     * @return array groupList
     */
    public function getMyGroup(){
        $this->load->model('group_model','group');
        echo json_encode($this->group->getMyGroup());
    }
    
	/**
	* 获取学校列表
	* @author LJNanest
	* @return list 学校列表
	*/
	public function getSchoolList(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getSchoolList());
	}

	/**
	 * 获取对应学校的院系列表
	 * @author ca007
	 * @param string $schoolID 学校ID
	 * @return list 院系列表
	 */
	public function getDepartmentList(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getDepartmentList($_REQUEST['schoolID']));
	}
	
	/**
	 * 获取对应院系的班级列表
	 * @author ca007
	 * @param string $departmentID 院系ID
	 * @return list 班级列表
	 */
	public function getClassList(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getClassList($_REQUEST['departmentID']));
	}

    /**
     * @author LJNest
     * @return array $schoolList
     */
	public function getSchoolByUser(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getSchoolByUser());
	}

    /**
     * @author LJNest
     * @return array $departmentList
     */
	public function getDepartmentByUser(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getDepartmentByUser());
	}

    /**
     * @author LJNest
     * @return array $classList
     */
	public function getClassByUser(){
		$this->load->model('group_model','area');
		echo json_encode($this->area->getClassByUser());
	}

    /**
     * 添加志愿组
     * @author ca007
     */
    public function addVolGroup(){
        $this->load->model('group_model','group');
        $this->permission_model->checkBasePermission(BASE_VOLUNTEER_MANAGE);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('groupName','group name','required');
        
        if($this->form_validation->run() == FALSE){
            $this->load->view('base/headervol',array('page'=>'addvolgroup'));
            $this->load->view('volunteer/addvolgroup');
            $this->load->view('base/footer');
        }else{
            $re = $this->group->addVolGroup($_REQUEST['groupName']);
            header('Location: /volunteer/grouplist');
        }
    }

    public function addGroup(){


        $this->load->model('group_model','group');
        //$this->permission_model->checkBasePermission(GROUP_MANAGE);
		$parentID = $_REQUEST["parentID"];
		$this->permission_model->checkManage($parentID);
		$parentID = $parentID."";
        if (strcmp(substr($parentID, 1, 4), "0000") == 0) $type = 0; else 
		if (strcmp(substr($parentID, 5, 4), "0000") == 0) $type = 1; else 
		if (strcmp(substr($parentID, 9, 4), "0000") == 0) $type = 2; else $type = 3;

        
		switch($type){
            case 0:
                echo json_encode($this->group->newSchool($_REQUEST['name']));
                return;
            case 1:
                echo json_encode($this->group->newDepartment($_REQUEST["parentID"],$_REQUEST['name']));
                return ;
            case 2:
                echo json_encode($this->group->newClass($_REQUEST["parentID"],$_REQUEST['name']));
                return;
            case 3:
                echo json_encode(errorMessage(-1,'尚未开放'));
                return;
            default:
                echo json_encode(errorMessage(-2,'未知的类型'));
                return;
        }
    }

	public function delGroup(){
        $this->load->model('group_model','group');
        $this->permission_model->checkBasePermission(GROUP_MANAGE);
		$parentID = $_REQUEST["parentID"];
		$this->permission_model->checkManage($parentID);
		$groupID = $_REQUEST["groupID"];
		$IDItv = $this->group->getChildIndexes($parentID);
		if (strcmp($groupID, $IDItv[0]) <= 0 || strcmp($groupID, $IDItv[1]) > 0) {
			echo json_encode(errorMessage(-1,"ID范围错误"));
			return;
		}
		echo json_encode($this->group->deleteGroup($groupID));
	}

    /**
     * 删除群组成员
     * @author ca007
     */
    public function removeMember(){
        if(!isset($_REQUEST['relationID'])){
            echo errorMessage(-1,'No relation ID');
            return;
        }
        $this->load->model('group_model','group');
        echo json_encode($this->group->removeMember($_REQUEST['relationID']));
    }

	/*
	public function test(){
		$this->load->model('arealist_model','area');
		$this->area->delClassByUser();
	}
*/
} 
?>
