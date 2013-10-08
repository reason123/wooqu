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

		$this->load->view('base/mainnav', array('page' => 'backend'));
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
		$id = $_POST["id"];
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
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userName = $_SESSION["loginName"];
		if (!isset($_POST["content"])) {
			echo json_encode(array("error"=>"内容错误"));
			return;
		}
		$shop = (array) json_decode($_POST["content"]);
		$this->load->model("groupbuy_model", "groupbuy");
		$shopID = intval($shop["id"]);
		if (!$this->groupbuy->isOwnShop($shopID)) {
			echo json_encode(array("error"=>"illegal account"));
			return;
		}
		$group_list = $this->groupbuy->splitGroupStr($shop["groups"]);
		if (count($group_list) == 0) {
			echo json_encode(array("error"=>"illegal groups"));
			return;
		}
		$this->groupbuy->clearShopGroup($shopID);
		for ($i = 1; $i < count($group_list); ++$i) $this->groupbuy->shopJoinGroup($shopID, $group_list[$i]);
		$this->groupbuy->modifyShop($shop, $userName);
		echo json_encode(array("error"=>""));
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

		$this->load->model('groupbuy_model', 'groupbuy');
		$cargo = $this->groupbuy->getCargoByShopId($shopid);
		$cargoSize = count($cargo);
		if ($cargoSize == 0) {
			$ret = array("error"=>"商店不存在");
			echo json_encode($ret);
			return;
		}

		$shop = $this->groupbuy->getShopById($shopid);
		$shopname = $shop[0]["title"];
		if ($shop[0]["status"] == 0) {
			$ret = array("error"=>"商店已过期");
			echo json_encode($ret);
			return;
		}

		$amount = 0;
		for ($i = 0; $i < $orderSize; ++$i) {
			$idx = intval($order[$i][0]);
			if ($idx < 0 || $idx >= $cargoSize) {
				$ret = array("error"=>"商品序号非法");
				echo json_encode($ret);
				return;
			}
			$order[$i][2] = $cargo[$idx]["title"];
			$order[$i][0] = intval($cargo[$idx]["id"]);
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

		for ($i = 0; $i < $orderSize; ++$i)	$this->groupbuy->plusCargo($order[$i][0], $order[$i][1]);
		
		$this->groupbuy->submitOrder($shopid, $shopname, $loginName, $order, $amount, $comment);
		$ret = array( "content"=>"成功提交！", "error"=>"" );
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

		$list = $order["list"]; $listSize = count($list);
		for ($i = 0; $i < $listSize; ++$i) $this->groupbuy->plusCargo($list[$i][0], -intval($list[$i][1]));
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
        $this->load->model('groupbuy_model','gb');
        $order_list = $this->gb->getOrderByGbID($_REQUEST['groupbuyID']);
        $this->load->view('base/mainnav',array('page'=>'gborder'));
        $this->load->view('groupbuy/vieworder',array('order_list'=>$order_list));
        $this->load->view('base/footer');
    }

	/**
	 * 团购页面主页
	 * @author Hewr
	 */
    function index() {
		$this->load->model('groupbuy_model', 'groupbuy');
		$list = $this->groupbuy->getAllShops();
		
        $this->load->view('base/mainnav',array('page'=>'groupbuy'));
        $this->load->view('groupbuy/groupBuyManager', array("list"=>$list));
        $this->load->view('base/footer');
	}

	/**
	 * 查看商品页面
	 * @author Hewr
	 */
	function groupInfo() {
		$groupID = $_GET['id'];

        $this->load->view('base/mainnav',array('page'=>'groupinfo'));
        $this->load->view('groupbuy/groupInfo', array('groupID' => $groupID));
        $this->load->view('base/footer');
	}

}

?>
