<?php

@session_start();
 
class Manager extends CI_Controller{
    function __construct(){
        parent::__construct();
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
        
        $this->load->view('base/header',array('page'=>'activity'));
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
		if ($groupID == "" && count($group_list) > 0) {
            $groupID = $group_list[0]["groupID"];
        }
        $_SESSION['memGroupID'] = $groupID;

        $this->load->view('base/header',array('page'=>'group_manage'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group/header',array("default" => $groupID, "list" => $group_list, "mgh" => "add"));
		if ($groupID != "") {
			$childGroups = $this->group->getAllChildGroups($groupID);
        	$this->load->view('manager/group/index',array("childGroups" => $childGroups));
		}
        $this->load->view('base/footer');
    }

    /**
     * 群组成员管理
     * @author ca007
     */
    function memberin(){
        $this->load->model('group_model','group');
        $userList = $this->group->getMemberByGroup($_SESSION['memGroupID']);
        $this->permission_model->checkManage($_SESSION['memGroupID']);
        $this->load->view('base/header',array('page'=>'memberin_manage'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group/memberin',array('userList'=>$userList));
        $this->load->view('base/footer');
    }

    /**
     * 群组申请成员管理
     * @author ca007
     */
    function membersign(){
        $this->load->model('group_model','group');
        $userList = $this->group->getSignByGroup($_SESSION['memGroupID']);
        $this->permission_model->checkManage($_SESSION['memGroupID']);
        $this->load->view('base/header',array('page'=>'membersign_manage'));
        $this->load->view('manager/header',array('mh'=>'group'));
        $this->load->view('manager/group/membersign',array('userList'=>$userList));
        $this->load->view('base/footer');
    }
    
    /**
     * 群组管理 公告页面
     * @author ca007
     */
    function announcement(){
        $this->permission_model->checkManage($_SESSION['mcgroupID']);
        $this->load->view('base/header',array('page'=>'managegroup'));
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
        $this->load->view('base/header',array('page'=>'manageactivity'));
        $this->load->view('manager/header',array('mh'=>'activity'));
        $this->load->view('manager/activity/actlist',array('actList'=>$actList));
        $this->load->view('base/footer');
    }

	/**
	 * 团购管理首页
	 * @author Hewr
	 */
	function groupbuy() {
		$this->load->view("base/header", array("page" => "groupbuy_manager"));
		$this->load->view("manager/header", array("mh" => "groupbuy"));
		//$this->load->view("manager/shop_header", array("mgh" => "groupbuy"));
		$this->load->view("manager/groupbuy/groupbuy_list");
		$this->load->view("base/footer");
	}

    /**
     * 团购管理首页
     * @author Hewr
     * @author xanda
     */
    function shop() {
        $this->load->model('shop_model','shop');
        if (isset($_SESSION['userID']))
            $list = $this->shop->getShopListByUser($_SESSION['userID']);
        else
            $list = array();
        $this->load->view("base/header", array("page" => "shoplist_manager"));
        $this->load->view("manager/header", array("mh" => "shop"));
     //   $this->load->view("manager/shop_header", array("mgh" => "fruit"));
        $this->load->view("manager/shop/shoplist_manager", array("list" => $list));
        $this->load->view("base/footer");
    }



    /**
     * 团购修改页面
     * @author Hewr
     * @author xanda
     */
    function shop_modify() {
		$this->load->library('form_validation');
        $this->form_validation->set_rules('name','name','required'); 
        $this->form_validation->set_rules('name','name','required'); 

        $this->load->model('shop_model','shop');
        if (!isset($_GET["id"])) exit(0);
        if (!isset($_REQUEST['name'])) {
            $shopInfo = $this->shop->getShopInfoByID($_GET["id"]);
        	$_REQUEST['name'] = $shopInfo['name'];
        	$_REQUEST['address'] = $shopInfo['address'];
        	$_REQUEST['phone'] = $shopInfo['phone'];
        	$_REQUEST['detail'] = $shopInfo['detail'];
        }
        if ($this->form_validation->run() == FALSE) {
            $this->load->view("base/header", array("page" => "shop_manager_modify"));
            $this->load->view("manager/header", array("mh" => "shop"));
            $this->load->view("manager/shop_header",array("mgh"=>"infoManager","shopID"=>$_GET["id"]));
            //$this->load->view("manager/shop_header", array("mgh" => "fruit"));
            $this->load->view("manager/shop/shop_modify");
            $this->load->view("base/footer");
        } else {
            $shop = array (
                'ID' => $_GET['id'],
                'name' => $_REQUEST['name'],
                'address' =>$_REQUEST['address'],
                'phone' => $_REQUEST['phone'],
                'detail' => $_REQUEST['detail']);
            $this->shop->modifyShop($shop);    
            header('Location: /ger/groupbuy_modify?id='.$_GET['ID']);
        }
    }

	/**
	 * 新建团购
	 * @author LJNanest Hewr
	 */
	function newGroupbuy()
	{
		$this->load->library('form_validation');
        $this->form_validation->set_rules('title','title','required'); 
        $this->form_validation->set_rules('illustration','illustration','required'); 
        $this->load->model('groupbuy_model','groupbuy');
        if (isset($_GET['id']))
        if (!isset($_REQUEST['title']))
        {
        	$groupbuyInfo = $this->groupbuy->getGroupbuyInfoByID($_GET['id']);
            $groupList = $this->groupbuy->getGroupListByID($_GET['id']);
            
            $str = '';

            foreach ($groupList as $key=>$value)
            {
                $str = $str.$value.';';
            }
        	$_REQUEST['title'] = $groupbuyInfo['title'];
        	$_REQUEST['illustration'] = $groupbuyInfo['illustration'];
            $_REQUEST['group_list'] = $str;
            $_REQUEST['orderMessageList'] = $groupbuyInfo['orderMessage'];
        }
        if($this->form_validation->run() == FALSE){
        	
        	$this->load->view('base/header',array('page'=>'newgroupbuy'));
		    $this->load->view("manager/header", array("mh" => "groupbuy"));
            $this->load->view('manager/groupbuy/newgroupbuy');
            $this->load->view('base/footer');
        }else{        	
        	$shop = array("title"=>cleanString($_REQUEST['title']),
                         "status"=>"1",
                          "illustration"=>cleanString($_REQUEST['illustration']),
                          "deadline"=>cleanString($_REQUEST['act_end_date']),
                          "pickuptime"=>cleanString($_REQUEST['sign_end_date']), 
						  "group_list"=>cleanString($_REQUEST['group_list']),
                          );
        	$groupbuyID = $this->groupbuy->insertShop($shop);
			$picPath = "/storage/groupbuyPic/pic_".$groupbuyID.".jpg";
            if ($_FILES['pic']['size'] > 0) {
				$photo = $_FILES['pic'];
				move_uploaded_file($photo['tmp_name'], substr($picPath, 1, strlen($picPath)));
			} if (isset($_GET['id'])){
				exec("cp storage/groupbuyPic/pic_".$_GET[id].".jpg storage/groupbuyPic/pic_".$groupbuyID.".jpg");
            } else {
				exec("cp storage/groupbuyPic/default_groupbuy.jpg storage/groupbuyPic/pic_".$groupbuyID.".jpg");
			}
        	if (isset($_GET['id']))
        	{
        		$groupbuyInfo = $this->groupbuy->getGroupbuyInfoByID($_GET['id']);
        		$this->groupbuy->updataGoodsList($groupbuyID,$groupbuyInfo['goodslist']);
        	}
            header('Location: /groupbuy/selectGoods?id='.$groupbuyID);
        }
	}

	/**
	 * 团购修改页面
	 * @author Hewr
	 */
	function groupbuy_modify() {
		if (!isset($_GET["id"])) exit(0);
		$this->load->view("base/header", array("page" => "groupbuy_manager_modify"));
		$this->load->view("manager/header", array("mh" => "groupbuy"));
        $this->load->view("manager/groupbuy_header",array("mgh"=>"infoManager","groupbuyID"=>$_GET["id"]));
	//	$this->load->view("manager/shop_header", array("mgh" => "groupbuy"));
		$this->load->view("manager/groupbuy/groupbuy_modify", array("id" => $_GET["id"]));
		$this->load->view("base/footer");
	}

    /**
     * 团购商品
     * @author LJNnaest
     */
    function groupbuy_goods() {
        if (!isset($_GET["id"])) exit(0);
        $this->load->model('goods_model','goods');
        $goodsList = $this->goods->getGoodsListByGroupbuy($_GET["id"]);
        //echo json_encode($goodsList);
        $this->load->view("base/header", array("page" => "groupbuy_manager_goods"));
        $this->load->view("manager/header", array("mh" => "groupbuy"));
        $this->load->view("manager/groupbuy_header",array("mgh"=>"goodsManager","groupbuyID"=>$_GET["id"]));
        $this->load->view("manager/groupbuy/goodslist",array("goodsList"=>$goodsList));
        $this->load->view("base/footer");
    }


    /**
     * 商店商品管理
     * @author LJNnaest
     */
    function shop_goods() {
        if (!isset($_GET["id"])) exit(0);
        $this->load->model('goods_model','goods');
        $goodsList = $this->goods->getGoodsListByShop($_GET["id"]);
        //echo json_encode($goodsList);

        $this->load->view("base/header", array("page" => "shop_manager_goods"));
        $this->load->view("manager/header", array("mh" => "shop"));
        $this->load->view("manager/shop_header",array("mgh"=>"goodsManager","shopID"=>$_GET["id"]));
        $this->load->view("manager/shop/goodslist",array("goodsList"=>$goodsList));
        $this->load->view("base/footer");
    }

	/**
	 * 统计管理水果页面
	 * @author Hewr
	 */
	function statistics_fruit() {
		$this->load->view("base/header", array("page" => "statistics_manager"));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "fruit"));
		$this->load->view("manager/statistics/fruit.php");
		$this->load->view("base/footer");
	}

	/**
	 * 统计管理团购页面
	 * @author LJNanest
	 */
	function statistics_shop() {
        $this->load->model('shop_model','shop');
        $shop_list = $this->shop->getShopListByManagerID($_SESSION['userID']);
        $this->load->view("base/header", array("page" => "statistics_manager"));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "shop"));
		$this->load->view("manager/statistics/shop.php",array('shop_list'=>$shop_list));
		$this->load->view("base/footer");
	}

	/**
	/**
	 * 统计管理团购页面
	 * @author Hewr
	 */
	function statistics_groupbuy() {
        $this->load->model('groupbuy_model','gb');
        $groupbuy_list = $this->gb->getGroupbuyListByUserID($_SESSION['userID']);
        $this->load->view("base/header", array("page" => "statistics_manager"));
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
        
		$this->load->view("base/header", array("page" => "statistics_manager"));
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
        $this->load->view('manager/header',array('mh'=>'examine'));
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
     * 审批通过新鲜事
     * @author ca007
     */
    function passFeed() {
        if(!isset($_REQUEST['relationID'])){
            echo "No relation id";
            return;
        }
        $this->load->model('groupfeed_model','feed');
        $result = $this->feed->passFeed($_REQUEST['relationID']);
        if($result['error']['code'] == 1){
            header('Location: /manager/examine');
        }
        echo json_encode($result);
    }

    /**
     * 关闭新鲜事
     * @author ca007
     */
    function closeFeed() {
        if(!isset($_REQUEST['relationID'])){
            echo "No relation id";
            return;
        }
        $this->load->model('groupfeed_model','feed');
        $result = $this->feed->closeFeed($_REQUEST['relationID']);
        if($result['error']['code'] == 1){
            header('Location: /manager/examine');
        }
        echo json_encode($result);
    }

    /**
     * 删除新鲜事
     * @author ca007
     */
    function delFeed() {
        if(!isset($_REQUEST['relationID'])){
            echo "No relation id";
            return;
        }
        $this->load->model('groupfeed_model','feed');
        $result = $this->feed->delFeed($_REQUEST['relationID']);
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

   /**
     * 商品管理
     * @author LJNnanest
     */
    function goods()
    {
        $this->load->model('goods_model','goods');
        $goodsList = $this->goods->getGoodsListByUser();
        $this->load->view("base/header", array("page" => "goods_manager"));
        $this->load->view("manager/header", array("mh" => "goods"));
        $this->load->view("manager/goods/goodslist", array("goodsList" => $goodsList));
        $this->load->view("base/footer");
        //echo json_encode($goodsList);
    }


    function test()
    {
        $this->load->model('groupbuy_model','goods');
       // $goodsInfo = array('name'=>'samsung S4','detail'=>'nop','price'=>3400,'priceType'=>'元/台','pic'=>'');
       // $this->goods->addGoods($goodsInfo,$_SESSION['userID']);
        //$this->goods->delGoods(1);
        //echo $this->goods->delGoodsAtOBJ('{"1":13}','1');
        echo json_encode($this->goods->getGroupbuyListByUserID(13));
    }
}

?>
