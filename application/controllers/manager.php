<?php

@session_start();
 
class Manager extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function test(){
        $this->load->model('group_model','test');
        echo json_encode($this->test->getMyManageGroup());
    }

    function index(){
        if(isset($_SESSION['mcgroupList'])){
            $this->group();
            return;
        }
        //$this->groupbuy();
		header("Location: /manager/groupbuy");
    }

    /**
     * 切换管理群组
     * @author ca007
     */
    function changeGroup(){
        if(!isset($_REQUEST['groupID'])){
            echo json_encode(errorMessage(-2, '没有选择群组'));
            return ;
        }
        $groupID = $_REQUEST['groupID'];
        if(!isset($_SESSION['mcgroupList'])){
            echo json_encode(errorMessage(-1, '没有权限'));
            return ;
        }
        $flag = FALSE;
        $groupName = '';
        foreach($_SESSION['mcgroupList'] as $groupInfo){
            if($groupInfo['groupID'] == $groupID){
                $flag = TRUE;
                $groupName = $groupInfo['class'];
                break;
            }
        }
        if(!$flag){
            echo json_encode(errorMessage(-1,'没有权限'));
            return;
        }
        $_SESSION['mcgroupID'] = $groupID;
        $_SESSION['mcgroupName'] = $groupName;
        echo json_encode(errorMessage(1, '成功切换群组'));
        return;
    }
    
    /**
     * 管理群组
     * @author ca007
     */
    function groupManage(){
        $this->load->model('group_model','group');
        $group_list = $this->group->getMyManageGroup();
        
        $this->load->view('base/mainnav',array('page'=>'activity'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group',array('group_list'=>$group_list));
        $this->load->view('base/footer');
    }

    /**
     * 群组管理首页
     * @author Hewr
     */
    function group(){
		if (!isset($_GET["groupID"])) $groupID = ""; else $groupID = $_GET["groupID"];
		if ($groupID != "") $this->permission_model->checkManage($groupID);

        $this->load->model('group_model','group');
        $group_list = $this->group->getMyManageGroup();
		if ($groupID == "" && count($group_list) > 0) $groupID = $group_list[0]["groupID"];

        $this->load->view('base/mainnav',array('page'=>'group_manage'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group/header',array("default" => $groupID, "list" => $group_list, "mgh" => "add"));
		if ($groupID != "") {
			$childGroups = $this->group->getAllChildGroups($groupID);
        	$this->load->view('manager/group/index',array("childGroups" => $childGroups));
		}
        $this->load->view('base/footer');
    }
    
    /**
     * 群组管理 公告页面
     * @author ca007
     */
    function announcement(){
        $this->permission_model->checkManage($_SESSION['mcgroupID']);
        $this->load->view('base/mainnav',array('page'=>'managegroup'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group_header',array('mgh'=>'announcement'));
        $this->load->view('base/footer');
    }
    
    /**
     * 活动管理首页
     * @author ca007
     */
    function activity(){
        $this->load->model('activity_model','act');
        $actList = $this->act->getMyAct();
        $this->load->view('base/mainnav',array('page'=>'manageactivity'));
        $this->load->view('manager/header',array('mh'=>'activity'));
        $this->load->view('manager/activity/actlist',array('actList'=>$actList));
        $this->load->view('base/footer');
    }

	/**
	 * 团购管理首页
	 * @author Hewr
	 */
	function groupbuy() {
		$this->load->view("base/mainnav", array("page" => "groupbuy_manager"));
		$this->load->view("manager/header", array("mh" => "shop"));
		$this->load->view("manager/shop_header", array("mgh" => "groupbuy"));
		$this->load->view("manager/groupbuy/groupbuy_list");
		$this->load->view("base/footer");
	}

    /**
     * 团购管理首页
     * @author Hewr
     * @author xanda
     */
    function shoplist() {
        $this->load->model('shop_model','shop');
        if (isset($_SESSION['userID']))
            $list = $this->shop->getShopListByUser($_SESSION['userID']);
        else
            $list = array();
        $this->load->view("base/mainnav", array("page" => "shoplist_manager"));
        $this->load->view("manager/header", array("mh" => "shop"));
        $this->load->view("manager/shop_header", array("mgh" => "fruit"));
        $this->load->view("manager/shop/shoplist_manager", array("list" => $list));
        $this->load->view("base/footer");
    }



    /**
     * 团购修改页面
     * @author Hewr
     * @author xanda
     */
    function shop_modify() {
        if (!isset($_GET["id"])) exit(0);
        $this->load->view("base/mainnav", array("page" => "shop_manager_modify"));
        $this->load->view("manager/header", array("mh" => "shop"));
        $this->load->view("manager/shop_header", array("mgh" => "fruit"));
        $this->load->model('shop_model','shop');
        $shopInfo = $this->shop->getShopInfoByID($_GET["id"]);
        $goodsList = $this->shop->getGoodListByShop($_GET["id"]);
        $this->load->view("manager/shop/shop_modify", array("shopInfo" => $shopInfo, "goodsList" => $goodsList));
        $this->load->view("base/footer");
    }

	/**
	 * 团购修改页面
	 * @author Hewr
	 */
	function groupbuy_modify() {
		if (!isset($_GET["id"])) exit(0);
		$this->load->view("base/mainnav", array("page" => "groupbuy_manager_modify"));
		$this->load->view("manager/header", array("mh" => "shop"));
		$this->load->view("manager/shop_header", array("mgh" => "groupbuy"));
		$this->load->view("manager/groupbuy/groupbuy_modify", array("id" => $_GET["id"]));
		$this->load->view("base/footer");
	}

	/**
	 * 统计管理水果页面
	 * @author Hewr
	 */
	function statistics_fruit() {
		$this->load->view("base/mainnav", array("page" => "statistics_manager"));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "fruit"));
		$this->load->view("manager/statistics/fruit.php");
		$this->load->view("base/footer");
	}

	/**
	 * 统计管理团购页面
	 * @author Hewr
	 */
	function statistics_groupbuy() {
        $this->load->model('groupbuy_model','gb');
        $groupbuy_list = $this->gb->getGroupbuyByID($_SESSION['userID']);
		$this->load->view("base/mainnav", array("page" => "statistics_manager"));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "groupbuy"));
		$this->load->view("manager/statistics/groupbuy.php",array('groupbuy_list'=>$groupbuy_list));
		$this->load->view("base/footer");
	}

	/**
	 * 统计管理活动报名页面
	 * @author ca007
	 */
	function statistics_activity() {
        $this->load->model('activity_model','act');
        $actList = $this->act->getMyAct();
        
		$this->load->view("base/mainnav", array("page" => "statistics_manager"));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "activity"));
		$this->load->view("manager/statistics/activity",array('actList' => $actList));
		$this->load->view("base/footer");
	}

    /**
     * 活动审批页面
     * @author ca007
     */
    function examine() {
        $this->load->model('manager_model','man');
        $actList = $this->man->getExamineList();
        
        $this->load->view('base/header', array('page'=>'examine'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group_header',array('mgh'=>'activity'));
        $this->load->view('manager/examine/index',array('actList'=>$actList));
        $this->load->view('base/footer');
    }

    /**
     * 审批通过活动
     * @author ca007
     */
    function passAct() {
        $type = $_REQUEST['type'];
        $relationID = $_REQUEST['relationID'];
        if($type=='act'){
            $this->load->model('activity_model','act');
            $result = $this->act->passAct($relationID);
        }else{
            $result = errorMessage(-2,'Error act type');
        }
        if($result['error']['code'] == 1){
            header('Location: /manager/examine');
        }
        echo json_encode($result);
    }

    /**
     * 关闭已审批活动
     * @author ca007
     */
    function closeAct() {
        $type = $_REQUEST['type'];
        $relationID = $_REQUEST['relationID'];
        if($type=='act'){
            $this->load->model('activity_model','act');
            $result = $this->act->closeAct($relationID);
        }else{
            $result = errorMessage(-2,'Error act type');
        }
        if($result['error']['code'] == 1){
            header('Location: /manager/examine');
        }
        echo json_encode($result);
    }

}

?>
