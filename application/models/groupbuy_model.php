<?php

class groupbuy_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function wtf() {
		$sql = "SELECT `ID`,`class` FROM `user_list`";
		$res = $this->db->query($sql)->result_array();
		foreach ($res as $key => $value) {
			$id = intval($value["ID"]);
			$class = $value["class"];
			
			$sql = "SELECT `groupID` from `group_list` WHERE `class`=?";
			$res2 = $this->db->query($sql, array($class))->result_array();
			$classID = intval($res2[0]["groupID"]);
			
			$sql = "INSERT INTO `member_list`(`userID`,`groupID`,`roles`) VALUES(?,?,2)";
			$this->db->query($sql, array($id, $classID));

			$gradeID = substr($classID, 0, 9)."0000";
			$sql = "INSERT INTO `member_list`(`userID`,`groupID`,`roles`) VALUES(?,?,2)";
			$this->db->query($sql, array($id, $gradeID));
		}
	}

	/**
	 * 返回团购的所有群组ID
	 * @author Hewr
	 * @param groupbuyID
	 */
	function getShopGroupID($shopID) {
		$shopID = intval($shopID);
		$sql = "SELECT `groupID` FROM `groupbuy_act` WHERE `groupbuyID`=".$shopID;
		$res = $this->db->query($sql)->result_array();
		return $res;
	}

	/**
	 * 获取商品所属团购ID
	 * @author Hewr
	 * @param $cargoID
	 */
	function getCargoShopID($cargoID) {
		$cargoID = intval($cargoID);
		$sql = "SELECT `shopid` FROM `cargo_list` WHERE `id`=".$cargoID;
		$res = $this->db->query($sql)->result_array();
		return intval($res[0]["shopid"]);
	}

	/**
	 * 分割群组列表并检查权限
	 * @author Hewr
	 * @param 逗号分割的群组列表
	 */
	function splitGroupStr($content) {
		$arr = array("header");
		$now = ""; $i = 0;
		while ($i < strlen($content)) {
			if ($content[$i] == ";") {
				if (!$this->isOwnGroup($now)) return array();
				array_push($arr, $now);
				$now = "";
			} else {
				$now .= $content[$i];
			}
			++$i;
		}
		if (strcmp($now, "") != 0) return array();
		return $arr;
	}

	/**
	 * 返回用户是否为制定群组的管理员
	 * @author Hewr
	 * @param groupID
	 */
	function isOwnGroup($groupID) {
		return $this->permission_model->checkPermission($groupID, BUSINESS_PUBLIC, 0);
	}

	/**
	 * 返回用户是否为团购商店创建者
	 * @author Hewr
	 * @param shopID
	 */
	function isOwnShop($shopID) {
		if (!isset($_SESSION["loginName"])) return false;
		$username = $_SESSION["loginName"];
		$shopID = intval($shopID);
		$sql = "SELECT `username` FROM `groupbuy_list` WHERE `id`=".$shopID;
		$res = $this->db->query($sql)->result_array();
		$owner = $res[0]["username"];
		return strcmp($owner, $username) == 0;
	}

	/**
	 * 新增一个团购
	 * @author Hewr
	 * @param array $shop $userName
	 */
	function insertShop($shop, $userName) {
		$sql = "INSERT INTO `groupbuy_list`
				(`title`, `status`, `comment`, `howtopay`, `illustration`, `deadline`, `pickuptime`, `source`, `username`,`orderMessage` ) 
				VALUES(?,?,?,?,?,?,?,?,?,?)";
		$res = $this->db->query($sql, array(cleanString($shop['title']), $shop['status'], cleanString($shop['comment']), cleanString($shop['howtopay']), cleanString($shop['illustration']), cleanString($shop['deadline']), cleanString($shop['pickuptime']), cleanString($shop['source']), $userName,$shop['orderMessage'])) or die(mysql_error());
        $shopID = $this->db->insert_id();
        $this->load->model('groupfeed_model','feed');
        $this->feed->addFeedItem(1,
                                 $shop['title'],
                                 $_SESSION['userID'],
                                 nowTime(),
                                 '/storage/groupbuyPic/pic_'.$shopID.'.jpg',
                                 $shop['illustration'],
                                 '/groupbuy/groupInfo?id='.$shopID,
                                 $shopID,
                                 '{}');
        $groupList = explode(';',$shop['group_list']);
        foreach($groupList as $key => $groupID){
            if(!isGID($groupID)) continue;
            $this->db->insert('groupbuy_act', array('groupbuyID'=>$shopID,'groupID'=>$groupID,'state'=>1));
            if($this->permission_model->manageGroup($groupID)){
                $this->feed->sendFeed(1,$shopID,$groupID,1);
            }else{
                $this->feed->sendFeed(1,$shopID,$groupID,0);
            }
        }

		return $shopID;
	}

    /**
     * 根据团购ID获取相应订单
     * @author ca007
     */
    function getOrderByGbID($gbID){
        $tmp = $this->db->from('groupbuy_list')->where('ID',$gbID)->get()->result_array();
        if(!count($tmp)){
            return array();
        }
        $tmp_username = $tmp[0]['username'];
        
        $groupIDListA = array();
        $tmp = $this->db->from('member_list')->where('userID',$_SESSION['userID'])->where('roles',4)->get()->result_array();
        foreach ($tmp as $k=>$v)
            {
                array_push($groupIDListA,$v['groupID']);
            }
        array_unique($groupIDListA);
        $groupIDListB = array();
        $tmp = $this->db->from('groupbuy_act')->where('groupbuyID',$gbID)->where('state',1)->get()->result_array();
        foreach ($tmp as $k=>$v)
            {
                array_push($groupIDListB,$v['groupID']);
            }
        array_unique($groupIDListB);
        $groupIDList = array_intersect($groupIDListA,$groupIDListB);
        if (count($groupIDList) == 0 && $tmp_username != $_SESSION['loginName']) {
            $this->permission_model->noPermission(1);
        }

        $sql = "select groupbuy_order.ID, realName,`list`,amount,class, user_list.phoneNumber,user_list.address,defaultGroupID,comment,orderMessage 
            from user_list,groupbuy_order 
            where userID=user_list.ID and shopid=? and del=0 
            order by class asc";
        $order_list = $this->db->query($sql,array($gbID))->result_array();
        foreach($order_list as $key => $order){
            $order_list[$key]['list'] = json_decode($order_list[$key]['list']);
        }
        return $order_list;
    }
    
    /**
     * 根据用户ID获取团购
     * @author ca007
     * @param string $userID
     */
    function getGroupbuyByID($userID){
        $sql = "select groupbuy_list.ID,title,username,goodslist,createTime from user_list,groupbuy_list where username=user_list.loginName and user_list.ID=? and available=1 order by groupbuy_list.createTime DESC";
        $groupbuy_list = $this->db->query($sql,array($userID))->result_array();
        return $groupbuy_list;
    }

    /**
     * 根据用户名称获取团购
     * @author Hewr
     * @param string $username
     */
    function getGroupbuyByUserName($username){
		$sql = "SELECT DISTINCT `id`,`title`,`status`,`comment`,`howtopay`,`illustration`,`deadline`,`pickuptime`,`source` FROM `groupbuy_list` WHERE `username`=? and available=1 order by groupbuy_list.createTime DESC";
        $groupbuy_list = $this->db->query($sql,array($username))->result_array();
        return $groupbuy_list;
    }

    /**
     * 根据用户名称获取团购
     * @author Hewr
     * @param string $username
     */
    function getGroupbuyByUserNameAndID($username, $id){
		$id = intval($id);
		$sql = "SELECT DISTINCT `id`,`title`,`status`,`comment`,`howtopay`,`illustration`,`deadline`,`pickuptime`,`source` FROM `groupbuy_list` WHERE `username`=? and `id`=?";
        $groupbuy_list = $this->db->query($sql,array($username, $id))->result_array();
		$sql = "SELECT `groupID` FROM `groupbuy_act` WHERE `groupbuyID`=?";
        $group_list = $this->db->query($sql,array($id))->result_array();
		$group_str = "";
		for ($i = 0; $i < count($group_list); ++$i) $group_str .= $group_list[$i]["groupID"].";";
		$groupbuy_list[0]["groups"] = $group_str;
		$groupbuy_list[0]["pic"] = "/storage/groupbuyPic/pic_".$id.".jpg";
        return $groupbuy_list;
    }

	/**
	 * 删除一个团购
	 * @author Hewr
	 * @param shopID userName
	 */
	function deleteShopById($id, $userName) {
		$sql = "UPDATE groupbuy_list SET available = 0  WHERE `id`=? and `username`=?";
		$res = $this->db->query($sql, array($id, $userName)) or die(mysql_error());
		$this->clearShopGroup($id);
	}

	/**
	 * 修改一个团购
	 * @author Hewr
	 * @param shop array userName
	 */
	function modifyShop($shop, $userName) {
		$sql = "UPDATE `groupbuy_list` SET `title`=?,`status`=?,`comment`=?,`howtopay`=?,`illustration`=?,`deadline`=?,`pickuptime`=?,`source`=?, `orderMessage`=? WHERE `id`=? and `username`=?";
		$res = $this->db->query($sql,array(cleanString($shop["title"]),$shop["status"],cleanString($shop["comment"]),cleanString($shop["howtopay"]),cleanString($shop["illustration"]),cleanString($shop["deadline"]),cleanString($shop["pickuptime"]),cleanString($shop["source"]),$shop["orderMessage"],$shop["id"],$userName)) or die(mysql_error());
        $this->load->model("groupfeed_model","feed");
        $this->feed->modifyFeedItem(1,
                                    $shop['title'],
                                    '/storage/groupbuyPic/pic_'.$shop['id'].'.jpg',
                                    $shop['illustration'],
                                    $shop['id'],
                                    '{}');
        $groupList = explode(';',$shop['group_list']);
	}

	/**
	 * 清空团购群组
	 * @author Hewr
	 * @param shopid
	 */
	function clearShopGroup($shopID) {
		$sql = "DELETE FROM `groupbuy_act` WHERE `groupbuyID`=".$shopID;
		$res = $this->db->query($sql) or die(mysql_error());
	}

	/**
	 * 给团购增加群组
	 * @author Hewr
	 * @param shopid groupID
	 */
	function shopJoinGroup($shopID, $groupID) {
		if (!$this->isOwnGroup($groupID)) return;
		$sql = "INSERT INTO `groupbuy_act`(`groupID`,`groupbuyID`) VALUES(?,?)";
		$res = $this->db->query($sql,array($groupID, $shopID)) or die(mysql_error());
	}

	/**
	 * 新增一个商品
	 * @author Hewr
	 * @param array $cargo $userName
	 */
	function insertCargo($cargo, $userName) {
		if (!$this->isOwnShop($cargo["shopid"])) return;
		$sql = "INSERT INTO `cargo_list`(`shopid`, `title`, `price`, `illustration`, `username`)  VALUES (?, ?, ?, ?, ?)";
		$res = $this->db->query($sql,array($cargo["shopid"], cleanString($cargo["title"]), $cargo["price"], cleanString($cargo["illustration"]), $userName)) or die(mysql_error());
	}

	/**
	 * 修改一个商品
	 * @author Hewr
	 * @param array $cargo $userName
	 */
	function modifyCargo($cargo, $userName) {
		if (!$this->isOwnShop($this->getCargoShopId($cargo["id"]))) return;
		$sql = "UPDATE `cargo_list` SET `title`=?,`price`=?,`illustration`=? WHERE `id`=? and `username`=?";
		$res = $this->db->query($sql,array(cleanString($cargo["title"]),floatval($cargo["price"]),cleanString($cargo["illustration"]),$cargo["id"],$userName)) or die(mysql_error());
	}

	/**
	 * 删除一个商品
	 * @author Hewr
	 * @param $cargoID $userName
	 */
	function deleteCargoById($cargoId, $userName) {
		if (!$this->isOwnShop($this->getCargoShopId($cargoId))) return;
		$sql = "DELETE FROM `cargo_list` WHERE `id`=? and `username`=?";
		$res = $this->db->query($sql, array($cargoId,$userName)) or die(mysql_error());
	}

	/**
	 * 标记某商品被购买/退购一次
	 * @author Hewr
	 * @param cargoID
	 */
	function plusCargo($cargoid, $delta) {
		$sql = "SELECT `howmanybuy` FROM `cargo_list` WHERE `id`=".$cargoid;
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		$cnt = intval($arr[0]["howmanybuy"]) + intval($delta);
		$sql = "UPDATE `cargo_list` SET `howmanybuy`=".$cnt." WHERE `id`=".$cargoid;
		$res = $this->db->query($sql) or die(mysql_error());
	}

	/**
	 * 检查团购商店是否过期
	 * @author Hewr
	 * @param list 商店信息
	 * @return boolean
	 */
	function shopAlive($shop) {
		$now = mktime();
		$ddl = strtotime($shop["deadline"]);
		return $now < $ddl;
	}

	/**
	 * 标记团购商店已经过期
	 * @author Hewr
	 * @param shopid
	 */
	function expireShop($id) {
		$sql = "UPDATE `groupbuy_list` SET `status`=0 WHERE `id`=".$id;
		$res = $this->db->query($sql) or die(mysql_error());
	}

	/**
	 * 返回所有团购商店
	 * @author Hewr
	 * @return list 商店
	 */
	function getAllShops() {
		$sql = "SELECT DISTINCT groupbuy_list.`id`,`title`,`status`,`comment`,`howtopay`,`illustration`,`deadline`,`pickuptime`,`source` FROM `groupbuy_list`,`groupbuy_act` WHERE groups_list.available = 1 and groupbuy_list.`id`=groupbuy_act.`groupbuyID` and (";
		$count = 0;
		foreach ($_SESSION["myGroup"] as $groupID => $groupInfo) {
			if ($count > 0) $sql .= " or ";
			$sql .= "groupbuy_act.`groupID`=".$groupID;
			++$count;
		}
		$sql .= ") ORDER BY groupbuy_list.`id`";
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		foreach ($arr as $key => $value) {
			if ($arr[$key]["status"] == 1 && !$this->shopAlive($arr[$key])) {
				$arr[$key]["status"] = 0;
				$this->expireShop($arr[$key]["id"]);
			}
			$arr[$key]["pic"] = "/storage/groupbuyPic/pic_".$arr[$key]["id"].".jpg";
		}
		return $arr;
	}

	/**
	 * 返回指定团购商店
	 * @author Hewr
	 * @param shopID
	 * @return 商店
	 */
	function getShopById($id) {
		$id = intval($id);
		if ($this->isOwnShop($id)) {
	    	return $this->getGroupbuyByUserNameAndID($_SESSION["loginName"], $id);
		}
        /**
           $sql = "SELECT DISTINCT groupbuy_list.`id`,`title`,`status`,`comment`,`howtopay`,`illustration`,`deadline`,`pickuptime`,`source`,goodslist,createTime FROM `groupbuy_list`,`groupbuy_act` WHERE groupbuy_list.`id`=".$id." and groupbuy_list.`id`=groupbuy_act.`groupbuyID` and (";
           $count = 0;
           foreach ($_SESSION["myGroup"] as $groupID => $groupInfo) {
           if ($count > 0) $sql .= " or ";
           $sql .= "groupbuy_act.`groupID`=".$groupID;
           ++$count;
           }
           $sql .= ") ORDER BY groupbuy_list.`id`";
        **/
		$sql = "SELECT DISTINCT groupbuy_list.`id`,`title`,`status`,`comment`,`howtopay`,`illustration`,`deadline`,`pickuptime`,`source`,goodslist,createTime FROM `groupbuy_list`,`groupbuy_act` WHERE groupbuy_list.`id`=".$id." and groupbuy_list.`id`=groupbuy_act.`groupbuyID` ORDER BY groupbuy_list.`id`";
        
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		foreach ($arr as $key => $value) {
			if ($arr[$key]["status"] == 1 && !$this->shopAlive($arr[$key])) {
				$arr[$key]["status"] = 0;
				$this->expireShop($arr[$key]["id"]);
			}
			$arr[$key]["pic"] = "/storage/groupbuyPic/pic_".$arr[$key]["id"].".jpg";
		}
		return $arr;
	}

	/**
	 * 返回指定商店的所有商品
	 * @author Hewr
	 * @param shopID
	 * @return list 商品
	 */
	function getCargoByShopId($shopid) {
		$shopid = intval($shopid);
		if ($this->isOwnShop($shopid)) {
			$sql = "SELECT `id`,`title`,`price`,`illustration`,`howmanybuy` FROM `cargo_list` WHERE `shopid`=".$shopid." ORDER BY `id`";
		} else {
			$sql = "SELECT cargo_list.`id`,`title`,`price`,`illustration`,`howmanybuy` FROM `cargo_list`,`groupbuy_act` WHERE `shopid`=".$shopid." and groupbuy_act.`groupbuyID`=".$shopid." and (";
			$count = 0;
			foreach ($_SESSION["myGroup"] as $groupID => $groupInfo) {
				if ($count > 0) $sql .= " or ";
				$sql .= "groupbuy_act.`groupID`=".$groupID;
				++$count;
			}
			$sql .= ") ORDER BY `id`";
		}
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		return $arr;
	}

	/**
	 * 返回指定商品
	 * @author Hewr
	 * @param cargoID
	 * @return 商品
	 */
	function getCargoById($id) {
		$id = intval($id);
		$shopid = $this->getCargoShopID($id);
		if ($this->isOwnShop($shopid)) {
			$sql = "SELECT `id`,`title`,`price`,`illustration`,`howmanybuy` FROM `cargo_list` WHERE `id`=".$id;
		} else {
			$sql = "SELECT cargo_list.`id`,`title`,`price`,`illustration`,`howmanybuy` FROM `cargo_list`,`groupbuy_act` WHERE `id`=".$id." and `shopid`=".$shopid." and groupbuy_act.`groupbuyID`=".$shopid." and (";
			$count = 0;
			foreach ($_SESSION["myGroup"] as $groupID => $groupInfo) {
				if ($count > 0) $sql .= " or ";
				$sql .= "groupbuy_act.`groupID`=".$groupID;
				++$count;
			}
			$sql .= ")";
		}
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		return $arr;
	}

	/**
	 * 提交用户订单
	 * @author Hewr
	 * @param shopID shopname username cargoList totalMoney comment
	 */
	function submitOrder($shopid, $shopname, $username, $list, $amount, $comment,$orderMessage) {
		if (count($this->getShopById($shopid)) == 0) return;
		$sql = "INSERT INTO `groupbuy_order`(`shopid`, `shopname`, `username`, `list`, `amount`, `createtime`, `userID`, `comment`,`orderMessage`) VALUES(?,?,?,?,?,?,?,?,?)";
		$res = $this->db->query($sql,array($shopid,$shopname,$username,json_encode($list),$amount,date("Y-m-d H:i:s", mktime()), $_SESSION['userID'], $comment,$orderMessage)) or die(mysql_error());
	}

	/**
	 * 返回所有订单
	 * @author Hewr
	 * @param username
	 * @return 订单
	 */
	function getAllOrders($username) {
		$sql = "SELECT `id`,`shopid`,`list`,`amount`,`shopname`,`createtime`,`comment`,`orderMessage` FROM `groupbuy_order` WHERE `username`=? and `del`=0 ORDER BY -`id`";
		$res = $this->db->query($sql,array($username)) or die(mysql_error());
		$arr = $res->result_array();
		foreach ($arr as $key => $value) {
			$arr[$key]["list"] = json_decode($arr[$key]["list"]);
		}
		return $arr;
	}

	/**
	 * 返回某张订单
	 * @author Hewr
	 * @param orderid
	 * @return 订单
	 */
	function getOrderById($id) {
		$sql = "SELECT * FROM `groupbuy_order` WHERE `id`=".$id;
		$res = $this->db->query($sql) or die(mysql_error());
		$arr = $res->result_array();
		foreach ($arr as $key => $value) {
			$arr[$key]["list"] = json_decode($arr[$key]["list"]);
		}
		return $arr;
	}


	/**
	 * 返回某张订单信息和用户电话
	 * @author daiwentao
	 * @param orderid
	 * @return 订单及用户手机号
	 */
	function getOrderAndPhoneById($id) {
		$sql = "SELECT shopid,phoneNumber,amount FROM user_list,groupbuy_order 
			WHERE groupbuy_order.userID=user_list.ID AND groupbuy_order.id='".$id."'";
		$res = $this->db->query($sql)->row_array();
		return $res;
	}

	/**
	 * 删除某张订单
	 * @author Hewr
	 * @param orderid
	 */
	function deleteOrderById($id) {
		$sql = "UPDATE `groupbuy_order` SET `del`=1 WHERE `id`=".$id;
		$res = $this->db->query($sql) or die(mysql_error());
	}


	/**
	 * @author LJNanest
	 */

	function getGroupbuyInfoByID($groupbuyID)
	{
		$tmp = $this->db->from('groupbuy_list')->where('ID', $groupbuyID)->get()->result_array();
		return $tmp[0];
	}

	/**
	 * @author LJNanest
	 */

	function updataGoodsList($groupbuyID,$JsonGoodsList)
	{
		$sql = "UPDATE `groupbuy_list` SET goodslist =? WHERE `ID`=".$groupbuyID;
		$res = $this->db->query($sql,array($JsonGoodsList));
	}	

    function getGroupListByID($groupbuyID)
    {
        $tmp = $this->db->from('groupbuy_act')->where('groupbuyID',$groupbuyID)->get()->result_array();
        $groupList = array();
        foreach ($tmp as $key=>$value)
            {
                array_push($groupList,$value['groupID']);
            }
        return $groupList;
    }

    /**
     * 获取用户发布的团购以及所合作的团购列表,供查询订单使用
     * @author LJNanest
     */
    function getGroupbuyListByUserID($userID)
    {
        $groupbuyIDList = array();
        $manager_list = $this->db->from('member_list')->where('userID',$userID)->where('roles',4)->get()->result_array();
        foreach ($manager_list as $key=>$value)
            {
                $groupID = $value['groupID'];
                $tmp = $this->db->from('groupbuy_act')->where('groupID',$groupID)->where('state',1)->get()->result_array();
                foreach ($tmp as $k => $v)
                    {
                        array_push($groupbuyIDList,$v['groupbuyID']);
                    }
            }
        array_unique($groupbuyIDList);
        $sql = "SELECT DISTINCT groupbuy_list.ID,title,username,goodslist,createTime FROM user_list, groupbuy_list WHERE (groupbuy_list.username = user_list.loginName AND user_list.ID = ? AND available = 1)";
        foreach ($groupbuyIDList as $key => $groupbuyID)
            {
                $sql = $sql." OR (groupbuy_list.ID = ".$groupbuyID." AND available = 1)";
            }
        $sql = $sql." ORDER BY groupbuy_list.createTime DESC";
        $groupbuyList = $this->db->query($sql,array($userID))->result_array();
        foreach($groupbuyList as $k => $v){
            $groupbuyList[$k]['total'] = $this->getGroupbuyTotalByID($v['ID']);
        }
        return $groupbuyList;
    }

    function getGroupbuyTotalByID($gbID){
        $sql = "select count(*) from groupbuy_order where shopid=? and del=0";
        $totalNum = $this->db->query($sql, array($gbID))->row_array();
        return $totalNum['count(*)'];
    }
   
    function addOrderMessage($gbID,$Message)
    {
        $tmp = $this->db->from('groupbuy_list')->where('ID',$gbID)->get()->result_array();
        $orderMessageList = json_decode($tmp[0]['orderMessage'],true);
        array_push($orderMessageList,$Message);
        $newItem = array('orderMessage'=>json_encode($orderMessageList));
        $this->db->where('ID',$gbID)->update('groupbuy_list',$newItem);
        return json_encode($orderMessageList);
    }

    function delOrderMessage($gbID,$Message)
    {
        $tmp = $this->db->from('groupbuy_list')->where('ID',$gbID)->get()->result_array();
        $orderMessageList = json_decode($tmp[0]['orderMessage'],true);
        $tmp = array();
        foreach ($orderMessageList as $x)
            if ($x != $Message)
                {
                    array_push($tmp,$x);
                }
        $newItem = array('orderMessage'=>json_encode($tmp));
        $this->db->where('ID',$gbID)->update('groupbuy_list',$newItem);
        return json_encode($tmp);      
    }

    function getOrderMessageList($gbID)
    { 
        $tmp = $this->db->from('groupbuy_list')->where('ID',$gbID)->get()->result_array();
        return json_decode($tmp[0]['orderMessage'],true);
    }
}

?>
