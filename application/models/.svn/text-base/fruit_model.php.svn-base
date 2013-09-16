<?php

class fruit_model extends CI_Model{
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
				WHERE shop_list.ID = shop_group.shopID
				AND shop_list.fruit = 1
				AND shop_list.available = 1
				AND (";
		$arrayID = array();
		foreach($groupList as $i => $group) {
			$sql .= "(groupID=?) OR ";
			array_push($arrayID,$i);
		}
		$sql = substr($sql,0,strlen($sql) - 4);
		$sql .=	")";
		//$shopList = $this->db->query($sql,array($areaID))->result_array();
		$shopList = $this->db->query($sql,$arrayID)->result_array();
		return $shopList;
	}


	/**
	 * 获取商店的水果列表
	 * @author LJNanest
	 * @author xanda
	 * @param string $shopID 商店ID
	 * @return list 水果列表
	 */	
	function getFruitListByShop($shopID) 
	{
		$sql = "SELECT DISTINCT shop_goods.ID, shopID, name, detail, price, priceType, priority, total, pic, available, createTime
				FROM shop_goods
				WHERE shop_goods.shopID = ?
				ORDER BY available DESC, priority DESC, total DESC";
		$fruitList = $this->db->query($sql,array($shopID))->result_array();
		return $fruitList;
	}

	/**
	 * 获取商店的可见活动列表
	 * @author ca007
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
	 * @author ca007
	 * @author xanda
	 * @param string $shopID 商店ID
	 * @return shopInfo 水果店列表
	 */
	function getShopInfoByID($shopID){
		$sql = "SELECT shop_list.ID, name, phone, address, detail, available, createTime, userID
				FROM shop_list 
				WHERE ID = ?";
		$shopList = $this->db->query($sql,array($shopID))->result_array(); 
		if(count($shopList) == 0) return errorMessage(-1,'Error Shop ID.');
		return $shopList[0];
	}

}
