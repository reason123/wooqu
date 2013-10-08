<?php
@session_start();

class Shop extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	/**
	 * 生成商店列表
	 * @author xanda
	 * 
	 */
	function shoplist() {
		$this->load->model('shop_model','shop');

		$this->load->view('base/mainnav',array('page'=>'shoplist'));
		if (isset($_SESSION['myGroup']))
			$list = $this->shop->getShopListByGroup($_SESSION['myGroup']);
		else
			$list = array();
		$this->load->view('shop/shoplist', array('title'=>'商店列表','link'=>'shop','list'=>$list));
        $this->load->view('base/footer');
	}

	/**
	 * 生成商店详情页面
	 * @author xanda
	 */
	public function showShop(){
		$this->load->model('shop_model','shop');
		
		$goodsList = $this->shop->getGoodListByShop($_GET['ID']);
		$actList = $this->shop->getActListByShop($_GET['ID']);
		$shopInfo = $this->shop->getShopInfoByID($_GET['ID']);

		$this->load->view('base/mainnav',array('page'=>'showshop'));

		$this->load->view('shop/showshop',array('shopInfo'=>$shopInfo,'goodsList'=>$goodsList,'actList'=>$actList));
		$this->load->view('base/footer');
	}

	/**
	 * 提交订单
	 * @param shopID, goods
	 * @author Hewr
	 * @author xanda
	 */
	function newOrder() {
		if (!isset($_SESSION["loginName"])) {
			$ret = array("error"=>"未登录");
			echo json_encode($ret);
			return;
		} else {
			$userID = $_SESSION["userID"];
		}

		$shopid = intval($_POST["shopID"]);
		$order = json_decode($_POST["order"]);
		$orderSize = count($order);

		if ($orderSize == 0) {
			$ret = array("error"=>"没有选择商品");
			echo json_encode($ret);
			return;
		}

		$this->load->model('shop_model', 'shop');
		$shopInfo = $this->shop->getShopInfoByID($shopid);
		$this->load->model('fruit_model', 'fruit');
		if ($shopInfo['fruit'] == 1)
			$goodsList = $this->fruit->getFruitListByShop($shopid);
		else
			$goodsList = $this->shop->getGoodListByShop($shopid);
		$goodsTrans = array();

		foreach ($goodsList as $good) {
			$goodsTrans[$good['ID']] = array($good['name'], $good['price']);
		}

		$goodsSize = count($goodsList);
		if ($goodsSize == 0) {
			$ret = array("error"=>"商店不存在");
			echo json_encode($ret);
			return;
		}

		
		$shopname = $shopInfo["name"];

		if ($shopInfo["available"] == 0) {
			$ret = array("error"=>"商店已过期");
			echo json_encode($ret);
			return;
		}

		$amount = 0;
		$orderTrans = array();
		foreach($order as $good => $num) {
		//for ($i = 0; $i < $orderSize; ++$i) {
		//while($good= key($order)) {
			$idx = intval($good);
			if (is_null($goodsTrans[$idx])) {
				$ret = array("error"=>"商品序号非法");
				echo json_encode($ret);
				return;
			}

			$price = $goodsTrans[$idx][1];

			

			if ($num <= 0 || $num > 99999) {
				$ret = array("error"=>"购买数量非法");
				echo json_encode($ret);
				return;
			}

			array_push($orderTrans, array($good, $goodsTrans[$idx][0], $price, $num));

			$amount += doubleval($price) * $num;
			//next($order);
		}
		//for ($i = 0; $i < $orderSize; ++$i)
		foreach($orderTrans as $detail)
			$this->shop->plusTotal($detail[0], $detail[3], $shopInfo['fruit']);
		
		$this->shop->submitOrder($shopid, $shopname, $userID, $orderTrans, $amount);
		$ret = array( "content"=>"成功提交！", "error"=>"" );
		echo json_encode($ret);
	}


	/**
	 * API:查看所有团购订单
	 * return list 订单（详细信息）
	 * @author Hewr
	 * @author xanda
	 */
	function getAllOrders() {
		if (!isset($_SESSION["loginName"])) {
			$ret = array("error"=>"未登录");
			echo json_encode($ret);
			return;
		} else $userID = $_SESSION["userID"];
		$this->load->model('shop_model', 'shop');
		$order = $this->shop->getAllOrders($userID);
		echo json_encode($order);
	}

	/**
	* 添加商店
	* @author xanda
	* @param 
	*/
	public function addShop() {
		if (!isset($_SESSION["userID"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userID = $_SESSION["userID"];

		if (!isset($_POST["name"]) || !isset($_POST["address"]) ||
			!isset($_POST["phone"]) || !isset($_POST["detail"]) ||
			!isset($_POST["type"])) {
			echo json_encode(array("error"=>"信息不全"));
			return;
		}

		$type = intval($_POST["type"]);
		$this->load->model('shop_model', 'shop');
		$detail = array("name" => $_POST["name"],
			"address" => $_POST["address"],
			"phone" => $_POST["phone"],
			"detail" => $_POST["detail"],
			"type" => $type);

		$shopID = $this->shop->addShop($detail, $userID);
		$this->shop->addShopGroup($shopID,$_POST["groupID"]);
		echo json_encode(array("error"=>""));
	}

	/**
	* 删除商店
	* @author xanda
	* @param 
	*/
	public function deleteShopById() {
		if (!isset($_SESSION["userID"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userID = $_SESSION["userID"];

		if (!isset($_POST["id"])) {
			echo json_encode(array("error"=>"信息不全"));
			return;
		}

		$id = intval($_POST["id"]);
		$this->load->model('shop_model', 'shop');
		$this->shop->deleteShopById($id);
		echo json_encode(array("error"=>""));
	}

	/**
	 * API:修改指定商店
	 * @param post方式 shop-information
	 * @author Hewr
	 * @author xanda
	 */
	function modifyShopById() {
		if (!isset($_SESSION["userID"])) {
			echo json_encode(array("error"=>"没有登录"));
			return;
		}
		$userID = $_SESSION["userID"];
		if (!isset($_POST["content"])) {
			echo json_encode(array("error"=>"内容错误"));
			return;
		}

		$shop = (array) json_decode($_POST["content"]);
		$this->load->model("shop_model", "shop");
		$this->shop->modifyShop($shop, $userID);
		echo json_encode(array("error"=>""));
	}

	function addGoods()
	{
		$this->load->model("shop_model", "shop");
		$this->shop->addGoods($_POST["shopID"],$_POST["name"],$_POST["price"],$_POST["detail"]);
		echo json_encode(array("error"=>""));
	}

	function delGoods()
	{
		$this->load->model("shop_model", "shop");
		$this->shop->delGoods($_POST["ID"]);
		echo json_encode(array("error"=>""));
	}

	function test()
	{
		$this->load->model("shop_model", "shop");
		echo $this->shop->delGoods(159);
	}
}

?>