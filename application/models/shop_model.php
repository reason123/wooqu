<?php

class shop_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 获取当前群组的水果店列表
	 * @param array $groupList 群组ID列表
	 * @author xanda
	 * @return list 水果店列表
	 */
	function getShopListByGroup($groupList) {
		/*$sql = "SELECT DISTINCT shop.ID, name, phone, address, detail, createTime, available
				FROM shop, shop_area
				WHERE shop.ID = shop_area.shopID AND shop_area.areaID =?
				ORDER BY available DESC";*/
		$sql = "SELECT DISTINCT shop_list.ID, name, phone, address, detail, createTime, available
				FROM shop_list, shop_group
				WHERE shop_list.ID = shop_group.shopID AND shop_list.fruit<>1 AND (";
		$arrayID = array();
		foreach($groupList as $i => $group) {
			$sql .= "(groupID=?) OR ";
			array_push($arrayID,$i);
		}
		$sql = substr($sql,0,strlen($sql) - 4);
		$sql .=	")ORDER BY available DESC";
		//$shopList = $this->db->query($sql,array($areaID))->result_array();
		$shopList = $this->db->query($sql,$arrayID)->result_array();
		return $shopList;
	}

	/**
	 * 获取当前群组的水果店列表
	 * @param array $groupList 群组ID列表
	 * @author xanda
	 * @return list 水果店列表
	 */
	function getShopListByUser($userID) {
		/*$sql = "SELECT DISTINCT shop.ID, name, phone, address, detail, createTime, available
				FROM shop, shop_area
				WHERE shop.ID = shop_area.shopID AND shop_area.areaID =?
				ORDER BY available DESC";*/
		$sql = "SELECT DISTINCT shop_list.ID, name, phone, address, detail, createTime, available, fruit
				FROM shop_list, shop_group
				WHERE shop_list.userID = ?
				AND shop_list.available = 1";
		//$shopList = $this->db->query($sql,array($areaID))->result_array();
		$shopList = $this->db->query($sql,$userID)->result_array();
		return $shopList;
	}

	/**
	 * 获取商店的商品列表
	 * @author xanda
	 * @param string $shopID 商店ID
	 * @return list 水果列表
	 */	
	function getGoodListByShop($shopID) 
	{
		$sql = "SELECT DISTINCT shop_goods.ID, shopID, name, detail, price, priceType, priority, total, pic, available, createTime
				FROM shop_goods
				WHERE shop_goods.shopID = ?
				ORDER BY available DESC, priority DESC, total DESC";
		$goodsList = $this->db->query($sql,array($shopID))->result_array();
		return $goodsList;
	}

	/**
	 * 获取商店的可见活动列表
	 * @author xanda
	 * @param string $shopID 商店ID
	 * @return list 活动列表
	 */	
	function getActListByShop($shopID){
		$sql = "SELECT DISTINCT shop_act.ID, shopID, title, detail, createTime, deadline, note, address
				FROM shop_act 
				WHERE shopID=? AND available=1
				ORDER BY deadline DESC,createTime ASC";
		$actList = $this->db->query($sql,array($shopID))->result_array();
		return $actList;
	}


	/**
	 * 获取对应ID的商店的基本信息
	 * @author xanda
	 * @param string $shopID 商店ID
	 * @return shopInfo 水果店列表
	 */
	function getShopInfoByID($shopID){
		$sql = "SELECT shop_list.ID, name, phone, address, detail, available, createTime, userID, fruit
				FROM shop_list 
				WHERE ID = ?";
		$shopList = $this->db->query($sql,array($shopID))->result_array(); 
		if(count($shopList) == 0) return errorMessage(-1,'Error Shop ID.');
		return $shopList[0];
	}

	/**
	 * 标记某商品被购买/退购一次
	 * @author Hewr
	 * @author xanda
	 * @param cargoID
	 */
	function plusTotal($goodID, $delta, $fruit) {
		$sql = "SELECT `total` FROM `shop_goods` WHERE `id`=".$goodID;
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		$cnt = intval($arr[0]["total"]) + intval($delta);
		$sql = "UPDATE `shop_goods` SET `total`=".$cnt." WHERE `id`=".$goodID;
		$res = $this->db->query($sql) or die(mysql_error());
	}

	/**
	 * 提交用户订单
	 * @author Hewr
	 * @author xanda
	 * @param shopID shopname userID goodsList totalMoney
	 */
	function submitOrder($shopID, $shopname, $userID, $list, $amount) {

		$sql = "INSERT INTO `shop_order`
				(`shopID`, `shopName`, `userID`, `goodsList`, `amount`) 
				VALUES (".$shopID.", '".$shopname."', ".$userID.", '".addslashes(json_encode($list))."', ".$amount.")";
		$res = $this->db->query($sql) or die(mysql_error());
	}

	/**
	 * 返回所有订单
	 * @author Hewr
	 * @author xanda
	 * @param username
	 * @return 订单
	 */
	function getAllOrders($userID) {
		$sql = "SELECT * FROM `shop_order` WHERE `userID`=".$userID." and `available`=1 ORDER BY -`ID`";
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		foreach ($arr as $key => $value) {
			$arr[$key]["goodsList"] = json_decode($arr[$key]["goodsList"]);
		}
		return $arr;
	}


	/**
	 * 新增一个商店
	 * @author Hewr
	 * @author xanda
	 * @param array $shop $userID
	 */
	function addShop($shop, $userID) {
		$val = array(
			'name' => $shop["name"],
			'phone'=> $shop["phone"],
			'address' => $shop["address"],
			'detail' => $shop["detail"],
			'fruit' => $shop["type"],
			'userID' => $userID);
		$this->db->insert('shop_list',$val);
		return $this->db->insert_id();
	}

	/**
	* 删除商店
	* @author xanda
	* @param $id
	*/
	public function deleteShopById($id) {
		$tmp = $this->db->from('shop_list')->where('ID', $id)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (isset($_SESSION["userID"]) && $user == $_SESSION["userID"]) {
			$this->db->where('ID',$id)->update('shop_list', array('available'=>0));
		} else
			$this->permission_model->noPermission(1);
	}

	/**
	 * 修改一个商店
	 * @author Hewr
	 * @author xanda
	 * @param shop array userID
	 */
	function modifyShop($shop, $userID) {
		$this->db->where('ID',$shop["ID"])->update('shop_list',
			array('name'=>$shop["name"],
				'address'=>$shop["address"],
				'phone'=>$shop["phone"],
				'detail'=>$shop["detail"],
				'fruit'=>$shop["type"]));
	}

	/**
	 * 添加商店所属群组
	 * @author LJNanest
	 */
	function addShopGroup($shopID, $groupID) 
	{
		$sql = 'SELECT DISTINCT userID FROM shop_list WHERE ID = ?';
		$tmp = $this->db->query($sql,array($shopID))->result_array();
		if ($tmp[0]['userID'] != $_SESSION['userID']) return;
		$item = array('shopID' => $shopID, 'groupID' => $groupID, 'state' => 1);
		$this->db->insert('shop_group',$item);
	}

	function addGoods($shopID,$name,$price,$detail)
	{
		$sql = 'SELECT DISTINCT userID FROM shop_list WHERE ID = ?';
		$tmp = $this->db->query($sql,array($shopID))->result_array();
		if ($tmp[0]['userID'] != $_SESSION['userID']) return;
		$item = array('shopID'=>$shopID, 'name' => $name, 'price' => $price, 'detail' => $detail);
		$this->db->insert('shop_goods',$item);	
		return $this->db->insert_id();
	}

	function delGoods($goodsID)
	{
		$sql = 'SELECT DISTINCT shop_list.userID FROM shop_list,shop_goods WHERE shop_list.ID = shop_goods.shopID AND shop_goods.ID = ?';
		$tmp = $this->db->query($sql,array($goodsID))->result_array();
		if ($tmp[0]['userID'] != $_SESSION['userID']) return 1;
		$sql = "DELETE FROM shop_goods WHERE ID = ?";
		$this->db->query($sql,array($goodsID));

	}	

}
