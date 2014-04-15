<?php
@session_start();

class Groupbuy extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	/**
	 * 团购页面后台
	 * @author Hewr
	 */
	function backend() {
		$this->load->model('groupbuy_model', 'groupbuy');
		//$res = $this->groupbuy->wtf();

		$this->load->view('base/header', array('page' => 'backend'));
        $this->load->view('groupbuy/backend', array('res' => json_encode($res)));
        $this->load->view('base/footer');
	}

	/**
	 * API:返回所有团购商店
	 * @author Hewr
	 */
	function getAllShops() {
		$this->load->model('groupbuy_model', 'groupbuy');
		$shops = $this->groupbuy->getAllShops();
		echo json_encode($shops);
	}

	/**
	 * API:返回所有当前用户所创建团购商店
	 * @author Hewr
	 */
	function getMyShops() {
		if (!isset($_SESSION["loginName"])) return;
		$username = $_SESSION["loginName"];
		$this->load->model('groupbuy_model', 'groupbuy');
		$shops = $this->groupbuy->getGroupbuyByUserName($username);
		echo json_encode($shops);
	}

	/**
	 * API:返回指定团购商店
	 * @param post方式 shopID
	 * @author Hewr
	 */
	function getShopById() {
		$id = $_REQUEST["id"];
		$this->load->model('groupbuy_model', 'groupbuy');
		$shop = $this->groupbuy->getShopById($id);
		echo json_encode($shop[0]);
	}

	/**
	 * API:删除指定团购商店
	 * @param post方式 shopID
	 * @author Hewr
	 */
	function deleteShopById() {
		if (!isset($_SESSION["loginName"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		if (!isset($_POST["id"])) {
			echo json_encode(array("error"=>"没有ID"));
			return;
		}
		$id = intval($_POST["id"]);
		$this->load->model("groupbuy_model", "groupbuy");
		$this->groupbuy->deleteShopById($id, $userName);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:修改指定团购商店
	 * @param post方式 shop-information
	 * @author Hewr
	 */
	function modifyShopById() {
		if (!isset($_SESSION["loginName"])) {
			//echo json_encode(array("error"=>"没有登录"));
			echo "没有登录";
			return;
		}
		$userName = $_SESSION["loginName"];
		//$shop = (array) json_decode($_POST["content"]);
		$shop = array(
			"id"=>$_REQUEST["id"],
			"title"=>$_REQUEST["title"],
			"deadline"=>$_REQUEST["deadlinedate"]." ".$_REQUEST["deadlinetime"],
			"pickuptime"=>$_REQUEST["pickuptimedate"]." ".$_REQUEST["pickuptimetime"],
			"howtopay"=>$_REQUEST["howtopay"],
//			"source"=>$_REQUEST["source"],
//			"comment"=>$_REQUEST["comment"],
			"illustration"=>$_REQUEST["illustration"],
			"status"=>$_REQUEST["status"],
			"groups"=>$_REQUEST["groups"],
//            "orderMessage"=>$_REQUEST["orderMessageList"]
		);
		$this->load->model("groupbuy_model", "groupbuy");
		$shopID = intval($shop["id"]);
		if (!$this->groupbuy->isOwnShop($shopID)) {
			echo json_encode(array("error"=>"illegal account"));
			return;
		}
		/*$group_list = $this->groupbuy->splitGroupStr($shop["groups"]);
		if (count($group_list) == 0) {
			echo json_encode(array("error"=>"illegal groups"));
			return;
		}
		$this->groupbuy->clearShopGroup($shopID);
		for ($i = 1; $i < count($group_list); ++$i) $this->groupbuy->shopJoinGroup($shopID, $group_list[$i]);*/
		$this->groupbuy->modifyShop($shop, $userName);
		$picPath = "/storage/groupbuyPic/pic_".$shopID.".jpg";
		if ($_FILES['pic']['size'] > 0) {
			$photo = $_FILES['pic'];
			move_uploaded_file($photo['tmp_name'], substr($picPath, 1, strlen($picPath)));
		}
		//echo json_encode(array("error"=>""));
        header('Location: /groupbuy/selectGoods?id='.$shopID);
	}

	/**
	 * API:新增一个团购商店
	 * @author Hewr
	 */
	function addShop() {
		if (!isset($_SESSION["loginName"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		$this->load->model('groupbuy_model', 'groupbuy');
		$shop = array("title"=>"团购名称", "status"=>"1", "comment"=>"团购备注", "howtopay"=>"支付方式", "illustration"=>"团购描述", "deadline"=>date("Y-m-d H:i:s", mktime()), "pickuptime"=>date("Y-m-d H:i:s", mktime()), "source"=>"货源");
		$this->groupbuy->insertShop($shop, $userName);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:返回指定商店的所有商品
	 * @param post方式 shopID
	 * @author Hewr
	 */
	function getCargoByShopId() {
		$shopid = $_POST["shopid"];
		$this->load->model('groupbuy_model', 'groupbuy');
		$cargo = $this->groupbuy->getCargoByShopId($shopid);
		echo json_encode($cargo);
	}

	/**
	 * API:新建一个商品
	 * @param post方式 $shopID
	 * @author Hewr
	 */
	function addCargo() {
		if (!isset($_SESSION["loginName"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		if (!isset($_POST["shopId"])) {
			echo json_encode(array("error"=>"没有ID"));
			return;
		}
		$shopId = intval($_POST["shopId"]);
		$this->load->model('groupbuy_model', 'groupbuy');
		$cargo = array("shopid"=>$shopId, "title"=>"商品名称", "price"=>0, "illustration"=>"商品描述");
		$res = $this->groupbuy->insertCargo($cargo, $userName);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:修改指定商品
	 * @param post方式 cargo-information
	 * @author Hewr
	 */
	function modifyCargo() {
		if (!isset($_SESSION["loginName"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		if (!isset($_POST["content"])) {
			echo json_encode(array("error"=>"内容错误"));
			return;
		}
		$cargo = (array) json_decode($_POST["content"]);
		$this->load->model("groupbuy_model", "groupbuy");
		$this->groupbuy->modifyCargo($cargo, $userName);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:删除指定商品
	 * @param post方式 cargoID
	 * @author Hewr
	 */
	function deleteCargoById() {
		if (!isset($_SESSION["loginName"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		if (!isset($_POST["id"])) {
			echo json_encode(array("error"=>"没有ID"));
			return;
		}
		$id = $_POST["id"];
		$this->load->model("groupbuy_model", "groupbuy");
		$this->groupbuy->deleteCargoById($id, $userName);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:修改指定商品图片
	 * @param post方式 cargoID photo
	 * @author Hewr
	 */
	function uploadCargoPhoto() {
		$id = $_GET["id"];
		$photo = $_FILES["changeCargoPhoto"];
		$name = "storage/goodsPic/pic_".$id.".jpg";
		move_uploaded_file($photo['tmp_name'],$name);
		echo "<script>parent.finishUploadingPhoto();</script>";
	}

	/**
	 * API:提交订单
	 * @param post方式 shopid 购物清单list
	 * @author Hewr
	 */
	function submitOrder() {
        $this->load->model('user_model', 'user');
        if(isset($_POST['realname']) && isset($_POST['cellphone']) && isset($_POST['address'])
           && ($_POST['realname'] != '') && ($_POST['cellphone'] != '' && $_POST['address'] != '')){
            $this->user->improveInformation($_POST['realname'],$_POST['cellphone'],$_POST['address']);
        }else if($_SESSION['completed'] == 'None'){
            $ret = array('error'=>'请补全您的信息');
            echo json_encode($ret);
            return ;
        }
		if (!isset($_SESSION["loginName"])) {
			$ret = array("error"=>"未登录");
			echo json_encode($ret);
			return;
		} else $loginName = $_SESSION["loginName"];
		$shopid = intval($_POST["id"]);
		$order = json_decode($_POST["list"]);
		$orderSize = count($order);
		if ($orderSize == 0) {
			$ret = array("error"=>"没有选择商品");
			echo json_encode($ret);
			return;
		}
		$comment = "";
		if (isset($_POST["comment"])) $comment = $_POST["comment"];

		$this->load->model('goods_model','goods');
		$cargo = $this->goods->getGoodsListByGroupbuy($shopid);
		//$cargo = $this->groupbuy->getCargoByShopId($shopid);
		$cargoSize = count($cargo);
		if ($cargoSize == 0) {
			$ret = array("error"=>"商店不存在");
			echo json_encode($ret);
			return;
		}

		$this->load->model('groupbuy_model', 'groupbuy');
		$shop = $this->groupbuy->getShopById($shopid);
		$shopname = $shop[0]["title"];
        $shopAlipay = $shop[0]["alipay"];
		if ($shop[0]["status"] == 0) {
			$ret = array("error"=>"商店已过期");
			echo json_encode($ret);
			return;
		}

		$amount = 0;
		for ($i = 0; $i < $orderSize; ++$i) {
			$idx = intval($order[$i][0]);
            if ($order[$i][2] == "") $type = ""; else  $type = "(".$order[$i][2].")";
			if ($idx < 0 || $idx >= $cargoSize) {
				$ret = array("error"=>"商品序号非法");
				echo json_encode($ret);
				return;
			}
			$order[$i][2] = $cargo[$idx]["name"].$type;
			$order[$i][0] = intval($cargo[$idx]["ID"]);
			if ($order[$i][0] == -1) {
				$ret = array("error"=>"商品重复");
				echo json_encode($ret);
				return;
			}
			$price = $cargo[$idx]["price"];
			$num = intval($order[$i][1]);
			if ($num <= 0 || $num > 99999) {
				$ret = array("error"=>"购买数量非法");
				echo json_encode($ret);
				return;
			}
			$amount += doubleval($price) * $num;
			//标记该商品已被处理
			$cargo[$idx]["id"] = -1;
		}

		for ($i = 0; $i < $orderSize; ++$i)	
			//$this->groupbuy->plusCargo($order[$i][0], $order[$i][1]);
			$this->goods->increaseGoodsTotal($order[$i][0], $order[$i][1]);
		
		$orderID = $this->groupbuy->submitOrder($shopid, $shopname, $loginName, $order, $amount, $comment,$_POST["orderMessage"]);
        if ($shopAlipay == "ON_ONLY" || ($shopAlipay =="ON" && $_POST['payType'] == 'ON')) {
            $this->groupbuy->setGroupbuyOrderByID($orderID,'UNPAID')
		    $ret = array( "content"=>"成功提交！", "error"=>"", "href"=>"/alipay/do_alipay_groupbuy?id=".$orderID );
        } else {
            $this->groupbuy->setGroupbuyOrderByID($orderID,'OFF')
		    $ret = array( "content"=>"成功提交！", "error"=>"", "href"=>"/userpage/groupbuyOrder" );
        }
		echo json_encode($ret);
	}

	/**
	 * API:删除某张订单
	 * @author Hewr
	 */
	function deleteOrder() {
		if (!isset($_SESSION["loginName"])) {
			$ret = array("error"=>"未登录");
			echo json_encode($ret);
			return;
		} else $loginName = $_SESSION["loginName"];
		if (!isset($_POST["id"])) {
			$ret = array("error"=>"无订单号");
			echo json_encode($ret);
			return;
		} else $id = intval($_POST["id"]);
		$this->load->model('groupbuy_model', 'groupbuy');
		$order = $this->groupbuy->getOrderById($id);
		if (count($order) == 0) {
			$ret = array("error"=>"订单号错误");
			echo json_encode($ret);
			return;
		}
		$order = $order[0];
		if ($order["username"] != $loginName) {
			$ret = array("error"=>"你没有这张订单");
			echo json_encode($ret);
			return;
		}
		if ($order["del"] != 0) {
			$ret = array("error"=>"订单已删除");
			echo json_encode($ret);
			return;
		}
		$shop = $this->groupbuy->getShopById($order["shopid"]);
		if ($shop[0]["status"] == 0) {
			$ret = array("error"=>"订单已过期");
			echo json_encode($ret);
			return;
		}

		$this->load->model('goods_model','goods');
		$list = $order["list"]; $listSize = count($list);
		for ($i = 0; $i < $listSize; ++$i) 
			//$this->groupbuy->plusCargo($list[$i][0], -intval($list[$i][1]));
			$this->goods->increaseGoodsTotal($list[$i][0], -intval($list[$i][1]));
		$this->groupbuy->deleteOrderById($id);

		$ret = array( "content"=>"成功删除！", "error"=>"" );
		echo json_encode($ret);
	}

	/**
	 * API:查看所有团购订单
	 * return list 订单（详细信息）
	 * @author Hewr
	 */
	function getAllOrders() {
		if (!isset($_SESSION["loginName"])) {
			$ret = array("error"=>"未登录");
			echo json_encode($ret);
			return;
		} else $loginName = $_SESSION["loginName"];
		$this->load->model('groupbuy_model', 'groupbuy');
		$order = $this->groupbuy->getAllOrders($loginName);
		echo json_encode($order);
	}

    /**
     * 获取某团购所有订单
     * @author ca007
     */
    function vieworder(){
        if (isset($_GET['OM'])) $OM = $_GET['OM']; else $OM = "LJNisHandsome!";
        $this->load->model('groupbuy_model','gb');
        $order_list = $this->gb->getOrderByGbID($_REQUEST['groupbuyID']);
        $orderMessageList = array();
        foreach ($order_list as $order)
        {
            array_push($orderMessageList,$order['orderMessage']);
        }
        $orderMessageList = array_unique($orderMessageList);
        asort($orderMessageList);
        $groupbuyInfo = $this->gb->getGroupbuyInfoByID($_REQUEST['groupbuyID']);
        $total_counter = array();
        foreach($order_list as $key => $order){
            if($OM != "LJNisHandsome!" && $OM != $order['orderMessage'])
                continue;
            foreach($order['list'] as $i => $good){
                $goodID = $good[0];
                $goodNum = $good[1];
                $goodName = $good[2];
                if(array_key_exists($goodName,$total_counter)){
                    $total_counter[$goodName]['total'] += $goodNum;
                }else{
                    $total_counter[$goodName] = array();
                    $total_counter[$goodName]['total'] = $goodNum;
                    $total_counter[$goodName]['name'] = $goodName;
                }
            }
        }

        function cmp_counter($a, $b){
            return $b['total'] - $a['total'];
        }
        usort($total_counter, 'cmp_counter');
        $this->load->view('base/header',array('page'=>'gborder'));
		$this->load->view("manager/header", array("mh" => "statistics"));
		$this->load->view("manager/statistics_header", array("mgh" => "groupbuy"));
        $this->load->view('groupbuy/vieworder',array('gbID'=>$_REQUEST['groupbuyID'],'order_list'=>$order_list, 'groupbuyInfo'=>$groupbuyInfo, 'orderMessageList'=>$orderMessageList,'OM'=>$OM,'total_counter'=>$total_counter));
        $this->load->view('base/footer');
    }

    function get_csv(){
        $this->load->model('groupbuy_model','gb');
        $order_list = $this->gb->getOrderByGbID($_REQUEST['groupbuyID']);
        $orderMessageList = array();
        foreach ($order_list as $order)
        {
            array_push($orderMessageList,$order['orderMessage']);
        }
        $orderMessageList = array_unique($orderMessageList);
        asort($orderMessageList);
        $groupbuyInfo = $this->gb->getGroupbuyInfoByID($_REQUEST['groupbuyID']);
        $total_counter = array();
        foreach($order_list as $key => $order){
            foreach($order['list'] as $i => $good){
                $goodID = $good[0];
                $goodNum = $good[1];
                $goodName = $good[2];
                if(array_key_exists($goodName,$total_counter)){
                    $total_counter[$goodName]['total'] += $goodNum;
                }else{
                    $total_counter[$goodName] = array();
                    $total_counter[$goodName]['total'] = $goodNum;
                    $total_counter[$goodName]['name'] = $goodName;
                }
            }
        }

        function cmp_counter($a, $b){
            return $b['total'] - $a['total'];
        }
        usort($total_counter, 'cmp_counter');
        $str = "班级,姓名,地址,联系方式,总金额,详细信息,选项,备注\r\n";
        //$str = iconv('utf-8', 'gb2312', $str);
        foreach($order_list as $key => $order){
            $oclass = $order['class'];
            //$oclass = iconv('utf-8', 'gb2312', $oclass);
            $orealname = $order['realName'];
            //$orealname = iconv('utf-8', 'gb2312', $orealname);
            $oaddress = $order['address'];
            //$oaddress = iconv('utf-8', 'gb2312', $oaddress);
            $ophone = $order['phoneNumber'];
            //$ophone = iconv('utf-8', 'gb2312', $ophone);
            $oamount = $order['amount'];
            //$oamount = iconv('utf-8', 'gb2312', $oamount);
            $odetail = '';
            foreach($order['list'] as $key => $unit){
                $odetail = $odetail.$unit[2].":".$unit[1].";";
            }
            //$odetail = iconv('utf-8', 'gb2312', $odetail);
            $oordermessage = $order['orderMessage'];
            //$oordermessage = iconv('utf-8', 'gb2312', $oordermessage);
            $ocomment = $order['comment'];
            //$ocomment = iconv('utf-8', 'gb2312', $ocomment);
            $str .= $oclass.','.$orealname.','.$oaddress.','.$ophone.','.$oamount.','.$odetail.','.$oordermessage.','.$ocomment."\r\n";
        }
        $str .= "\r\n"."\r\n";
        $str .= "商品名,总量\r\n";
        foreach($total_counter as $key => $counter){
            $str .= $counter['name'].','.$counter['total']."\r\n";
        }
        //echo $str;
        export_csv($groupbuyInfo['title'].'订单统计.csv', $str);
    }

	/**
	 * 群发短信API
	 * @author daiwentao
	 */
	function smsGroupbuy(){
        $this->load->model('groupbuy_model','gb');
		$checkedList = explode("|", $_REQUEST['checkedID']);
        $numList = array();
        foreach($checkedList as $id){
			$order = $this->gb->getOrderAndPhoneByID($id);
			if (isset($order["shopid"]) && isset($order["phoneNumber"]) && $order["shopid"] == $_REQUEST['groupbuyID']) {
				$numList[] = $order["phoneNumber"];
			}
		}
        $this->load->model('sms_model','sms');
        $res = $this->sms->sendSms($numList,$_REQUEST['content']);
		echo json_encode($res);
    }

	/**
	 * 团购页面主页
	 * @author Hewr
	 */
    function index() {
		$this->load->model('groupbuy_model', 'groupbuy');
		$list = $this->groupbuy->getAllShops();
		
        $this->load->view('base/header',array('page'=>'groupbuy'));
        $this->load->view('groupbuy/groupBuyManager', array("list"=>$list));
        $this->load->view('base/footer');
	}

	/**
	 * 查看商品页面
	 * @author Hewr
	 */
	function groupInfo() {
		$groupID = $_GET['id'];
        $this->load->model('groupbuy_model','groupbuy');
        $orderMessageList = $this->groupbuy->getOrderMessageList($groupID);
        $groupbuyInfo = $this->groupbuy->getGroupbuyInfoByID($groupID);
        $this->load->view('base/header',array('page'=>'groupinfo','type'=>'groupbuy'));
        $this->load->view('groupbuy/groupInfo', array('groupID' => $groupID,'orderMessageList'=>$orderMessageList,'groupbuyInfo'=>$groupbuyInfo));
        $this->load->view('base/footer');
	}
    
	/**
	 * 新建团购
	 * @author LJNanest Hewr
	 */
	function newGroupbuy()
	{
		$this->load->library('form_validation');
        $this->form_validation->set_rules('title','title','required'); 
        $this->form_validation->set_rules('howtopay','howtopay','required'); 
//        $this->form_validation->set_rules('source','source','required'); 
//        $this->form_validation->set_rules('comment','comment','required'); 
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
//        	$_REQUEST['comment'] = $groupbuyInfo['comment'];
        	$_REQUEST['howtopay'] = $groupbuyInfo['howtopay'];
//        	$_REQUEST['source'] = $groupbuyInfo['source'];
        	$_REQUEST['illustration'] = $groupbuyInfo['illustration'];
            $_REQUEST['group_list'] = $str;
            $_REQUEST['orderMessageList'] = $groupbuyInfo['orderMessage'];
        }
        if($this->form_validation->run() == FALSE){
        	
        	$this->load->view('base/header',array('page'=>'newgroupbuy'));
            $this->load->view('manager/groupbuy/newgroupbuy');
            $this->load->view('base/footer');
        }else{        	
        	$shop = array("title"=>cleanString($_REQUEST['title']),
                         "status"=>"1",
//                          "comment"=>cleanString($_REQUEST['comment']),
                          "howtopay"=>cleanString($_REQUEST['howtopay']),
                          "illustration"=>cleanString($_REQUEST['illustration']),
                          "deadline"=>cleanString($_REQUEST['act_end_date']),
                          "pickuptime"=>cleanString($_REQUEST['sign_end_date']), 
//                          "source"=>cleanString($_REQUEST['source']),
						  "group_list"=>cleanString($_REQUEST['group_list']),
//                          "orderMessage"=>$_REQUEST['orderMessageList']
                          );
        	//echo $_REQUEST['act_end_date'];
        	$groupbuyID = $this->groupbuy->insertShop($shop,$_SESSION['loginName']);
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
        		//echo $groupbuyInfo['goodslist'];
        		$this->groupbuy->updataGoodsList($groupbuyID,$groupbuyInfo['goodslist']);
        	}
            header('Location: /groupbuy/selectGoods?id='.$groupbuyID);
        }
	}
    
	function modGoods()
	{
		if (!isset($_GET['groupbuyID'])) return;
		if (isset($_GET['goodsID']))
		{
			$this->load->model('goods_model','goods');
			$this->load->model('groupbuy_model','groupbuy');
			if (!isset($_REQUEST['price']))
			{
				$groupbuyInfo = $this->groupbuy->getGroupbuyInfoByID($_GET['groupbuyID']);
				//echo json_encode($groupbuyInfo);
				$goodsList = json_decode($groupbuyInfo['goodslist'],true);
				$_REQUEST['price']=$goodsList[$_GET['goodsID']];
			}
			$this->load->library('form_validation');
       	    $this->form_validation->set_rules('price','price','required|numeric');
        	if($this->form_validation->run() == FALSE){
	            $this->load->view('base/header',array('page'=>'groupbuy_modgoods'));
	            $this->load->view("manager/header", array("mh" => "groupbuy"));
       			$this->load->view("manager/groupbuy_header",array("mgh"=>"goodsManager","groupbuyID"=>$_GET["groupbuyID"]));
            	$this->load->view('manager/groupbuy/modgoods');
            	$this->load->view('base/footer');
        	}else{
            	 $this->goods->addGoodsAtGroupbuy($_GET['groupbuyID'], $_GET['goodsID'], $_REQUEST['price']);
            	header('Location: /manager/groupbuy_goods?id='.$_GET['groupbuyID']);	
        	}
		} else 
			header('Location: /manager/groupbuy_goods?id='.$_GET['groupbuyID']);	
	}

	function delGoods()
	{
		if (!isset($_GET['groupbuyID'])) return;
		if (isset($_GET['goodsID']))
		{
			$this->load->model('goods_model','goods');
			$this->goods->delGoodsAtGroupbuy($_GET['groupbuyID'],$_GET['goodsID']);
		}
		header('Location: /manager/groupbuy_goods?id='.$_GET['groupbuyID']);
	}

	function getGoodsList()
	{
		$this->load->model('goods_model','goods');
		echo json_encode($this->goods->getGoodsListByGroupbuy($_GET['groupbuyID']));
	}

	/** 
      * 我的商品列表
      * @auther LJNanest
      */
    function selectGoods()
	{
		if (!isset($_GET['id'])) return;
		$this->load->model('goods_model','goods');
        $goodsList = $this->goods->getGoodsListByUser();
        $this->load->model('groupbuy_model','groupbuy');
        $groupbuyInfo = $this->groupbuy->getGroupbuyInfoByID($_GET['id']);

        $goods_sign = json_decode($groupbuyInfo['goodslist'],true);
        $this->load->view("base/header", array("page" => "selectgoods_groupbuy"));
        $this->load->view("manager/header", array("mh" => "groupbuy"));
        $this->load->view("manager/groupbuy_header",array("mgh"=>"goodsManager","groupbuyID"=>$_GET["id"]));
        $this->load->view("manager/groupbuy/selectgoods", array("goodsList" => $goodsList,"goods_sign" =>$goods_sign,"groubuyID"=>$_GET["id"]));
        $this->load->view("base/footer");	
	}
    /**
      * 卸载我的商品 （供selectGoods里使用）
      * @auther LJNanest
      */
	function delMyGoods()
	{
		if (!isset($_REQUEST['groupbuyID'])) return;
		if (!isset($_REQUEST['goodsID'])) 
		{
			header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
			return;
		}
		$this->load->model('goods_model','goods');
        $this->goods->delGoodsAtGroupbuy($_REQUEST['groupbuyID'],$_REQUEST['goodsID']);
        //header('Location: /groupbuy/selectGoods?id='.$_GET['groupbuyID']);
	}
    
    /** 
      * 添加我的商品入团购里 （供selectGoods里使用）
      * @auther LJNnaest
      */
	function addMyGoods()
	{
		if (!isset($_REQUEST['groupbuyID'])) return;
		if (!isset($_REQUEST['goodsID'])) 
		{
			header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
			return;
		}

		$this->load->model('goods_model','goods');
        $this->goods->addGoodsAtGroupbuy($_REQUEST['groupbuyID'],$_REQUEST['goodsID'],-1);
        //header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
	}

	
	function addOrderMessage()
    {
		if (!isset($_REQUEST['gbID'])) return;
		$this->load->model('groupbuy_model','groupbuy');
        $this->groupbuy->addOrderMessage($_REQUEST['gbID'],$_REQUEST['message']);
        //header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
        
	}
    
	function delOrderMessage()
    {
        if (!isset($_REQUEST['gbID'])) return;
        $this->load->model('groupbuy_model','groupbuy');
        $this->groupbuy->delOrderMessage($_REQUEST['gbID'],$_REQUEST['message']);
        //header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
	}

	function getOrderMessageList()
    {
        if (!isset($_REQUEST['gbID'])) return;
        $this->load->model('groupbuy_model','groupbuy');
        echo json_encode($this->groupbuy->getOrderMessageList($_REQUEST['gbID']));
        //header('Location: /groupbuy/selectGoods?id='.$_REQUEST['groupbuyID']);
	}
    
/*    function test()
	{
        echo 21;
		$this->load->model('groupbuy_model','groupbuy');
        $this->groupbuy->deleteOrderById(1290);
        echo 23;
	}*/

    function updateTotal()
    {
		$this->load->model('groupbuy_model','groupbuy');
        $this->groupbuy->updateFeedTotal();
        echo "OK!";
    }
}

?>
