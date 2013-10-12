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

	function addGoodsAtOBJ($goodsListByJSon,$goodsID,$price)	
	{
		$goodsList = json_decode($goodsListByJSon,true);
		$goodsList[$goodsID] = $price;
		return json_encode($goodsList);
	}

	function delGoodsAtOBJ($goodsListByJSon,$goodsID)
	{
		$goodsList = json_decode($goodsListByJSon,true);
		if (isset($goodsList[$goodsID])) 
			unset($goodsList[$goodsID]);
		return json_encode($goodsList);
	}

	function getGoodsListByGroupbuy($groupbuyID)
	{
		$tmp = $this->db->from('groupbuy_list')->where('ID', $groupbuyID)->get()->result_array();
		$GL = json_decode($tmp[0]['goodslist'],true);
		$goodsList = array();
		foreach ($GL as $goodsID=>$price)
		{
			$goodsInfo = $this->getGoodsInfo($goodsID);
			$goodsInfo['price'] = $price;
			array_push($goodsList, $goodsInfo);
		}
		return $goodsList;
	}

	function addGoodsAtGroupbuy($groupbuyID,$goodsID,$price)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (!isset($_SESSION["userID"]) || $user != $_SESSION["userID"]) return;
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
}

?>
