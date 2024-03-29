<?php

class goods_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}


	function getGoodsInfo($goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		return $tmp[0];
	}

	function getGoodsListByUser()
	{
		$tmp = $this->db->from('goods_list')->where('userID', $_SESSION['userID'])->where('available',1)->get()->result_array();
		return $tmp;	
	}


	/*
	*  新增商品
	*  @author LJNanest
	*  $name,$detail,$price,$priceType,$pic
	*/
	function addGoods($goodsInfo)
	{
		if (isset($_SESSION["userID"]))
		{
			$newItem = array(
				'userID' => $_SESSION["userID"],
				'name' => $goodsInfo['name'],
				'detail' => $goodsInfo['detail'],
				'price' => $goodsInfo['price'],
				'priceType' => $goodsInfo['priceType'],
				'pic' => $goodsInfo['pic']
				);
			$this->db->insert('goods_list',$newItem);
			return $this->db->insert_id();
		}
	}

	function modGoods($goodsInfo,$goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (isset($_SESSION["userID"]) && $user == $_SESSION["userID"]) {
			$newItem = array('name' => $goodsInfo['name'],
				'detail' => $goodsInfo['detail'],
				'price' => $goodsInfo['price'],
				'priceType' => $goodsInfo['priceType'],
				'pic' => $goodsInfo['pic']);
			$this->db->where('ID',$goodsID)->update('goods_list', $newItem);
		} else
			$this->permission_model->noPermission(1);
	}
		

	function delGoods($goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (isset($_SESSION["userID"]) && $user == $_SESSION["userID"]) {
			$this->db->where('ID',$goodsID)->update('goods_list', array('available'=>0));
		} else
			$this->permission_model->noPermission(1);
	}

	private function addGoodsAtOBJ($goodsListByJSon,$goodsID,$price)	
	{
		$goodsList = json_decode($goodsListByJSon,true);
		$goodsList[$goodsID] = $price;
		return json_encode($goodsList);
	}

	private function delGoodsAtOBJ($goodsListByJSon,$goodsID)
	{
		$goodsList = json_decode($goodsListByJSon,true);
		if (isset($goodsList[$goodsID])) 
			unset($goodsList[$goodsID]);
		return json_encode($goodsList);
	}

	function getGoodsListByOBJ($goodslist)
	{
		$sql = "SELECT DISTINCT * FROM goods_list WHERE available = 1 AND ( ID = 0 ";
		foreach ($goodslist as $goodsID=>$price)
		{
			$sql = $sql."OR ID = ".$goodsID." ";
		}
		$sql = $sql." ) ORDER BY priority DESC,total DESC";
		$goodsInfoList = $this->db->query($sql)->result_array();
//		foreach ($goodsInfoList as $key=>$goodsInfo)
//		{
//			$goodsInfoList[$key]['price'] = $goodslist[$goodsInfo['ID']];
//		}		
		return $goodsInfoList;
	}

	function getGoodsListByGroupbuy($groupbuyID)
	{
		$tmp = $this->db->from('groupbuy_list')->where('ID', $groupbuyID)->get()->result_array();
		$GL = json_decode($tmp[0]['goodslist'],true);
		return $this->getGoodsListByOBJ($GL);
		/*$goodsList = array();
		foreach ($GL as $goodsID=>$price)
		{
			$goodsInfo = $this->getGoodsInfo($goodsID);
			$goodsInfo['price'] = $price;
			array_push($goodsList, $goodsInfo);
		}

		return $goodsList;*/
	}


	function addGoodsAtGroupbuy($groupbuyID,$goodsID,$price)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
		if ($pirce = -1) $price = $tmp[0]['price'];
		$tmp = $this->db->from('groupbuy_list')->where('ID', $groupbuyID)->get()->result_array();		
		$newItem = array('goodslist' => $this->addGoodsAtOBJ($tmp[0]['goodslist'],$goodsID,$price));
		$this->db->where('ID',$groupbuyID)->update('groupbuy_list', $newItem);
	}

	function delGoodsAtGroupbuy($groupbuyID,$goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
		$tmp = $this->db->from('groupbuy_list')->where('ID', $groupbuyID)->get()->result_array();
		$newItem = array('goodslist' => $this->delGoodsAtOBJ($tmp[0]['goodslist'],$goodsID));
		$this->db->where('ID',$groupbuyID)->update('groupbuy_list', $newItem);
	}

	function getGoodsListByShop($shopID)
	{
		$tmp = $this->db->from('shop_list')->where('ID', $shopID)->get()->result_array();
		$GL = json_decode($tmp[0]['goodslist'],true);
		return $this->getGoodsListByOBJ($GL);
		/*$goodsList = array();
		foreach ($GL as $goodsID=>$price)
		{
			$goodsInfo = $this->getGoodsInfo($goodsID);
			$goodsInfo['price'] = $price;
			array_push($goodsList, $goodsInfo);
		}

		return $goodsList;*/
	}

	function addGoodsAtShop($shopID,$goodsID,$price)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
		if ($pirce = -1) $price = $tmp[0]['price'];
		$tmp = $this->db->from('shop_list')->where('ID', $shopID)->get()->result_array();		
		$newItem = array('goodslist' => $this->addGoodsAtOBJ($tmp[0]['goodslist'],$goodsID,$price));
		$this->db->where('ID',$shopID)->update('shop_list', $newItem);
	}

	function delGoodsAtShop($shopID,$goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
		$tmp = $this->db->from('shop_list')->where('ID', $shopID)->get()->result_array();
		$newItem = array('goodslist' => $this->delGoodsAtOBJ($tmp[0]['goodslist'],$goodsID));
		$this->db->where('ID',$shopID)->update('shop_list', $newItem);
	}

	/**
	/**
	 * 更新商品历史销售量
	 * @author Hewr
	 */
	function increaseGoodsTotal($goodsID, $delta) {
		$sql = "UPDATE `goods_list` SET `total`=`total`+? WHERE `ID`=?";
		$this->db->query($sql, array($delta, $goodsID));
	}

    function newTypeByGoodsID($goodsID,$type,$level)
    {
        if ($level != 1 && $level != 2 && $level != 3) return;
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
        $typeList = json_decode($tmp[0]['typeList'.$level],true);
        array_push($typeList,$type);
        $newItem = array('typeList'.$level=>json_encode($typeList));
        $this->db->where('ID',$goodsID)->update('goods_list',$newItem);
        return json_encode($typeList);
    }

    function delTypeByGoodsID($goodsID,$type,$level)
    {
        if ($level != 1 && $level != 2 && $level != 3) return;
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
        $typeList = json_decode($tmp[0]['typeList'.$level],true);
        $tmp = array();
        foreach ($typeList as $x)
            if ($x != $type)
                {
                    array_push($tmp,$x);
                }
        $newItem = array('typeList'.$level=>json_encode($tmp));
        $this->db->where('ID',$goodsID)->update('goods_list',$newItem);
        return json_encode($tmp);      
    }
    
    function getTypeListByGoodsID($goodsID,$level)
    {
        $tmp = $this->db->from('goods_list')->where('ID',$goodsID)->get()->result_array();
        return json_decode($tmp[0]['typeList'.$level],true);
    }
}

?>
