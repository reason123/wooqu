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
				WHERE shop_list.ID = shop_group.shopID AND (";
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
		$sql = "SELECT DISTINCT shop_list.ID, name, phone, address, detail, createTime, available
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
		$sql = "SELECT *
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
	function submitOrder($shopID, $shopname, $userID, $list, $amount,$inputItem,$orderMessage) {

		$sql = "INSERT INTO `shop_order`
				(`shopID`, `shopName`, `userID`, `goodsList`, `amount`,`inputItem`,`orderMessage`) 
				VALUES (".$shopID.", '".$shopname."', ".$userID.", '".addslashes(json_encode($list))."', ".$amount.", ?,?)";
		$res = $this->db->query($sql,array(cleanString($inputItem),cleanString($orderMessage))) or die(mysql_error());
        
        $sql = "SELECT total FROM feed_list WHERE type=2 AND sourceID = ?";
        $num = $this->db->query($sql,array($shopID))->result_array();
        
        $sql = "UPDATE feed_list SET total=? WHERE type=2 AND sourceID = ?";
        $this->db->query($sql,array($num[0]['total']+1,$shopID));

/*		$newItem = array(
				'shopID'=>$shopID,
				'shopName'=>$shopname,
				'userID'=>$userID,
                'goodsList'=>addslashes(json_encode($list)),
                'amount'=>$amount
			);
        $this->db->insert('shop_order',$newItem);*/
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
			'userID' => $userID,
            'inputItem' => $shop['inputItem']);
		$this->db->insert('shop_list',$val);
		$shopID = $this->db->insert_id();
        $this->load->model('groupfeed_model','feed');
        $this->feed->addFeedItem(2,
                                 $shop['name'],
                                 $_SESSION['userID'],
                                 nowTime(),
                                 '/storage/shopPic/pic_'.$shopID.'.jpg',
                                 $shop['detail'],
                                 '/shop/showShop?ID='.$shopID,
                                 $shopID,
                                 '{}');
        $groupList = explode(';',$shop['group_list']);
        foreach($groupList as $key => $groupID){
            if(!isGID($groupID)) continue;
            $this->db->insert('shop_group', array('shopID'=>$shopID,'groupID'=>$groupID,'state'=>1));
            if($this->permission_model->manageGroup($groupID)){
                $this->feed->sendFeed(2,$shopID,$groupID,1);
            }else{
                $this->feed->sendFeed(2,$shopID,$groupID,0);
            }
        }


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
		$this->db->where('ID',$shop["ID"])
            ->update('shop_list',array(
                         'name'=> cleanString($shop["name"]),
                         'address'=> cleanString($shop["address"]),
                         'phone'=> cleanString($shop["phone"]),
                         'detail'=> cleanString($shop["detail"])
                         ));
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
		$item = array('shopID'=> cleanString($shopID), 'name' =>  cleanString($name), 'price' => $price, 'detail' =>  cleanString($detail));
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

    /**
     * 根据商店ID获取相应订单
     * @author LJNanest
     */
    function getOrderByID($shopID){
        $tmp = $this->db->from('shop_list')->where('ID',$shopID)->get()->result_array();
        if(!count($tmp)){
            return array();
        }
        $tmp_userID = $tmp[0]['userID'];
        
        $groupIDListA = array();
        $tmp = $this->db->from('member_list')->where('userID',$_SESSION['userID'])->where('roles',4)->get()->result_array();
        foreach ($tmp as $k=>$v)
            {
                array_push($groupIDListA,$v['groupID']);
            }
        array_unique($groupIDListA);
        $groupIDListB = array();
        $tmp = $this->db->from('shop_group')->where('shopID',$shopID)->where('state',1)->get()->result_array();
        foreach ($tmp as $k=>$v)
            {
                array_push($groupIDListB,$v['groupID']);
            }
        array_unique($groupIDListB);
        $groupIDList = array_intersect($groupIDListA,$groupIDListB);
        if (count($groupIDList) == 0 && $tmp_userID != $_SESSION['userID']) {
            $this->permission_model->noPermission(1);
        }

        $sql = "select shop_order.*, user_list.realName,user_list.class, user_list.phoneNumber
            from user_list,shop_order 
            where userID=user_list.ID and shopid=? and shop_order.available=1 
            order by createTime asc";
        $order_list = $this->db->query($sql,array($shopID))->result_array();
        foreach($order_list as $key => $order){
            $order_list[$key]['goodsList'] = json_decode($order_list[$key]['goodsList']);
        }
        return $order_list;
    }

    /**
     * 获取用户发布的商店以及所合作的商店列表,供查询订单使用
     * @author LJNanest
     */
    function getshopListByManagerID($userID)
    {
        $shopIDList = array();
        $manager_list = $this->db->from('member_list')->where('userID',$userID)->where('roles',4)->get()->result_array();
        foreach ($manager_list as $key=>$value)
            {
                $groupID = $value['groupID'];
                $tmp = $this->db->from('shop_group')->where('groupID',$groupID)->where('state',1)->get()->result_array();
                foreach ($tmp as $k => $v)
                    {
                        array_push($shopIDList,$v['shopID']);
                    }
            }
        array_unique($shopIDList);
        $sql = "SELECT DISTINCT shop_list.*, user_list.realName,user_list.phoneNumber FROM user_list, shop_list WHERE (shop_list.userID = ? AND shop_list.userID = user_list.ID  AND available = 1)";
        foreach ($shopIDList as $key => $shopID)
            {
                $sql = $sql." OR (shop_list.ID = ".$shopID." AND shop_list.userID = user_list.ID AND available = 1)";
            }
        $sql = $sql." ORDER BY shop_list.createTime DESC";
        $shopList = $this->db->query($sql,array($userID))->result_array();
        return $shopList;
    }
    
    /**
     * 添加商店属性值
     * @author LJNanest
     */
    function addInputItem($shopID,$item)
    {
        $sql = "SELECT DISTINCT inputItem FROM shop_list WHERE ID=?";
        $temp = $this->db->query($sql,array($shopID))->result_array();
        $inputItem = json_decode($temp[0]['inputItem']);
        array_push($inputItem,$item);
        $sql = "UPDATE shop_list SET inputItem = ? WHERE ID=?";
        $this->db->query($sql,array(json_encode($inputItem),$shopID));
    }

    function getInputList($shopID)
    { 
        $sql = "SELECT DISTINCT inputItem FROM shop_list WHERE ID=?";
        $temp = $this->db->query($sql,array($shopID))->result_array();
        return $orderMessageList = json_decode($temp[0]['inputItem'],true);
    }

    
    function addOrderMessage($shopID,$Message)
    {
        $tmp = $this->db->from('shop_list')->where('ID',$shopID)->get()->result_array();
        $orderMessageList = json_decode($tmp[0]['orderMessage'],true);
        array_push($orderMessageList,$Message);
        $newItem = array('orderMessage'=>json_encode($orderMessageList));
        $this->db->where('ID',$shopID)->update('shop_list',$newItem);
        return json_encode($orderMessageList);
    }

    function delOrderMessage($shopID,$Message)
    {
        $tmp = $this->db->from('shop_list')->where('ID',$shopID)->get()->result_array();
        $orderMessageList = json_decode($tmp[0]['orderMessage'],true);
        $tmp = array();
        foreach ($orderMessageList as $x)
            if ($x != $Message)
                {
                    array_push($tmp,$x);
                }
        $newItem = array('orderMessage'=>json_encode($tmp));
        $this->db->where('ID',$shopID)->update('shop_list',$newItem);
        return json_encode($tmp);      
    }

    function getOrderMessageList($shopID)
    { 
        $tmp = $this->db->from('shop_list')->where('ID',$shopID)->get()->result_array();
        return json_decode($tmp[0]['orderMessage'],true);
    }

}

?>
